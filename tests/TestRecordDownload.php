<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Record;

class TestRecordDownload extends BasicTest {


    /**
     * 获取通话文件
     * Author: DQ
     *
     */
    public function testRecordDownload(){
        $itemId = '140973985260176386';
        $taskLib = new Record($this->_config);
        $filePath = dirname(__DIR__).DIRECTORY_SEPARATOR.'Cache'.DIRECTORY_SEPARATOR.time().'.wav';
        $taskLib->download($itemId, $filePath);
        $this->assertFileExists($filePath, '获取电话录音文件失败');
    }



}