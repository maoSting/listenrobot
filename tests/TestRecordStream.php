<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Record;

class TestRecordStream extends BasicTest {


    /**
     * 获取通话详情详情
     * Author: DQ
     *
     */
    public function testRecordStream(){
        $itemId = '140973985260176386';
        $taskLib = new Record($this->_config);
        $data = $taskLib->getStream($itemId);
        $this->assertNotEmpty($data, '获取电话录音 文件流 失败');
    }



}