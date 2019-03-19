<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Task;

class TestTaskCreate extends BasicTest {
    protected $_taskId = '';


    /**
     * 创建任务
     * Author: DQ
     *
     */
    public function testCreateTask(){

        // 模版
        $code = $this->_template;
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
            'remark' => 'just for test',
            'redialConfig' => [
                'redialTimes' => 2,
                'redialInterval' => 2,
                'responseCodes' => [
                    "40",
                    "408"
                ],
            ]
        ];
        $taskLib = new Task($this->_config);
        $this->_taskId = $taskLib->createTask($data);
        echo sprintf('任务 task_id %s', $this->_taskId);
        $this->assertNotEmpty($this->_taskId, '创建电话任务失败');
    }




}