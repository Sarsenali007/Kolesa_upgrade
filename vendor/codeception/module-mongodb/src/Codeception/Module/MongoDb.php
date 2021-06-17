<?php
namespace Codeception\Module;

use Codeception\Lib\Interfaces\RequiresPackage;
use Codeception\Module as CodeceptionModule;
use Codeception\Configuration;
use Codeception\Exception\ModuleConfigException;
use Codeception\Exception\ModuleException;
use Codeception\Lib\Driver\MongoDb as MongoDbDriver;
use Codeception\TestInterface;

/**
 * Works with MongoDb database.
 *
 * The most important function of this module is cleaning database before each test.
 * To have your database properly cleaned you should configure it to access the database.
 *
 * In order to have your database populated with data you need a valid js file with data (of the same style which can be fed up to mongo binary)
 * File can be generated by RockMongo export command
 * You can also use directory, generated by ```mongodump``` tool or it's ```.tar.gz``` archive (not available for Windows systems), generated by ```tar -czf <archive_file_name>.tar.gz <path_to dump directory>```.
 * Just put it in ``` tests/_data ``` dir (by default) and specify path to it in config.
 * Next time after database is cleared all your data will be restored from dump.
 * The DB preparation should as following:
 * - clean database
 * - system collection system.users should contain the user which will be authenticated while script performs DB operations
 *
 * Connection is done by MongoDb driver, which is stored in Codeception\Lib\Driver namespace.
 * Check out the driver if you get problems loading dumps and cleaning databases.
 *
 * HINT: This module can be used with [Mongofill](https://github.com/mongofill/mongofill) library which is Mongo client written in PHP without extension.
 *
 * ## Status
 *
 * * Maintainer: **judgedim**, **davert**
 * * Stability: **beta**
 * * Contact: davert@codeception.com
 *
 * *Please review the code of non-stable modules and provide patches if you have issues.*
 *
 * ## Config
 *
 * * dsn *required* - MongoDb DSN with the db name specified at the end of the host after slash
 * * user *required* - user to access database
 * * password *required* - password
 * * dump_type *required* - type of dump.
 *   One of 'js' (MongoDb::DUMP_TYPE_JS), 'mongodump' (MongoDb::DUMP_TYPE_MONGODUMP) or 'mongodump-tar-gz' (MongoDb::DUMP_TYPE_MONGODUMP_TAR_GZ).
 *   default: MongoDb::DUMP_TYPE_JS).
 * * dump - path to database dump
 * * populate: true - should the dump be loaded before test suite is started.
 * * cleanup: true - should the dump be reloaded after each test.
 *   Boolean or 'dirty'. If cleanup is set to 'dirty', the dump is only reloaded if any data has been written to the db during a test. This is
 *   checked using the [dbHash](https://docs.mongodb.com/manual/reference/command/dbHash/) command.
 *
 */
class MongoDb extends CodeceptionModule implements RequiresPackage
{
    const DUMP_TYPE_JS = 'js';
    const DUMP_TYPE_MONGODUMP = 'mongodump';
    const DUMP_TYPE_MONGODUMP_TAR_GZ = 'mongodump-tar-gz';

    /**
     * @api
     * @var
     */
    public $dbh;

    /**
     * @var
     */

    protected $dumpFile;
    protected $isDumpFileEmpty = true;

    protected $dbHash;

    protected $config = [
        'populate'  => true,
        'cleanup'   => true,
        'dump'      => null,
        'dump_type' => self::DUMP_TYPE_JS,
        'user'      => null,
        'password'  => null,
        'quiet'     => false,
    ];

    protected $populated = false;

    /**
     * @var \Codeception\Lib\Driver\MongoDb
     */
    public $driver;

    protected $requiredFields = ['dsn'];

    public function _initialize()
    {

        try {
            $this->driver = MongoDbDriver::create(
                $this->config['dsn'],
                $this->config['user'],
                $this->config['password']
            );
        } catch (\MongoConnectionException $e) {
            throw new ModuleException(__CLASS__, $e->getMessage() . ' while creating Mongo connection');
        }

        // starting with loading dump
        if ($this->config['populate']) {
            $this->cleanup();
            $this->loadDump();
            $this->populated = true;
        }
    }

    private function validateDump()
    {
        if ($this->config['dump'] && ($this->config['cleanup'] or ($this->config['populate']))) {
            if (!file_exists(Configuration::projectDir() . $this->config['dump'])) {
                throw new ModuleConfigException(
                    __CLASS__,
                    "File with dump doesn't exist.\n
                    Please, check path for dump file: " . $this->config['dump']
                );
            }
            $this->dumpFile = Configuration::projectDir() . $this->config['dump'];
            $this->isDumpFileEmpty = false;

            if ($this->config['dump_type'] === self::DUMP_TYPE_JS) {
                $content = file_get_contents($this->dumpFile);
                $content = trim(preg_replace('%/\*(?:(?!\*/).)*\*/%s', "", $content));
                if (!sizeof(explode("\n", $content))) {
                    $this->isDumpFileEmpty = true;
                }
                return;
            }

            if ($this->config['dump_type'] === self::DUMP_TYPE_MONGODUMP) {
                if (!is_dir($this->dumpFile)) {
                    throw new ModuleConfigException(
                        __CLASS__,
                        "Dump must be a directory.\n
                        Please, check dump: " . $this->config['dump']
                    );
                }
                $this->isDumpFileEmpty = true;
                $dumpDir = dir($this->dumpFile);
                while (false !== ($entry = $dumpDir->read())) {
                    if ($entry !== '..' && $entry !== '.') {
                        $this->isDumpFileEmpty = false;
                        break;
                    }
                }
                $dumpDir->close();
                return;
            }

            if ($this->config['dump_type'] === self::DUMP_TYPE_MONGODUMP_TAR_GZ) {
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    throw new ModuleConfigException(
                        __CLASS__,
                        "Tar gunzip archives are not supported for Windows systems"
                    );
                }
                if (!preg_match('/(\.tar\.gz|\.tgz)$/', $this->dumpFile)) {
                    throw new ModuleConfigException(
                        __CLASS__,
                        "Dump file must be a valid tar gunzip archive.\n
                        Please, check dump file: " . $this->config['dump']
                    );
                }
                return;
            }

            throw new ModuleConfigException(
                __CLASS__,
                '\"dump_type\" must be one of ["'
                . self::DUMP_TYPE_JS . '", "'
                . self::DUMP_TYPE_MONGODUMP . '", "'
                . self::DUMP_TYPE_MONGODUMP_TAR_GZ . '"].'
            );
        }
    }

    public function _before(TestInterface $test)
    {
        if ($this->shouldCleanup()) {
            $this->cleanup();
            $this->loadDump();
        }
    }

    public function _after(TestInterface $test)
    {
        $this->populated = false;
    }

    protected function shouldCleanup()
    {
        if ($this->populated) {
            return false;
        }

        return $this->config['cleanup'] === 'dirty'
            ? ($this->dbHash === null || $this->driver->getDbHash() !== $this->dbHash)
            : (bool)$this->config['cleanup'];
    }

    protected function cleanup()
    {
        $dbh = $this->driver->getDbh();
        if (!$dbh) {
            throw new ModuleConfigException(
                __CLASS__,
                "No connection to database. Remove this module from config if you don't need database repopulation"
            );
        }
        try {
            $this->driver->cleanup();
        } catch (\Exception $e) {
            throw new ModuleException(__CLASS__, $e->getMessage());
        }
    }

    protected function loadDump()
    {
        $this->validateDump();

        if ($this->isDumpFileEmpty) {
            return;
        }

        try {
            if ($this->config['dump_type'] === self::DUMP_TYPE_JS) {
                $this->driver->load($this->dumpFile);
            }
            if ($this->config['dump_type'] === self::DUMP_TYPE_MONGODUMP) {
                $this->driver->setQuiet($this->config['quiet']);
                $this->driver->loadFromMongoDump($this->dumpFile);
            }
            if ($this->config['dump_type'] === self::DUMP_TYPE_MONGODUMP_TAR_GZ) {
                $this->driver->setQuiet($this->config['quiet']);
                $this->driver->loadFromTarGzMongoDump($this->dumpFile);
            }
        } catch (\Exception $e) {
            throw new ModuleException(__CLASS__, $e->getMessage());
        }

        if ($this->config['cleanup'] === 'dirty') {
            $this->dbHash = $this->driver->getDbHash();
        }
    }

    /**
     * Specify the database to use
     *
     * ``` php
     * <?php
     * $I->useDatabase('db_1');
     * ```
     *
     * @param $dbName
     */
    public function useDatabase($dbName)
    {
        $this->driver->setDatabase($dbName);
    }

    /**
     * Inserts data into collection
     *
     * ``` php
     * <?php
     * $I->haveInCollection('users', array('name' => 'John', 'email' => 'john@coltrane.com'));
     * $user_id = $I->haveInCollection('users', array('email' => 'john@coltrane.com'));
     * ```
     *
     * @param $collection
     * @param array $data
     */
    public function haveInCollection($collection, array $data)
    {
        $collection = $this->driver->getDbh()->selectCollection($collection);
        if ($this->driver->isLegacy()) {
            $collection->insert($data);
            return $data['_id'];
        }

        $response = $collection->insertOne($data);
        return (string) $response->getInsertedId();
    }

    /**
     * Checks if collection contains an item.
     *
     * ``` php
     * <?php
     * $I->seeInCollection('users', array('name' => 'miles'));
     * ```
     *
     * @param $collection
     * @param array $criteria
     */
    public function seeInCollection($collection, $criteria = [])
    {
        $collection = $this->driver->getDbh()->selectCollection($collection);
        $res = $collection->count($criteria);
        \PHPUnit\Framework\Assert::assertGreaterThan(0, $res);
    }

    /**
     * Checks if collection doesn't contain an item.
     *
     * ``` php
     * <?php
     * $I->dontSeeInCollection('users', array('name' => 'miles'));
     * ```
     *
     * @param $collection
     * @param array $criteria
     */
    public function dontSeeInCollection($collection, $criteria = [])
    {
        $collection = $this->driver->getDbh()->selectCollection($collection);
        $res = $collection->count($criteria);
        \PHPUnit\Framework\Assert::assertLessThan(1, $res);
    }

    /**
     * Grabs a data from collection
     *
     * ``` php
     * <?php
     * $user = $I->grabFromCollection('users', array('name' => 'miles'));
     * ```
     *
     * @param $collection
     * @param array $criteria
     * @return array
     */
    public function grabFromCollection($collection, $criteria = [])
    {
        $collection = $this->driver->getDbh()->selectCollection($collection);
        return $collection->findOne($criteria);
    }

    /**
     * Grabs the documents count from a collection
     *
     * ``` php
     * <?php
     * $count = $I->grabCollectionCount('users');
     * // or
     * $count = $I->grabCollectionCount('users', array('isAdmin' => true));
     * ```
     *
     * @param $collection
     * @param array $criteria
     * @return integer
     */
    public function grabCollectionCount($collection, $criteria = [])
    {
        $collection = $this->driver->getDbh()->selectCollection($collection);
        return $collection->count($criteria);
    }

    /**
     * Asserts that an element in a collection exists and is an Array
     *
     * ``` php
     * <?php
     * $I->seeElementIsArray('users', array('name' => 'John Doe') , 'data.skills');
     * ```
     *
     * @param String $collection
     * @param Array $criteria
     * @param String $elementToCheck
     */
    public function seeElementIsArray($collection, $criteria = [], $elementToCheck = null)
    {
        $collection = $this->driver->getDbh()->selectCollection($collection);

        $res = $collection->count(
            array_merge(
                $criteria,
                [
                    $elementToCheck => ['$exists' => true],
                    '$where' => "Array.isArray(this.{$elementToCheck})"
                ]
            )
        );
        if ($res > 1) {
            throw new \PHPUnit\Framework\ExpectationFailedException(
                'Error: you should test against a single element criteria when asserting that elementIsArray'
            );
        }
        \PHPUnit\Framework\Assert::assertEquals(1, $res, 'Specified element is not a Mongo Object');
    }

    /**
     * Asserts that an element in a collection exists and is an Object
     *
     * ``` php
     * <?php
     * $I->seeElementIsObject('users', array('name' => 'John Doe') , 'data');
     * ```
     *
     * @param String $collection
     * @param Array $criteria
     * @param String $elementToCheck
     */
    public function seeElementIsObject($collection, $criteria = [], $elementToCheck = null)
    {
        $collection = $this->driver->getDbh()->selectCollection($collection);

        $res = $collection->count(
            array_merge(
                $criteria,
                [
                    $elementToCheck => ['$exists' => true],
                    '$where' => "! Array.isArray(this.{$elementToCheck}) && isObject(this.{$elementToCheck})"
                ]
            )
        );
        if ($res > 1) {
            throw new \PHPUnit\Framework\ExpectationFailedException(
                'Error: you should test against a single element criteria when asserting that elementIsObject'
            );
        }
        \PHPUnit\Framework\Assert::assertEquals(1, $res, 'Specified element is not a Mongo Object');
    }

    /**
     * Count number of records in a collection
     *
     * ``` php
     * <?php
     * $I->seeNumElementsInCollection('users', 2);
     * $I->seeNumElementsInCollection('users', 1, array('name' => 'miles'));
     * ```
     *
     * @param $collection
     * @param integer $expected
     * @param array $criteria
     */
    public function seeNumElementsInCollection($collection, $expected, $criteria = [])
    {
        $collection = $this->driver->getDbh()->selectCollection($collection);
        $res = $collection->count($criteria);
        \PHPUnit\Framework\Assert::assertSame($expected, $res);
    }

    /**
     * Returns list of classes and corresponding packages required for this module
     */
    public function _requires()
    {
        return ['MongoDB\Client' => '"mongodb/mongodb": "^1.0"'];
    }
}
