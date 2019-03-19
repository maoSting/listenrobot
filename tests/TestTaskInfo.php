<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Task;

class TestTaskInfo extends BasicTest {


    /**
     * 获取任务详情
     * Author: DQ
     *
     */
    public function testTaskConfig(){
        $taskLib = new Task($this->_config);
        $data = $taskLib->getTaskDetail($this->_task_id);
        $this->assertNotEmpty($data, '获取电话任务详情失败');
    }



}