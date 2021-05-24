<?php

class AccepCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
       $I->amOnPage ('');
       $I->amOnPage ('#homefeatured');
      # $I->moveMouseOver('#homefeatured > li:nth-child(2)');
       $I->seeElement('#homefeatured > li:nth-child(2) > div > div.left-block > div > a.quick-view');
       $I->click('#homefeatured > li:nth-child(2) > div > div.left-block > div > a.quick-view');
    #   $I->performOn('#product > div > div > div.pb-center-column.col-xs-12.col-sm-4 > h1', ['see' => 'Blouse']);
    #   $I->click('#search_query_top');
    #   $I->fillField('#search_query_top', 'Blouse');
    #   $I->pressKey('#search_query_top', \Facebook\WebDriver\WebDriverKeys::ENTER);
        $I->see('Blouse');

    }
}
