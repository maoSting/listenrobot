<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Task;

class TestTaskStatus extends BasicTest {
    protected $_taskId = '';

    /**
     * 设置任务开始
     * Author: DQ
     */
    public function testTaskStart(){
        $this->_taskId = '131764412674509825';
        $taskLib = new Task($this->_config);
        $taskLib->getAccessToken();
        try{
            $taskReturn = $taskLib->setTaskStatusStart($this->_taskId);
        }catch (\Exception $e){
            $taskReturn = sprintf('code:%s, msg:%s',$e->getCode(), $e->getMessage());
        }

        $this->assertEmpty($taskReturn, '设置任务 开始失败'.$taskReturn);
    }

    /**
     * 设置任务结束
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function testTaskEnd(){
        $this->_taskId = '131764412674509825';
        $taskLib = new Task($this->_config);
        $taskLib->getAccessToken();
        try{
            $taskReturn = $taskLib->setTaskStatusStop($this->_taskId);
        }catch (\Exception $e){
            $taskReturn = sprintf('code:%s, msg:%s',$e->getCode(), $e->getMessage());
        }
        $this->assertEmpty($taskReturn, '设置任务 结束失败'.$taskReturn);
    }


}