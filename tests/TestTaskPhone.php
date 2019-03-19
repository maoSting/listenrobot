<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Task;

class TestTaskPhone extends BasicTest {
    protected $_taskId = '';


    /**
     * 添加号码到通话人物
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function testAddPhoneToTask(){
        $this->_taskId = '140443070637335558';
        $taskLib = new Task($this->_config);
        $taskReturn = $taskLib->addTaskPhone($this->_taskId, ['phones'=>$this->_phones]);
        $this->assertEmpty($taskReturn, '向电话任务添加手机号码 失败');
    }


}