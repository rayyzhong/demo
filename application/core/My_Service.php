<?php

/**
 * Created by PhpStorm.
 * User: hsbchsbc
 * Date: 2017/12/19
 * Time: 上午12:28
 */
class My_Service
{
    public function __construct()
    {
        log_message('debug', "Service Class Initialized");

    }

    function __get($key)
    {
        $CI = & get_instance();
        return $CI->$key;
    }
}