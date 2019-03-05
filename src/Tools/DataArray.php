<?php
namespace ListenRobot\Tools;

use \ArrayAccess;

class DataArray implements ArrayAccess {
    private $_config = [];

    public function __construct(array $options) {
        $this->_config = $options;
    }

    public function set($offset, $value){
        $this->offsetSet($offset, $value);
    }

    public function get($offset){
        return $this->offsetGet($offset);
    }

    /**
     *
     * @param array $data
     * @param bool  $append 是否追加
     *
     *
     * @return array
     * Author: DQ
     */
    public function merge(array $data, $append = false){
        if ($append) {
            return $this->_config = array_merge($this->_config, $data);
        }
        return array_merge($this->_config, $data);
    }



    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_config[] = $value;
        } else {
            $this->_config[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->_config[$offset]);
    }

    public function offsetUnset($offset) {
        if (is_null($offset)) {
            $this->_config = [];
        }else{
            unset($this->_config[$offset]);
        }
    }


    public function offsetGet($offset) {
        if(is_null($offset)){
            return $this->_config;
        }
        return isset($this->_config[$offset]) ? $this->_config[$offset] : null;
    }

}