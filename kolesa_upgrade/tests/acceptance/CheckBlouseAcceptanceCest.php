<?php

class MyfirstAcceptanceCest
{
    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $searchElementCss = '#homefeatured > li:nth-child(2) > div .left-block > div > .quick-view';
        $searchElementXPath = '//*[@id="homefeatured"]/li[2]/div/div[1]/div/a[2]';
        $I->amOnPage ('');
        $I->waitForElementVisible('#homefeatured > li:nth-child(2) > div .left-block > div > .quick-view');
        $I->click('#homefeatured > li:nth-child(2) > div .left-block > div > .quick-view');
        $I->see('Blouse');

    }
}
