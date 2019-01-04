<?php
namespace app\home\controller;



class Dog extends Toy
{
    public function openMouth()
    {
        echo 'Dog open Mouth<BR>';
    }

    public function closeMouth()
    {
        echo 'Dog close Mouth<BR>';
    }
}




abstract class Toy
{
    //张嘴
    public abstract function openMouth();

    //闭嘴
    public abstract function closeMouth();

}


