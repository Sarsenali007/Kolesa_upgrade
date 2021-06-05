<?php

namespace Test\Acceptance;

use Faker\Factory;
use Helper\CustomFakerProvider;
use Page\Acceptance\Fill;

class FillFormCest
{
    /**
     * Тест на проверку заполнения полей с помощью фейкера
     * @group test2
     */
    public function FillFormCest(\AcceptanceTester $I)
    {
        $faker = Factory::create('kk_KZ');
        $faker->addProvider(new CustomFakerProvider($faker));
        
        $name = $faker->firstName;
        $lastName = $faker->lastName;
        $email = $faker->email;
        $Phone = $faker->phoneNumber;
        $address = $faker->address;
        $city = $faker->city;
        $state = $faker->region;
        $postal = $faker->postcode;
        
        $CartNumber = $faker->getCartNum;

        $I->amOnPage ('');
        $I->fillField(Fill::$firstName,$name);
        $I->fillField(Fill::$lastName,$lastName);
        $I->fillField(Fill::$mail,$email);
        $I->fillField(Fill::$Phone,$Phone);
        $I->fillField(Fill::$address,$address);
        $I->fillField(Fill::$city,$city);
        $I->fillField(Fill::$state,$state);
        $I->fillField(Fill::$postal,$postal);
        $I->checkOption(Fill::$checkboxpay);
        $I->fillField(Fill::$CartNumber,$CartNumber);
        $I->wait(10);
    }
}