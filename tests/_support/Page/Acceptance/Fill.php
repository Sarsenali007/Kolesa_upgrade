<?php
namespace Page\Acceptance;

/**
 * Класс для заполеннеи полей
*/
class Fill
{
    /*
    URL страницы авторизации
    */
    public static $URL = '';
    
    /**
     *  Селектр Имя
     */
    public static $firstName = "#firstName";

    /**
     *  Селектр Имя
     */
    public static $lastName = "#lastName";

        /**
     *  Селектр Почты
     */
    public static $mail = "#input_38";

    /**
     *  Селектр телефона
     */
    public static $Phone = "#phoneNumber";
    /**
     *  Селектр адреса
     */
    public static $address = "#address";

        /**
     *  Селектр города
     */
    public static $city = "#city";

        /**
     *  Селектр Региона
     */
    public static $state = "#state";

    /**
     *  Селектр ZIP кода
     */
    public static $postal = "#postal";

    /**
     *  Селектр Кнопки выбрать тип оплаты
     */
    public static $checkboxpay = "#input_32_paymentType_credit";
    
        /**
     *  Селектр Кнопки выбрать тип оплаты
     */
    public static $CartNumber = "#input_32_cc_number";
    
    
    /**
     *  Селектр name cart
     */
    public static $firstNamecart = "#input_32_cc_firstName";

    /**
     *  Селектр last name cart
     */
    public static $lastNamecart = "#input_32_cc_lastName";
    
        /**
     *  Селектр CV
     */
    public static $CartCV = "#input_32_cc_ccv";
    

    /**
     *  Селектр срок окначание месяц
     *      */
    public static $monthcart = "#input_32_cc_exp_month";

    /**
     *  Селектр срок окначание год
     */
    public static $yearcart = "#input_32_cc_exp_year";
    
        /**
     *  Селектр адресс
     */
    public static $addr = "#input_32_addr_line1";

}
