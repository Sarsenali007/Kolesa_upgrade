<?php
namespace Page\Acceptance;

/*
Главная страница http://automationpractice.com/index.php
*/
class MainPage
{
/*
    URL главный страницы
    */
    public static $URL2 = '';
    
    /**
     * Селектр для просмотра Каталога Dress
     */
    public static $SeeCatalogDress = '#block_top_menu > ul > li:nth-child(2) > a';

    /**
     * Селектр для просмотра Категорию Summer в каталоге Dress
     *      */
    public static $InCatalogSummer = '#block_top_menu > ul > li:nth-child(2) > ul > li:nth-child(3) > a';

}