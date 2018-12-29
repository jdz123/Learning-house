<?php
namespace app\home\controller;

use app\home\controller\Browser;

class AbstractController extends CommonController
{
    public function miss(){
        return returnCodeJson(40500,'请求接口不存在');
    }
    /**
     * 策略模式
     */
    public function call()
    {
    	$bro = new Browser();
    	echo $bro->charge('app\home\controller\AliCharge');
    }

/**
 *单例模式
 * 比如：DB，仅仅需要在一次生命周期中建一个连接就好
 */
    public function getDB()
    {
        $db1 = DanliDb::getInstance();
        $db2 = DanliDb::getInstance();

        var_dump($db1 === $db2);
    }


}
