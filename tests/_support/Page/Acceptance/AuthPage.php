<?php
namespace Page\Acceptance;

/**
 * Класс для заполеннеи полей авторизации
*/
class AuthPage
{
        /**
     *  Урл страниы авторизация
     */
    public static $URL = "index.php?controller=authentication&back=my-account";

        /**
     *  Селектр для поля Логин
     */
    public static $mail = "#email";

        /**
     *  Селектр для поля Пароль
     */
    public static $Passwd = "#passwd";
    
        /**
     *  Селектр для кнопки SigIn
     */
    public static $LogIn = "#SubmitLogin > span > i";

}
