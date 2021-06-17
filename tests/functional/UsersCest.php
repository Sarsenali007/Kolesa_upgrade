<?php
use Faker\Factory;
use Helper\CustomFakerProvider;
/**
 * Класс для работы с юзером
 */
class UserCest
{

    public static $defaultSchema = [
        '_id' =>        'string',
        'email' =>      'string',        
        'superhero' =>  'boolean',
        'name' =>       'string',
        'owner' =>      'string'
    ];

    /**
     * @group create
     * Функция для проверки создание нового пользователя
     */
    public function checkUserCreate(\FunctionalTester $I)
    {   
        $faker = Factory::create('kk_KZ');
        $faker->addProvider(new CustomFakerProvider($faker));
        $name = $faker->firstName;
        $email = $faker->email;
        $city = $faker->city;

        $userData = [
            'owner'     =>  'Sarsenali',
            'email'     =>  $email,
            'job'       =>  $city,
            'name'      =>  $name
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        /**
         * Создаю нового пользователя
         */
        $I->sendPost('human', $userData);
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseContainsJson(['status' => 'ok']);
        /**
         * получаю $id из ответа, при создании. Записываю для переменного для использование в будущем)
         */
        $id = $I->grabDataFromResponseByJsonPath('$._id');
        $I->sendGet('people', $userData);
        $I->seeResponseMatchesJsonType(self::$defaultSchema);
        /**
         * Тут по $id меняю name 
         */
        $I->sendPut('human?_id='.$id[0] , '{ "name": "Sarsenali"}' );
        /**
         * проверяю ответ об изменении а также возваращаю обновленные данные
         */
        $I->seeResponseContainsJson(['nModified' => '1']);
        /**
         * Проверяю есть нет ли данные которые в начале я создал
         */
        $I->sendGet('people?owner='.$userData['owner']);
        $I->dontSeeResponseMatchesJsonType($userData);
        
        /**
         * Удаляю по id
         */
        $I->sendDelete('human?_id='.$id[0]);
        /**
         * Проверяю статус о успешной удалении
         */
        $I->seeResponseContainsJson(['deletedCount' => '1']);
        $I->sendGet('human?_id='.$id[0]);
        $I->seeResponseContainsJson(['error' => 'Not Found']);
    }
}