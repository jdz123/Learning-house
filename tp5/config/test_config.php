<?php
/*
 * 2018-06-25 增加crypt_key 加密配置
 */

return [
    /* 数据库设置 */
    'database'              => [
        // 数据库类型
        'type'        => 'mysql',
        // 服务器地址
         'hostname'    => 'localhost',
        // 数据库名
        'database'    => 'szfca_crm',
        // 数据库用户名
        'username'    => 'root',
        // 数据库密码
        'password'    => 'root',
        // 数据库连接端口
        'hostport'    => '',
        // 数据库连接参数
        'params'      => [],
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => '',
        // 数据库调试模式
        'debug'       => false,
        'resultset_type' => '\think\Collection',
        ],
     
    /* 上传接口 */
    'crm_uploads' => [
        'uploads' => 'Uploads',
//         'uploads' => '/home/Uploads/crm',// 根目录(linux格式)
        'visiting_card_path' => 'visitingcards',//名片
    ],




];
?>
