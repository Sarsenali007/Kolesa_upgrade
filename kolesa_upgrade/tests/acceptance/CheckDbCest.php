<?php

use Faker\Factory;
use Helper\CustomFakerProvider;
use Page\Acceptance\DbMainPage;

use function PHPUnit\Framework\assertEquals;

class CheckDbCest
{
    
    public const NMB = 3;
    /**
     * @var array
     */
    protected $userData;

    /**
     * Функция генерирующий данные
     * @group generate
     * */
    public function generate(AcceptanceTester $I)
    {
        $faker = Factory::create('kk_KZ');
        $faker->addProvider(new CustomFakerProvider($faker));

        $this->userData = [
            'job'       =>  $faker->city,
            "superhero" =>  $faker->boolean(),
            "skill"     =>  $faker->word,
            'email'     =>  $faker->email,
            'name'      =>  $faker->firstName,
            "DOB"       =>  $faker->date("Y-m-d"),
            "avatar"    =>  $faker->imageUrl(),
            "canBeKilledBySnap" => $faker->boolean(),
            "created_at"        => $faker->date("Y-m-d"),
            'owner'     =>  'Sarsenali'
        ];

        $this->userData1 = [
            "canBeKilledBySnap" => true,
            'owner'     =>  'Sarsenali'
        ];

        $this->userData2 = [
            "canBeKilledBySnap" => false,
            'owner'     =>  'Sarsenali'
        ];       
    }
    /**
     * Функция для проверки создание пользователей и проверку корректность создание 
     *  @before generate
     * @group create
     */
    public function Create(AcceptanceTester $I){
        for($i = 1; $i<= self::NMB; $i++){
            $this ->generate($I);
        $I->haveInCollection('people', $this ->userData);

        $user = $I->grabFromCollection('people', array('email' => $this ->userData['email']));

        $I->amOnPage('people?owner='.$this ->userData['owner']);

        $I->waitForElementVisible(DbMainPage::$block);
        
        $I->see($user['name']);

    }
}

/**
 * Функция для удаление проверки удалении данных
 *  * @group checkdel
 */
public function CheckDel(AcceptanceTester $I){
    
    $I->amOnPage('people?owner='.$this ->userData['owner']);
    $I->waitForElementVisible(DbMainPage::$block);
    $I->wait(1);
    $I->seeNumberOfElements(DbMainPage::$block, self::NMB);
    $I->click(DbMainPage::$BtnSnap);
    $I->wait(2);
    $I->dontSeeInCollection('people', array('canBeKilledBySnap' =>  $this ->userData1['canBeKilledBySnap'],'owner' => $this ->userData1['owner']));
    $user = $I->grabCollectionCount('people', array('canBeKilledBySnap' =>  $this ->userData2['canBeKilledBySnap'],'owner' => $this ->userData1['owner']));
    $I->seeNumberOfElements(DbMainPage::$block, $user);
    
}

}