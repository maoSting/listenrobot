<?php
/**
 * Created by PhpStorm.
 * Author: DQ
 * Date: 2019/3/5
 * Time: 13:59
 */
namespace ListenRobot\Kernel;

use ListenRobot\Exceptions\InvalidArgumentException;
use ListenRobot\Tools\Cache;
use ListenRobot\Tools\DataArray;

class BasicListenRobot {

    public $config;

    public $accessToken = '';

    public function __construct(array $options) {
        if(empty($options['app_id'])){
            throw new InvalidArgumentException('miss config [app_id]');
        }
        if(empty($options['client_id'])){
            throw new InvalidArgumentException('miss config [client_id]');
        }
        if(empty($options['client_secret'])){
            throw new InvalidArgumentException('miss config [client_secret]');
        }
        if (!empty($options['cache_path'])){
            Cache::$cache_path = $options['cache_path'];
        }

        $this->config = new DataArray($options);
    }

    /**
     *
     * Author: DQ
     */
    public function getAccessToken(){
        if(!empty($this->accessToken)){
            return $this->accessToken;
        }
        $cache = $this->config->get('app_id').'_access_token';
        $this->accessToken = Cache::getCache($cache);
        if(!empty($this->accessToken)){
            return $this->accessToken;
        }



    }


}