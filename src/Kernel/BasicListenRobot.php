<?php

namespace ListenRobot\Kernel;

use ListenRobot\Exceptions\InvalidArgumentException;
use ListenRobot\Exceptions\InvalidResponseException;
use ListenRobot\Tools\Cache;
use ListenRobot\Tools\DataArray;
use ListenRobot\Tools\DataTransform;
use ListenRobot\Tools\RequestTool;

class BasicListenRobot {

    const VERSION = '1.6';

    public $config;

    //cache access_token 文件名称
    private $_fileName = '_access_token';

    // access token
    public $accessToken = '';

    // 当前请求方法
    private $_currentMethod = [];

    // 是否是重试
    private $_isTry = false;


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
     * 获取灵声版本号
     * @return string
     * Author: DQ
     */
    public function getVersion(){
        return self::VERSION;
    }


    /**
     * 获取access token
     * @return null|string
     * @throws \ErrorException
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * @throws \ListenRobot\Exceptions\LocalCacheException
     * Author: DQ
     */
    public function getAccessToken(){
        if(!empty($this->accessToken)){
            return $this->accessToken;
        }
        $cache = $this->config->get('app_id').$this->_fileName;
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

    /**
     * 设置
     * @param $accessToken
     *
     * @throws \ListenRobot\Exceptions\LocalCacheException
     * Author: DQ
     */
    public function setAccessToken($accessToken){
        if (!is_string($accessToken)) {
            throw new InvalidArgumentException("Invalid AccessToken type, need string.");
        }
        $cache = $this->config->get('app_id') . $this->_fileName;
        Cache::setCache($cache, $this->accessToken = $accessToken);
    }

    public function delAccessToken(){
        $this->accessToken = '';
        return Cache::delCache($this->config->get('app_id'). $this->_fileName);
    }


    /**
     * 注册请求
     * @param       $method
     *                     方法
     * @param array $arguments
     *                        参数
     *
     * @throws \ErrorException
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * @throws \ListenRobot\Exceptions\LocalCacheException
     * Author: DQ
     */
    protected function registerApi($method, $arguments = []){
        $this->_currentMethod = ['method'=> $method, 'arguments'=> $arguments];
        if(empty($this->accessToken)){
            $this->getAccessToken();
        }
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
            $this->registerApi(__FUNCTION__, func_get_args());
            return DataTransform::json2arr(RequestTool::get(
                $url,
                [],
                [
                    'listenrobot-client-id'=> $this->config['client_id'],
                    'Authorization'=> 'Bearer '.$this->accessToken,
                ]
            ));
        }catch (InvalidResponseException $e){
            if (!$this->_isTry && in_array($e->getCode(), [401])) {
                $this->delAccessToken();
                $this->_isTry = true;
                return call_user_func_array([$this, $this->_currentMethod['method']], $this->_currentMethod['arguments']);
            }
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
            $this->registerApi(__FUNCTION__, func_get_args());
            return DataTransform::json2arr(RequestTool::post(
                $url,
                $data,
                [
                    'listenrobot-client-id'=> $this->config['client_id'],
                    'Authorization'=> 'Bearer '.$this->accessToken,
                ]
            ));
        }catch (InvalidResponseException $e){
            if (!$this->_isTry && in_array($e->getCode(), [401])) {
                $this->delAccessToken();
                $this->_isTry = true;
                return call_user_func_array([$this, $this->_currentMethod['method']], $this->_currentMethod['arguments']);
            }
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
            $this->registerApi(__FUNCTION__, func_get_args());
            return RequestTool::post(
                $url,
                $data,
                [
                    'listenrobot-client-id'=> $this->config['client_id'],
                    'Authorization'=> 'Bearer '.$this->accessToken,
                ]
            );
        }catch (InvalidResponseException $e){
            if (!$this->_isTry && in_array($e->getCode(), [401])) {
                $this->delAccessToken();
                $this->_isTry = true;
                return call_user_func_array([$this, $this->_currentMethod['method']], $this->_currentMethod['arguments']);
            }
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
            $this->registerApi(__FUNCTION__, func_get_args());
            return RequestTool::put(
                $url,
                $data,
                [
                    'listenrobot-client-id'=> $this->config['client_id'],
                    'Authorization'=> 'Bearer '.$this->accessToken,
                ]
            );
        }catch (InvalidResponseException $e){
            if (!$this->_isTry && in_array($e->getCode(), [401])) {
                $this->delAccessToken();
                $this->_isTry = true;
                return call_user_func_array([$this, $this->_currentMethod['method']], $this->_currentMethod['arguments']);
            }
            throw new InvalidResponseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * del 请求返回str
     * @param $url
     * @param $data
     *
     * @return mixed|null
     * @throws \ErrorException
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function httpDelStr($url, $data){
        try{
            $this->registerApi(__FUNCTION__, func_get_args());
            return RequestTool::del(
                $url,
                $data,
                [
                    'listenrobot-client-id'=> $this->config['client_id'],
                    'Authorization'=> 'Bearer '.$this->accessToken,
                ]
            );
        }catch (InvalidResponseException $e){
            if (!$this->_isTry && in_array($e->getCode(), [401])) {
                $this->delAccessToken();
                $this->_isTry = true;
                return call_user_func_array([$this, $this->_currentMethod['method']], $this->_currentMethod['arguments']);
            }
            throw new InvalidResponseException($e->getMessage(), $e->getCode());
        }
    }




}