<?php
namespace app\home\controller;

use think\Db;
class IndexController extends CommonController
{
    public function miss(){
        return returnCodeJson(40500,'请求接口不存在');
    }
    /**
     * 首页默认跳转
     */
    public function index()
    {
    	return view('a');
    }


    public function add() {
        $obj=Db::table('user');
        $data["name"]="777";
        if ($obj->insert($data)) {
            echo 1;
        }else {
            echo 2;
        }
    }




}
