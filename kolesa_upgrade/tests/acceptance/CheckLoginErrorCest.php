<?php

use Page\Acceptance\LoginPage;

class CheckLoginErrorCest
{

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $LoginPage = new LoginPage($I);
        $I->amOnPage (LoginPage::$URL);
        $I->fillField(LoginPage::$LoginInput, LoginPage::WrongUser);
        $I->fillField(LoginPage::$PassInput, LoginPage::Pass);
        $I->click(LoginPage::$ButtonInput);
        $I->waitForElement(LoginPage::$ErrorBlock);
        $LoginPage -> CloseErrorBlock();
        $I->dontSeeElement(LoginPage::$ErrorBlock);
    }
}