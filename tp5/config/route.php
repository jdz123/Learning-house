<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

#上传文件
Route::post('api/common/uploadFile$', 'home/Util/uploadFile'); //上传文件

#设计模式
Route::get('api/home/getDB','home/Abstract/getDB');//单利模式

Route::get('api/home/abstract$','home/Abstract/call');//策略模式

Route::get('api/home/toy$','home/Abstract/toy');//适配器模式

#算法
Route::get('api/home/bubbleSort$','home/Abstract/bubbleSort');//冒泡排序

Route::get('api/home/quickSort$','home/Abstract/quickSort');//快速排序(双路快排)

Route::get('api/home/insertSort$','home/Abstract/insertSort');//插入排序





Route::get('api/home/add$','home/Index/add');//读写分离-插入主库


return [
     '/api/ding$'=>['home/common/updateCompany',['method' => 'get']],
	'/api/user/login' => ['home/Login/login', ['method' => 'post']],//登录
	'/api/user/logout' => ['home/Login/logout', ['method' => 'get']],//退出
	//获取登录状态
    '/api/common/getLoginStatus' => 'home/Login/getLoginStatus',
];
