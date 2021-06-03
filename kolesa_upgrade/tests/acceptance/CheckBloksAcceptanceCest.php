<?php
namespace Test\Acceptance;
use Codeception\Example;
use Page\Acceptance\MainHabrPage;
/*
* Класс для тестирование блоков
*/

class CheckBloksAcceptanceCest
{    /**
    * Класс для првоерки перехода между категориями
    *@param Description Example $data   
    *@dataProvider getDataForCategory
    **/
    public function CheckBloksAcceptanceCest(\AcceptanceTester $I, Example $data)
    {
        $I->amOnPage ('');
        $I->waitForElementVisible(sprintf(MainHabrPage::$SeeCategori, $data['SeeCategori']));
        $I->click(sprintf(MainHabrPage::$SeeCategori, $data['SeeCategori']));
        $I->seeInCurrentUrl($data['url']);
    }

    /**
     * Функция где рандомно возвращается значение
     */
    public function getDataForCategory(){    
    $input = array("flows/admin", "flows/management", 'flows/design', 'flows/marketing','flows/popsci', 'flows/develop');
    $rand_keys = array_rand($input, 3);
    return [
        ['SeeCategori' => $input[$rand_keys[0]],  'url'=>$input[$rand_keys[0]]],
        ['SeeCategori' => $input[$rand_keys[1]],  'url'=>$input[$rand_keys[1]]],
        ['SeeCategori' => $input[$rand_keys[2]],  'url'=>$input[$rand_keys[2]]]       
        ];
    }
}