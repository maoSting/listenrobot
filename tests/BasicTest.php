<?php

namespace ListenRobot\tests;

use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase  {

    // 配置
    protected $_config = null;

    // 被呼叫号码列表
    protected $_phones = [];

    // 话术模版
    protected $_template = '';

    // 任务ID
    protected $_task_id = '';


    public function __construct($name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->_config = include 'tests/config.php';
        $this->_phones = include 'tests/phones.php';
        $this->_template = include 'tests/template.php';
        $this->_task_id = include 'tests/task_id.php';
    }


    public function testConfig(){
        $this->assertNotEmpty($this->_config, '配置文件无法读取');
    }


    public function testPhone(){
        $this->assertNotEmpty($this->_phones, '等待拨打手机号码文件无法读取');
    }


    public function testTemplate(){
        $this->assertNotEmpty($this->_template, '话术模版为空');
    }



}