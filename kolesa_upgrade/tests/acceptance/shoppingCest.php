<?php
namespace Test\Acceptance;

use Page\Acceptance\AuthPage;
use Page\Acceptance\ListPage;
use Page\Acceptance\MainPageMyStore;
use Page\Acceptance\ProfilePage;

use function PHPUnit\Framework\assertEquals;

class shoppingCest
{    
    /**
    * Класс для првоерки добавление в MyWishList
    **/

    public const PRODUCT_NMB = 2;

    /**
     * Функция для авторизации
     */
    protected function login(\AcceptanceTester $I){
        $I->amOnPage(MainPageMyStore::$URL);
        $I->click(MainPageMyStore::$BtnSignIn);
        $I->waitForElementVisible(AuthPage::$mail);
        $I->fillField(AuthPage::$mail,"sarsenali007@gmail.com");
        $I->fillField(AuthPage::$Passwd,"Qwerty123");
        $I->click(AuthPage::$LogIn);
    }

    /**
     * Функция для выхода из аккаунта и очистка списка
     */
    protected function logout(\AcceptanceTester $I){
        $I->amOnPage(ListPage::$URL);
        $I->click(ListPage::$Clear);
        $I->acceptPopup();
        $I->click(ListPage::$logout);
    }



    /**
     * @before login
     * @after logout
    */
    public function checkToAmount (\AcceptanceTester $I){
        $I->amOnPage(MainPageMyStore::$URL);

        for($i = 1; $i<= self::PRODUCT_NMB; $i++)
        {
            $I->scrollTo(sprintf(MainPageMyStore::getTovarsSelectorByIndex($i)));
            $I->moveMouseOver(sprintf(MainPageMyStore::getTovarsSelectorByIndex($i)));
            $I->click(sprintf(MainPageMyStore::getTovarSelectorByIndex($i)));
            $I->switchToIFrame(".fancybox-iframe");
            $I->waitForElementVisible(MainPageMyStore::$addToWish);
            $I->click(MainPageMyStore::$addToWish);
            $I->waitForElementVisible(MainPageMyStore::$closeplashka);
            $I->click(MainPageMyStore::$closeplashka);
            $I->amOnPage(MainPageMyStore::$URL);
        }
        $I->click(MainPageMyStore::$goProfile);
        $I->amOnPage(ProfilePage::$URL);

        $I->click(ProfilePage::$Btncount);
        $I->amOnPage(ListPage::$URL);
        $I->scrollTo(ListPage::$block);
        $I->waitForElementVisible(ListPage::$BtnList);
        $total = $I->grabTextFrom(ListPage::$BtnList);

        assertEquals($total, self::PRODUCT_NMB);
}
   }