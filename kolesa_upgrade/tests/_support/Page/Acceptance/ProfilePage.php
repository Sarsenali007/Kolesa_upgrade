<?php
namespace Page\Acceptance;

/**
 * Главная страница для профиля
*/
class ProfilePage
{

    /*
    URL страницы авторизации
    */
    public static $URL = 'index.php?controller=my-account';
    
    /**
     * селектор для кнопки My WishList
     */
    public static $Btncount = "#center_column > div > div:nth-child(2) > ul > li > a > span";    
}
