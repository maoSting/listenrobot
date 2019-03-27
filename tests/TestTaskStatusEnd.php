<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Task;

class TestTaskStatusEnd extends BasicTest {

    /**
     * 设置任务结束
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function testTaskEnd(){
        $taskLib = new Task($this->_config);
        try{
            $taskReturn = $taskLib->setTaskStatusStop($this->_task_id);
        }catch (\Exception $e){
            $taskReturn = sprintf('code:%s, msg:%s',$e->getCode(), $e->getMessage());
        }
        $this->assertEmpty($taskReturn, '设置任务 结束失败'.$taskReturn);
    }


}