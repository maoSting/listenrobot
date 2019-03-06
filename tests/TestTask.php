<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Task;

class TestTask extends BasicTest {
    protected $_taskId = '';

    /**
     * 测试获取配置
     * Author: DQ
     */
    public function testGetConfig(){
        $taskLib = new Task($this->_config);
        $taskLib->getAccessToken();
        $data = $taskLib->getTaskInfo();
        $this->assertNotEmpty($data, '电话任务配置列表');
    }

    /**
     * 创建任务
     * Author: DQ
     *
     */
    public function testCreateTask(){
        $code = 'T_H0ZOCjFEGNVD';
        $time = time();
        $startTime = $time.'000';
        $endTime = ($time+86400).'000';
        $data = [
            'name' => 'name '.$time,
            'verbalTrickCode' => $code,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'callTaskPeriodRange'=>[
                '9:00:00,12:00:00', '14:00:00,20:00:00'
            ],
            'remark' => 'just for test'
        ];
        $taskLib = new Task($this->_config);
        $taskLib->getAccessToken();
        $this->_taskId = $taskLib->createTask($data);
        $this->assertNotEmpty($this->_taskId, '创建电话任务失败');
    }

    /**
     * 添加号码到通话人物
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function testAddPhoneToTask(){
        $this->_taskId = '131764412674509825';
        $taskLib = new Task($this->_config);
        $taskLib->getAccessToken();
        $taskReturn = $taskLib->addTaskPhone($this->_taskId, ['phones'=>$this->_phones]);
        $this->assertEmpty($taskReturn, '向电话任务添加手机号码 失败');
    }


}