<?php
/**
 * Created by PhpStorm.
 * Author: DQ
 * Date: 2019/3/5
 * Time: 14:53
 */

namespace ListenRobot\Exceptions;

class LocalCacheException extends InvalidArgumentException {
    public $raw = [];

    public function __construct($message = "", $code = 0, $raw = []) {
        parent::__construct($message, intval($code));
        $this->raw = $raw;
    }
}