<?php
/**
 * Created by PhpStorm.
 * Author: DQ
 * Date: 2019/3/7
 * Time: 10:37
 */

namespace ListenRobot\tests;

use ListenRobot\Task\Task;

class TestTaskDel extends BasicTest {

    /**
     * 删除任务
     * Author: DQ
     */
    public function testTaskDel(){
        $this->_taskId = '131764412674509825';
        $taskLib = new Task($this->_config);
        $taskLib->getAccessToken();
        try{
            $taskReturn = $taskLib->delTask($this->_taskId);
        }catch (\Exception $e){
            $taskReturn = sprintf('code:%s, msg:%s',$e->getCode(), $e->getMessage());
        }
        $this->assertEmpty($taskReturn, '删除任务失败'.$taskReturn);
    }
}