<?php

class CountBlocksFunctionalCest
{

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $searchboxSearchCss = '#search_query_top';
        $searchboxSearchXPath = '//*[@id="search_query_top"]';
        $searchButtonCss = '#searchbox > button';
        $searchButtonXPath = '//*[@id="searchbox"]/button';
        $searchListCss = '.product_list>li';
        $searchListXPath = '//*[@id="center_column"]/ul/li';
        

        
        $I->amOnPage ('');
        $I->seeElement('#search_query_top');
        $I->fillField('#search_query_top', 'Printed dress');
        $I->click('#searchbox > button');
        $I->seeNumberOfElements('.product_list>li', 5);
    }
}
