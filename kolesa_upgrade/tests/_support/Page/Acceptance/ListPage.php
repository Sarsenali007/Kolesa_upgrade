<?php
namespace Page\Acceptance;

/**
 * Страница MyWishList
*/
class ListPage
{

    /*
    URL страницы авторизации
    */
    public static $URL = 'index.php?fc=module&module=blockwishlist&controller=mywishlist';
    
        /*
    Селектр для блока таблиц
    */
    public static $block = '//div[@class="columns-container"]';
    
    /**
     * селектор для поля количество Mywish
     */
    public static $BtnList = ".bold";

    /**
     * селектор для очитски списка Wishlist
     */
    public static $Clear = "td.wishlist_delete>a";

    /**
     * селектор для выхода из аккаунта
     */
    public static $logout = ".logout>a";

}