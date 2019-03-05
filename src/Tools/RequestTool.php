<?php
/**
 * Created by PhpStorm.
 * Author: DQ
 * Date: 2019/3/5
 * Time: 15:05
 */

namespace ListenRobot\Tools;

use Curl\Curl;

class RequestTool {

    /**
     * curl请求
     * @param       $url
     *                  请求url
     * @param array $data
     *                   附加数据
     *
     * @return mixed|null
     * @throws \ErrorException
     * Author: DQ
     */
    public static function get($url, $data = [], $headers = []){
        $request = new Curl();
        if(!empty($headers)){
            $request->setHeaders($headers);
        }
        $content = $request->get($url, $data);
        $request->close();
        if($request->httpStatusCode != 200){
            return null;
        }
        return $content;
    }



}