<?php
namespace Page\Acceptance;

class ProductsPage
{
     /**
     * Страница c платьями
     *
     * @var string
     */
    public static $dressesUrl = 'index.php?id_category=8&controller=category';

    /**
     * Селектор с блоком товаров
     *
     * @var string
     */
    public static $firstProductCard = '//ul[contains(@class,"product_list")]//li[contains(@class, "product")][1]';

    /**
     * Селектор кнопки добавления товара в корзину
     *
     * @var string
     */
    public static $addToCartButton = '//li[contains(@class,"ajax_block_product")][%s]//a[@title="Add to cart"]';

    /**
     * Селектор модалки с сообщением об успешном добавлении товара
     *
     * @var string
     */
    public static $addSuccessModal= '//div[@id="layer_cart"]';

    /**
     * Селектор кнопки возвращения к покупкам
     *
     * @var string
     */
    public static $goBackShoppingButton = '//span[@title="Continue shopping"]';

    /**
     * success сообщение после добавления товара в корзину
     *
     * @var string
     */
    public static $successMessage = 'Product successfully added to your shopping cart';

      /**
       * Селектор кнопки корзины на странице товаров
       *
       * @var string
       */
    public static $cartListButton = '//a[@title="View my shopping cart"]';

}
