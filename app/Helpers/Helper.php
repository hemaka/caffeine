<?php
/**
 * 生成随机字符串
 * @param  integer $length [description]
 * @return [type]          [description]
 */

function __generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function __fillString($str, $fillStr, $isFront = true)
{
    if ($isFront) {
        return substr($fillStr, 0, strlen($fillStr) - strlen($str)) . $str;
    } else {
        return $str . substr($fillStr, 0, strlen($fillStr) - strlen($str));
    }
}

function __generateUUID($str)
{
    return explode("-", Uuid::generate(5, $str, Uuid::NS_DNS)->string)[0];
}

function __isLocal(){
    return config('app.env') == 'local';
}

function __isMobile($request)
{
    $client = strtoupper($request->header('CLIENT'));
    if ($client == 'GC' || $client == 'ANDROID' || $client == 'IOS' || $client == 'MS') {
        return true;
    }
    return false;
}