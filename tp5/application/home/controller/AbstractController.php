<?php
namespace app\home\controller;

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

/**
 * 适配器模式
 * 比如：玩具接口适配遥控接口
 */

    public function toy()
    {
        $adaptee_dog = new Dog();
        echo "给狗套上红遥控器<BR>";
        $adapter_red = new RedRemote($adaptee_dog);

        //使用遥控器的接口去控制 张闭嘴（以保证扩展时，不修改基础类）
        $adapter_red->doOpen();
        $adapter_red->doClose();


    }





}
