<?php
namespace Page\Acceptance;

/*
Страница для авторизации
*/
class LoginPage
{
    /*
    URL страницы авторизации
    */
    public static $URL = '';
    
        /**
     *  Значение для ошибочного логниа
     */
    public const WrongUser = 'locked_out_user';

    /**
     * Значение пароля
     */
    public const Pass = 'secret_sauce';

    /**
     * Селектр для ввода логина
     * 
     *      */
    public static $LoginInput = '#user-name';

    /**
     * Селектр для ввода паролья
     */
    public static $PassInput = '#password';

    /**
     * Селектр для кнопки Login
     */
    public static $ButtonInput = '#login-button';

    /**
     * Селектр для блока ошибки
     */
    public static $ErrorBlock = '#login_button_container > div > form > div.error-message-container.error > h3';
    
        /**
     * Селектр кнопки для закртыие блока ошибки
     */
    public static $CloseErrorBlock = '#login_button_container > div > form > div.error-message-container.error > h3 > button';
    
    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    /**
     * Селектр кнопки для закртыие блока ошибки
     */
    public function CloseErrorBlock()
    {
        $this -> acceptanceTester ->click(self::$CloseErrorBlock);
    }

    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * @var \AcceptanceTester;
     */
    protected $acceptanceTester;



}
