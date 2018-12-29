<?php
namespace app\home\controller;

/*
*单例模式
*/
class DanliDb{

    //静态
    private static $instance;

    //构造私有
    public  function __contruct()
    {
    }

    private function __clone()
    {
    }

    //其他类通过方法 实例本类
    //静态方法是优先于对象而存在的
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)){
            self::$instance = new self();
        }

        return self::$instance;
	}
}


