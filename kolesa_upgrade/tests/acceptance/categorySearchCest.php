<?php
namespace Test\Acceptance;

use Page\Acceptance\MainMarketPage;

/*
* Класс для тестирование блоков
*/

class categorySearchCest
{    /**
    * Класс для првоерки перехода между категориями
    **/

    protected function setRegionCookier(\AcceptanceTester $I){
        $I->amOnPage(MainMarketPage::$url);
        $I->setCookie('regAutoToggle', '1');
        $I->reloadPage();
    }

    /**
     * @before  setRegionCookier
    */
    public function checkJobCategory (\AcceptanceTester $I){
        $I->wait(3);
        $I->waitForElementVisible(MainMarketPage::$workCategoryIcon);
        $I->click(MainMarketPage::$workCategoryIcon);
    }

    /**
    * Класс для првоерки перехода между категориями
     * @before  setRegionCookier
    */
    public function checkpropertyCategory (\AcceptanceTester $I){
        $I->wait(3);
        $I->waitForElementVisible(MainMarketPage::$propertyCategoryIcon);
        $I->click(MainMarketPage::$propertyCategoryIcon);
    }
   }