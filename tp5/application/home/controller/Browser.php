<?php
namespace app\home\controller;

/*
*策略模式
*1.环境类
*2.抽象策略类
*3.具体策略类
*
*/
class Browser{
	public function charge($object){
	    //1.客户端直接给对象
//		return $object->charge();
        //2.利用反射
//        print_r($object);exit();
        $object = new \ReflectionClass($object);//建立反射类
        $object = $object->newInstance();
        return $object->charge();

        //反射调用方法 方式2 （其实和调用对象的方法类似只不过这里是反着来的，方法在前，对象在后）
        $object = new \ReflectionClass($object);//建立反射类
        $method = $object->getmethod('charge');
        $ob = $object->newInstance();
        return $method->invoke($ob);

	}
}

class AliCharge extends ChargeStrategy{//具体策略类-支付宝策略类
	 public function charge()
    {
        // 完成支付宝的相关逻辑
        echo '支付宝';
    }

}


class WxCharge extends ChargeStrategy//具体策略类-微信策略类
{
    public function charge()
    {
        // 完成微信的相关逻辑
        echo '微信';
    }
}


abstract class ChargeStrategy{//抽象策略类
	abstract function charge();
}
