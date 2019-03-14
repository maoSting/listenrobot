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
        $taskId = '131764412674509825';
        $taskLib = new Task($this->_config);
        try{
            $taskReturn = $taskLib->delTask($taskId);
        }catch (\Exception $e){
            $taskReturn = sprintf('code:%s, msg:%s',$e->getCode(), $e->getMessage());
        }
        $this->assertEmpty($taskReturn, '删除任务失败'.$taskReturn);
    }
}