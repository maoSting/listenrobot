<?php
/**
 * Created by PhpStorm.
 * Author: DQ
 * Date: 2019/3/7
 * Time: 11:08
 */

namespace ListenRobot\Task;

use ListenRobot\Exceptions\InvalidResponseException;
use ListenRobot\Kernel\BasicListenRobot;
use ListenRobot\Tools\DataTransform;

class Notify extends BasicListenRobot {

    /**
     * 签名获取数据
     * @return mixed
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function getNotify(){
        $data = DataTransform::json2arr(file_get_contents('php://input'));
        if(isset($data['msgSignature']) && $this->getNotifySign($this->config['token'], $data['eventType'], $data['timestamp'], $data['nonce'], $data['eventData']) === $data['msgSignature']){
            return $data;
        }
        throw new InvalidResponseException('Invalid Notify.', 0);
    }

    /**
     * 获取签名
     * @param $token
     * @param $evenType
     * @param $timeStamp
     * @param $nonce
     * @param $data
     *
     * @return string
     * Author: DQ
     */
    public function getNotifySign($token, $evenType, $timeStamp, $nonce, $data){
        $source = [
            $token, $evenType, $timeStamp, $nonce, $data
        ];
        sort($source);
        $sha1 = sha1(join('', $source));
        $byteSha = str_split($sha1);
        $bytes = array();
        foreach ($byteSha as $val) {
            $bytes[] = dechex(ord($val));
        }
        $hexStr = array();
        foreach ($bytes as $val) {
            if (strlen($val) < 2){
                $val .= 0;
            }
            $hexStr[] = chr(hexdec($val));
        }
        return join('', $hexStr);
    }

}