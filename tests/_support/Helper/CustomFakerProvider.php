<?php
namespace Helper;

use Faker\Provider\Base;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class CustomFakerProvider extends Base
{
    protected $cartnum=[
        '3',
        '4',
        '5',
        '6',
        '7'
    ];
    /**
     * Возвращает рандомную карту
     */
    public function getCartNum(){
    return sprintf(
        '%d%d%d%d',
        $this->cartnum[array_rand($this->cartnum)],
        random_int(10000, 99999),
        random_int(100000000, 999999999),
        random_int(1, 9)
    );
    }
}
