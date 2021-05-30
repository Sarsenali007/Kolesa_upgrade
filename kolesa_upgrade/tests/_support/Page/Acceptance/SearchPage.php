<?php
namespace Page\Acceptance;

class SearchPage
{    
       /*
         Страница для авторизации
        */
        /*
        URL страницы авторизации
        */
        /*
        URL страницы каталога
        */
        public static $URL1 = 'index.php?id_category=11&controller=category';
    
        /*
        *Селектор для фильтра (Grid, List)
        */
        public static $IsSelected = '#grid';      
        
        /**
         * Селектр для просмотра таблицы при фильтре grid
         **/
        public static $SeeTableGrid = '#center_column > .product_list.row.grid';
            
        /**
         * Селектр для просмотра таблицы при фильтре list
         **/
        public static $SeeTableList = '#center_column > .product_list.row.list';

        /**
         * Селектр для просмотра таблицы при фильтре grid
         **/
        public static $SelectList = '#list > a > i';    
}
