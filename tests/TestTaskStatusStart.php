<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Task;

class TestTaskStatusStart extends BasicTest {

    /**
     * 设置任务开始
     * Author: DQ
     */
    public function testTaskStart(){
        $taskLib = new Task($this->_config);
        try{
            $taskReturn = $taskLib->setTaskStatusStart($this->_task_id);
        }catch (\Exception $e){
            $taskReturn = sprintf('code:%s, msg:%s',$e->getCode(), $e->getMessage());
        }

        $this->assertEmpty($taskReturn, '设置任务 开始失败'.$taskReturn);
    }



}