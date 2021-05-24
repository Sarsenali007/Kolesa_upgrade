<?php

class SecondCest
{

    // tests
    public function tryToTest(FunctionalTester $I)
    {
       $I->amOnPage ('');
       $I->seeElement('#search_query_top');
       $I->fillField('#search_query_top', 'Printed dress');
       $I->click('#searchbox > button');
       #center_column > ul > li.ajax_block_product.col-xs-12.col-sm-6.col-md-4.last-in-line.first-item-of-tablet-line.last-item-of-mobile-line.hovered
       $I->seeNumberOfElements('li.ajax_block_product', 5);
    }
}
