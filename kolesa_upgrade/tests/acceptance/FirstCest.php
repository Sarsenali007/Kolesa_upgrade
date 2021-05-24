<?php

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
       $I->amOnPage ('');
       $I->seeElement('#navbar-links > li:nth-child(3) > a');
       $I->click('#navbar-links > li:nth-child(3) > a');
       
       codecept_debug($I->grabValueForm('#post_558404 > article > h2 > a'))
       $I->seeElement('#\35 58404 > div.tm-article-snippet > h2 > a');
       $I->click('#\35 58404 > div.tm-article-snippet > h2 > a');
       
    }
}
