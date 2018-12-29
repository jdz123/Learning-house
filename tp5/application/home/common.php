<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if (!function_exists('sha5')) {
    /* *
     * 生成密码函数(40位)
     * @param string $str1  密码
     * @param string $salt  用户秘钥
     * Author: cmf <cmf5001@qq.com>
     */
    function sha5($pwd, $salt = '')
    {
        return sha1(md5($pwd . $salt) . config('admin_password_key'));
    }
}
if (!function_exists('createToken')) {
    /* *
     * 生成管理员token
     * Author: cmf <cmf5001@qq.com>
     */
    function createToken()
    {
        return sha1(time() . uniqid());
    }
}
if (!function_exists('createPage')) {
    /* *
     * 生成分页配置（c风格）
     * Author: cmf <cmf5001@qq.com>
     */
    function createPage($showMaxRows = false)
    {
        if ($showMaxRows) {
            return ['list_rows' => 10000, 'page' => 1];
        }
        $list_rows = input('param.rows') == -1 ? 10000 : input('param.rows', config('paginate')['list_rows']);
        $page = input('param.page', 1);
        $page = $page < 1 ? 1 : $page;
        return ['list_rows' => $list_rows, 'page' => $page];
    }
}
if (!function_exists('createPages')) {
    /* *
     * 生成分页配置（java风格）
     * Author: cmf <cmf5001@qq.com>
     */
    function createPages($showMaxRows = false)
    {
        if ($showMaxRows) {
            return ['list_rows' => 10000, 'page' => 1];
        }
        $list_rows = input('param.pageSize') == -1 ? 10000 : input('param.pageSize', config('paginate')['list_rows']);
        $page = input('param.pageNo', 1);
        $page = $page < 1 ? 1 : $page;
        return ['list_rows' => $list_rows, 'page' => $page, 'type' => 'bootstrap'];
    }
}
// 生成排序
if (!function_exists('createOrder')) {
    function createOrder()
    {
        $order = input('param.sortKey', 'updatetime');
        $orderType = input('param.sortOrder', 'normal');
        if (!in_array($orderType, ['asc', 'desc', 'normal'])) {
            $orderType = 'normal';
        }
        if ($orderType == 'normal') {
            return [];
        }
        return [$order => $orderType];
    }
}

if (!function_exists('returnCodeJson')) {
    /**
     * 返回错误信息
     * @param mixed
     * Author: cmf <cmf5001@qq.com>
     */
    function returnCodeJson($code, $msg, $data = [])
    {
        return json(['code' => $code, 'msg' => $msg, 'data' => $data]);
    }
}

//
if (!function_exists('returnCodeArray')) {
    /**
     * 返回错误信息
     * @param mixed
     * Author: cmf <cmf5001@qq.com>
     */
    function returnCodeArray($code, $msg, $data = [])
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }
}

if (!function_exists('returnVal')) {
    /**
     * 简单返回处理结果
     * @param mixed
     */
    function returnVal($resBool, $msg = '', $data = [])
    {
        return array('suc' => $resBool, 'msg' => $msg, 'data' => $data);
    }
}

//获取当前用户ID
if (!function_exists('getUserId')) {
    function getUserId()
    {
        $user_info = session(md5(config('crm_session_key')));
        if (!empty($user_info) && isset($user_info['id'])) {
            return $user_info['id'];
        } else {
            return null;
        }
    }
}

//抛出异常
if (!function_exists('throwEx')) {
    function throwEx($ex = '', $msg = '', $code = 10001)
    {
        if ($ex instanceof Exception) {
            $message = [
                'message' => $ex->getMessage(),
                'line' => $ex->getLine(),
                'file' => $ex->getFile()
            ];
            $msg && $message['msg'] = $msg;
            $code = $code ? $code : $ex->getCode();
            
            $error = json_encode($message);
        } else {
            $error = $msg;
        }
        exception($error, $code);
    }
}
//记录异常(不抛出)
if (!function_exists('dealEx')) {
    function dealEx($ex, $msg = '')
    {
        if ($ex instanceof Exception) {
            $error = $ex->getMessage();
            $msg = '[CRM_ERROR]' . $msg . '  ' . $error;
            think\Log::record($msg, 'error');
            $debug = config('app_debug');
            if ($debug) {
                var_dump($msg);
            }
        }
    }
}

//记录异常(不抛出)
if (!function_exists('makelog')) {
    function makelog($msg, $logType = '')
    {
        think\Log::record($msg, $logType);
    }
}

// 时间转换
if (!function_exists('filterDate')) {
    function filterDate($str, $format = 'Y-m-d H:i:s', $default = '')
    {
        if (false !== strtotime($str)) {
            return date($format, strtotime($str));
        }
        return $default;
    }
}

// 时间转换
if (!function_exists('dateCompare')) {
    function dateCompare($aDate, $bDate)
    {
        $stmpA = strtotime($aDate);
        $stmpB = strtotime($bDate);
        if ($stmpA > $stmpB) {
            return 1;
        } else if ($stmpA == $stmpB) {
            return 0;
        } else {
            return -1;
        }
    }
}

if (!function_exists('iconv_all')) {
    /**
     * iconv 增强编码处理
     *
     * @param string $in_charset 原编码
     * @param string $out_charset 输出编码
     * @param string,array,obj $obj 对像
     *
     * @return array
     */
    function iconv_all($in_charset, $out_charset, $obj)
    {
        if (is_string($obj)) {
            $obj = iconv($in_charset, $out_charset . "//IGNORE", $obj);
            //$obj = mb_convert_encoding($obj, $out_charset, $in_charset);
        } elseif (is_array($obj)) {
            foreach ($obj as $key => $value) {
                $obj [$key] = iconv_all($in_charset, $out_charset, $value);
            }
        } elseif (is_object($obj)) {
            foreach ($obj as $key => $value) {
                $obj->$key = iconv_all($in_charset, $out_charset, $value);
            }
        }
        return $obj;
    }
}

//获取当前时间
if (!function_exists('getNow')) {
    function getNow($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }
}

//处理数据风格
// * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
// * @param string  $name 字符串
// * @param integer $type 转换类型
// * @param bool    $ucfirst 首字母是否大写（驼峰规则）
if (!function_exists('parseDataStyle')) {
    
    function parseDataStyle($data, $type = 0, $ucfirst = false)
    {
        $arr_re = [];
        is_object($data) && $data = json_decode(json_encode($data), true);
        if (!empty($data) and is_array($data)) {
            foreach ($data as $key => $value) {
                $new_key = think\Loader::parseName($key, $type, $ucfirst);
                if (is_array($value) || is_object($value)) {
                    $arr_re[$new_key] = parseDataStyle($value, $type, $ucfirst);
                } else {
                    $arr_re[$new_key] = $value;
                }
            }
        }
        return $arr_re;
    }
}

if (!function_exists('styledDataJson')) {
    /**
     * 返回转化为 Java风格的Json数据
     * @param mixed
     * Author: lihao <748736013@qq.com>
     */
    function styledDataJson($data = [])
    {
        return json(parseDataStyle($data, 1));
    }
}
if (!function_exists('styledExceptionJson')) {
    /**
     * 返回转化为 Java风格的Json数据
     * @param mixed
     * Author: lihao <748736013@qq.com>
     */
    function styledExceptionJson($ex, $code = 50000, $msg = '请求异常')
    {
        if ($ex instanceof Exception) {
            $message = $ex->getMessage();
            $errorCode = $ex->getCode() > 0 ? $ex->getCode() : $code;
        } else {
            $message = $msg;
            $errorCode = $code;
        }
        $error = [
            'code' => $errorCode,
            'msg' => $message,
            'data' => ''
        ];
        $data = !is_array(json_decode($message)) ? json_decode($message) : [];
        if (!config('app_debug')) {
            errorLog(['message' => $message, 'data' => $data], 'MASTER_ERROR');
            return json($error);
        }
        $error['data'] = $data;
        #debugLog($error);
        return json($error);
    }
}
# 标签数据转换  => '["1","2"]'
if (!function_exists('styledPortrait')) {
    function styledPortrait($data = [])
    {
        $val = '';
        foreach (array_unique($data) as $key) {
            if (!empty($val)) $val .= ',';
            $val .= '"' . $key . '"';
        }
        return "[{$val}]";
    }
}

//二维数组排序
if (!function_exists('array_muti_sort')) {
    function array_muti_sort($arrays, $sort_key, $is_date = false, $sort_order = SORT_DESC, $sort_type = SORT_NUMERIC)
    {
        if ($is_date) {
            $new_sort_key = $sort_key . '_stmp';
            foreach ($arrays as $key => $val) {
                $arrays[$key][$new_sort_key] = strtotime($val[$sort_key]);
            }
        }
        $sort_key = $new_sort_key;
        if (is_array($arrays)) {
            foreach ($arrays as $array) {
                if (is_array($array)) {
                    $key_arrays[] = $array[$sort_key];
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
        array_multisort($key_arrays, $sort_order, $sort_type, $arrays);
        return $arrays;
    }
}

/**
 * array_column() // 不支持5.6以下低版本;
 * 以下方法兼容PHP低版本
 */
if (!function_exists('_array_column')) {
    function _array_column(array $array, $column_key, $index_key = null)
    {
        $result = [];
        foreach ($array as $arr) {
            if (!is_array($arr)) continue;
            
            if (is_null($column_key)) {
                $value = $arr;
            } else {
                $value = $arr[$column_key];
            }
            
            if (!is_null($index_key)) {
                $key = $arr[$index_key];
                $result[$key] = $value;
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }
}

//生成guid
if (!function_exists('createGuid')) {
    //生成uuid（guid）
    function createGuid($prefix = '', $separator = '')
    {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8) . $separator;
        $uuid .= substr($chars, 8, 4) . $separator;
        $uuid .= substr($chars, 12, 4) . $separator;
        $uuid .= substr($chars, 16, 4) . $separator;
        $uuid .= substr($chars, 20, 12);
        return $prefix . $uuid;
    }
}


//获取客户端IP地址
if (!function_exists('clientIp')) {
    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    function clientIp($type = 0, $adv = false)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL) return $ip[$type];
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) unset($arr[$pos]);
                $ip = trim($arr[0]);
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

//递归创建文件夹
if (!function_exists('mkDirs')) {
    function mkDirs($dir)
    {
        if (!is_dir($dir)) {
            if (!mkDirs(dirname($dir))) {
                return false;
            }
            if (!mkdir($dir, 0777)) {
                return false;
            }
        }
        return true;
    }
}


/*
 curl方式获取远程页面内容 （POST方式） caohj 20180308
 */
if (!function_exists('curlByType')) {
    function curlByType($remote_server, $data = '', $req_type = 'get', $is_data_json = false)
    {
        $req_type = strtolower($req_type);
        $url = $remote_server;
        $useragent = "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0";
        //伪造header
        $header = array('Accept-Language: zh-cn', 'Connection: Keep-Alive', 'Cache-Control: no-cache');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($req_type == 'put' || $req_type == 'delete') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $req_type);
        } else if ($req_type == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        //get
        if ($req_type != 'get' && $req_type != 'delete') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($is_data_json) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
                );
        }
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $result;
    }
}

//数据加密
if (!function_exists('dataEncrypt')) {
    /**
     * 数据加密
     * @param string $plainText
     * @return string
     */
    function dataEncrypt($plainText = '')
    {
        $plainText = strval($plainText);
        if (is_string($plainText) && !empty($plainText)) {
            try {
                vendor("custom.AesCrypt");
                //crypt_key 从user_cookies_config抽出 edit by caohj 2018-04-04
                //$config = config('user_cookies_config');
                $cryptKey = config('crypt_key');
                $aes = new \AesCrypt();
                $aes->set_key($cryptKey);
                $aes->require_pkcs5();
                return $aes->encrypt($plainText);
            } catch (\Exception $ex) {
                echo $ex->getMessage();
                exit;
                errorLog(['dataEncrypt' => $ex->getMessage()]);
            }
        }
        //加密失败,返回原数据
        return $plainText;
    }
}

//数据解密
if (!function_exists('dataDecrypt')) {
    /**
     * 数据解密
     * @param string $encText
     * @return mixed|string
     */
    function dataDecrypt($encText = '')
    {
        #有可能加密失败
        $tmp = json_decode($encText, true);
        if (is_array($tmp)) {
            return $tmp;
        }
        #开始解密
        if (is_string($encText) && !empty($encText)) {
            try {
                vendor("custom.AesCrypt");
                //crypt_key 从user_cookies_config抽出 edit by caohj 2018-04-04
                //$config = config('user_cookies_config');
                $cryptKey = config('crypt_key');
                $aes = new \AesCrypt();
                $aes->set_key($cryptKey);
                $aes->require_pkcs5();
                $res = $aes->decrypt($encText);
                return json_decode($res, true);
            } catch (\Exception $ex) {
                // 返回错误信息
                errorLog(['dataDecrypt' => $ex->getMessage()]);
            }
        }
        //错误返回原数据
        return $encText;
    }
}
