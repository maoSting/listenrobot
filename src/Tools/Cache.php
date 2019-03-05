<?php
/**
 * Created by PhpStorm.
 * Author: DQ
 * Date: 2019/3/5
 * Time: 14:28
 */

namespace ListenRobot\Tools;

use ListenRobot\Exceptions\LocalCacheException;

class Cache {
    public static $cache_path = null;

    /**
     * 设置缓存
     * @param        $name
     *                    缓存名称
     * @param string $value
     *                     缓存值
     * @param int    $expired
     *                       过期时间 s
     *
     * @return string
     * Author: DQ
     */
    public static function setCache($name, $value = '', $expired = 3600){
        $file = self::getCacheName($name);
        $content = serialize(['name'=> $name, $value => $value, 'expired'=> intval($expired) + time() ]);
        if(!file_put_contents($file, $content)){
            throw new LocalCacheException(sprintf('local cache path: %s, error', $file), 0);
        }
        return $file;
    }

    /**
     * 获取缓存
     * @param $name
     *
     * @return null
     * Author: DQ
     */
    public static function getCache($name){
        $file = self::getCacheName($name);
        if(file_exists($file) && ($content = file_get_contents($file))){
            $data = unserialize($content);
            if(isset($data['expires_in']) && ( intval($data['expired']) === 0 ||  $data['expired'] > time() ) ){
                return $data['expires_in'];
            }
            self::delCache($name);
        }
        return null;
    }

    /**
     * 删除缓存文件
     * @param $name
     *
     *
     * @return bool
     * Author: DQ
     */
    public static function delCache($name){
        $file = self::getCacheName($name);
        return file_exists($file) ? unlink($file) : true;
    }



    /**
     * 文件缓存目录
     * @param $name
     * Author: DQ
     */
    public static function getCacheName($name){
        if(empty(self::$cache_path)){
            self::$cache_path = dirname(dirname(__DIR__)). DIRECTORY_SEPARATOR. 'Cache'. DIRECTORY_SEPARATOR;
        }
        self::$cache_path = rtrim(self::$cache_path, '/\\'). DIRECTORY_SEPARATOR;
        file_exists(self::$cache_path) || mkdir(self::$cache_path, 0755, true);
        return self::$cache_path. $name;
    }
}