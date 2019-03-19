<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Record;

class TestRecordItem extends BasicTest {


    /**
     * 获取通话详情详情
     * Author: DQ
     *
     */
    public function testTaskConfig(){
        $itemId = '140973985260176386';
        $taskLib = new Record($this->_config);
        $data = $taskLib->getRecordItem($itemId);
        $this->assertNotEmpty($data, '获取电话记录详情失败');
    }



}