<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/2
 * Time: 10:09
 */

namespace app\home\controller;


class RedRemote
{

    private $Toy;

    function __construct($toy)
    {
        $this->Toy = $toy;
    }

    public function doOpen()
    {
        $this->Toy->openMouth();
    }

    public function doClose()
    {
        $this->Toy->closeMouth();
    }




}