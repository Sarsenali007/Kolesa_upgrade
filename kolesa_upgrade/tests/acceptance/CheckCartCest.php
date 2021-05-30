<?php

use Page\Acceptance\MainPage;
use Page\Acceptance\SearchPage;

class CheckLoginErrorCest
{

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage (MainPage::$URL2);
        $I->moveMouseOver(MainPage::$SeeCatalogDress);
        $I->waitForElementVisible(MainPage::$InCatalogSummer);
        $I->click(MainPage::$InCatalogSummer);

        //Тут переходим на страницу каталог
        $I->amOnPage (SearchPage::$URL1);
        $I->waitForElementVisible(SearchPage::$IsSelected);
        $I->waitForElementVisible(SearchPage::$SeeTableGrid);
        $I->click(SearchPage::$SelectList);
        $I->waitForElementVisible(SearchPage::$SeeTableList);
    }
}