<?php
namespace Page\Acceptance;

/**
 * Главная страница для http://automationpractice.com/index.php?
*/
class MainPageMyStore
{

    /*
    URL страницы авторизации
    */
    public static $URL = '';
    
    /**
     * селектор для кнопки Sign In
     */
    public static $BtnSignIn = "#header > div.nav > div > div > nav > div.header_user_info > a";

    /**
     * Возвращает i- ый селектор товара (Для наведение мышки)
     * @param  string $index
     * @var string
     */
    public static function getTovarsSelectorByIndex($index){
        return "//*[@id='homefeatured']/li[$index]/div/div[1]/div";
    }
    
        /**
     * Возвращает i- ый селектор кнопку "View" товара
     * @param  string $index
     * @var string
     */
    public static function getTovarSelectorByIndex($index){
        return "#homefeatured > li:nth-child($index) > div .left-block > div > .quick-view";
    }
    
    /**
     *  Селектр кнопки добавление addtowish
     */
    public static $addToWish = "//*[@id='wishlist_button']";
    
        /**
     *  Селектр перехода на iframe
     */
    public static $SwitshIframe = ".fancybox-iframe";
    
        /**
     *  Селектр крестика флашка
     */
    public static $closeplashka = "#product > div.fancybox-overlay.fancybox-overlay-fixed > div > div > a";

    /**
     *  Селектр закрытие iframe
     */
    public static $closeIframe = "//*[@id='index']/div[2]/div/div/a";

    /**
     *  Селектр на кабинет
     */
    public static $goProfile = "#header > div.nav > div > div > nav > div:nth-child(1) > a";
    
}
