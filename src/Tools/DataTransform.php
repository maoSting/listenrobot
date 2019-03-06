<?php

namespace ListenRobot\Tools;

use ListenRobot\Exceptions\InvalidResponseException;

class DataTransform {

    public static function json2arr($json){
        $rs = json_decode($json, true);
        if(empty($rs)){
            throw new InvalidResponseException('invalid response.', 0);
        }
        if(isset($rs['code'])){
            throw new InvalidResponseException($rs['message'], $rs['code']);
        }

        return $rs;
    }
}