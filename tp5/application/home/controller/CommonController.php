<?php
namespace app\home\controller;
use app\home\service\DiligenceResourceAllotService;
use think\Controller;
// use think\Request;
class CommonController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

  //驼峰参数转下划线
  public function getParam($request){
      $param = $request->param();
      return parseDataStyle($param);
  }

  





}
