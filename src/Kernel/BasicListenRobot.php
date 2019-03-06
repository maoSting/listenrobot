<?php

namespace ListenRobot\Kernel;

use ListenRobot\Exceptions\InvalidArgumentException;
use ListenRobot\Exceptions\InvalidResponseException;
use ListenRobot\Tools\Cache;
use ListenRobot\Tools\DataArray;
use ListenRobot\Tools\DataTransform;
use ListenRobot\Tools\RequestTool;

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

        $url = sprintf('http://al-openapi-uat.listenrobot.com:30201/oauth2/token?grant_type=client_credentials&client_id=%s&client_secret=%s', $this->config['client_id'], $this->config['client_secret']);
        $data = DataTransform::json2arr(RequestTool::get($url));
        if(!empty($data['access_token'])){
            Cache::setCache($cache, $data['access_token'], $data['expires_in'] - 10 );
        }
        return $this->accessToken = $data['access_token'];
    }


    public function setAccessToken($accessToken){
        if (!is_string($accessToken)) {
            throw new InvalidArgumentException("Invalid AccessToken type, need string.");
        }
        $cache = $this->config->get('app_id') . '_access_token';
        Cache::setCache($cache, $this->accessToken = $accessToken);
    }

    public function delAccessToken(){
        $this->accessToken = '';
        return Cache::delCache($this->config->get('app_id'). 'access_token');
    }

    /**
     * http get 简单请求
     * @param $url
     *
     * @return mixed
     * @throws \ErrorException
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function httpGetJson($url){
        try{
            return DataTransform::json2arr(RequestTool::get(
                $url,
                [],
                [
                    'listenrobot-client-id'=> $this->config['client_id'],
                    'Authorization'=> 'Bearer '.$this->accessToken,
                ]
            ));
        }catch (InvalidResponseException $e){
//            if (in_array($e->getCode(), [401])) {
//                $this->delAccessToken();
//                return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
//            }
            throw new InvalidResponseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * post 请求返回json 数组
     * @param $url
     * @param $data
     *
     * @return mixed
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function httpPostJson($url, $data){
        try{
            return DataTransform::json2arr(RequestTool::post(
                $url,
                $data,
                [
                    'listenrobot-client-id'=> $this->config['client_id'],
                    'Authorization'=> 'Bearer '.$this->accessToken,
                ]
            ));
        }catch (InvalidResponseException $e){
            //            if (in_array($e->getCode(), [401])) {
            //                $this->delAccessToken();
            //                return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
            //            }
            throw new InvalidResponseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * post 请求返回str
     * @param $url
     * @param $data
     *
     * @return null
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function httpPostStr($url, $data){
        try{
            return RequestTool::post(
                $url,
                $data,
                [
                    'listenrobot-client-id'=> $this->config['client_id'],
                    'Authorization'=> 'Bearer '.$this->accessToken,
                ]
            );
        }catch (InvalidResponseException $e){
            //            if (in_array($e->getCode(), [401])) {
            //                $this->delAccessToken();
            //                return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
            //            }
            throw new InvalidResponseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * put 请求返回str
     * @param $url
     * @param $data
     *
     * @return null
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function httpPutStr($url, $data){
        try{
            return RequestTool::put(
                $url,
                $data,
                [
                    'listenrobot-client-id'=> $this->config['client_id'],
                    'Authorization'=> 'Bearer '.$this->accessToken,
                ]
            );
        }catch (InvalidResponseException $e){
            //            if (in_array($e->getCode(), [401])) {
            //                $this->delAccessToken();
            //                return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
            //            }
            throw new InvalidResponseException($e->getMessage(), $e->getCode());
        }
    }




}