<?php

namespace Elrond\WorkWechat;
use Elrond\WorkWechat\Cache\TmpFile;

//这个类以后要重写，这里只会是缓存的一个入口而已
class CacheManager
{
    static public $instance = null;

    static public function get($key)
    {
        if(self::$instance == null) self::init();

        return self::$instance->get($key);
    }


    /****
     * @brief 缓存里存入数据
     * @param key 缓存键
     * @param value 缓存值
     * @param expire 缓存有效时长，单位秒，默认7200
     */
    static public function set($key, $value, $expire = 7200)
    {
        if(self::$instance == null) self::init();
        return self::$instance->set($key, $value, $expire);
    }

    static public function init()
    {
        self::$instance = new TmpFile();
    }

}
