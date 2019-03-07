<?php

namespace ListenRobot\Task;

use ListenRobot\Kernel\BasicListenRobot;

class Task extends BasicListenRobot {

    /**
     * 获取呼叫任务相关配置信息
     *
     * @return mixed
     * @throws \ErrorException
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     *
     */
    public function getTaskInfo(){
        $url = 'http://al-openapi-uat.listenrobot.com:30201/crm/v1/call_tasks/call_config_info';
        return $this->httpGetJson($url);
    }

    /**
     * 创建任务
     * Author: DQ
     */
    public function createTask($data){
        $url = 'http://al-openapi-uat.listenrobot.com:30201/crm/v1/call_tasks/create';
        // 参数校验？
        return $this->httpPostStr($url, $data);
    }

    /**
     * 任务添加号码
     * @param array $data
     *
     * @return null
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function addTaskPhone($taskId = '', $data = []){
        $url = sprintf('http://al-openapi-uat.listenrobot.com:30201/crm/v1/call_tasks/%s/called_phones', $taskId);
        // 参数校验？
        return $this->httpPostStr($url, $data);
    }

    /**
     * 设置任务开始
     * @param $taskId
     *
     * @return null
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function setTaskStatusStart($taskId){
        $url = sprintf('http://al-openapi-uat.listenrobot.com:30201/crm/v1/call_tasks/%s/commands/START', $taskId);
        return $this->httpPostStr($url, []);
    }

    /**
     * 设置任务停止
     * @param $taskId
     *
     * @return null
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function setTaskStatusStop($taskId){
        $url = sprintf('http://al-openapi-uat.listenrobot.com:30201/crm/v1/call_tasks/%s/commands/STOP', $taskId);
        return $this->httpPutStr($url, []);
    }


    /**
     * 任务删除
     * @param $taskId
     *               任务ID
     *
     * @return null
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function delTask($taskId){
        $url = sprintf('http://al-openapi-uat.listenrobot.com:30201/crm/v1/call_tasks/%s', $taskId);
        return $this->httpDelStr($url, []);
    }



}