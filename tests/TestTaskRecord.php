<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Task;

class TestTaskRecord extends BasicTest {


    /**
     * 获取任务详情
     * Author: DQ
     *
     */
    public function testTaskRecord(){
        $taskLib = new Task($this->_config);
        for($i = 1; $i<=3; $i++){
            $data = $taskLib->getTaskRecord($this->_task_id, $i, 10);
            var_dump(count($data));
        }
        $this->assertNotEmpty($data, '获取电话任务,失败');
    }



}