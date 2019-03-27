<?php

namespace ListenRobot\Task;

use ListenRobot\Kernel\BasicListenRobot;

/**
 * 任务相关操作
 * Class Task
 * Author: DQ
 * @package ListenRobot\Task
 */
class Task extends BasicListenRobot {

    /**
     * 获取话术模版
     * @todo 后期拆分
     *
     * @return mixed
     * @throws \ErrorException
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     *
     */
    public function getTaskInfo(){
        $url = sprintf('%s/crm/v1/call_tasks/call_config_info', self::HOST);
        return $this->httpGetJson($url);
    }


    /**
     * 呼叫任务查询
     * @param string $taskId
     * Author: DQ
     */
    public function getTaskDetail($taskId = ''){
        $url = sprintf('%s/crm/v1/call_tasks/%s',self::HOST, $taskId);
        return $this->httpGetJson($url);
    }

    /**
     * 获取通话任务下，通话记录
     * @param string $taskId
     * @param int    $page
     * @param int    $pageSize
     *
     * @return mixed
     * @throws \ErrorException
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function getTaskRecord($taskId = '', $page = 1, $pageSize = 10){
        $data = [
            'page='.intval($page),
            'pageSize='.intval($pageSize),
        ];
        $url = sprintf('%s/crm/v1/call_tasks/%s/call_records?%s',self::HOST, $taskId, implode('&', $data));
        return $this->httpGetJson($url);
    }



    /**
     * 创建任务
     * Author: DQ
     */
    public function createTask($data){
        $url = sprintf('%s/crm/v1/call_tasks/create', self::HOST);
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
        $url = sprintf('%s/crm/v1/call_tasks/%s/called_phones', self::HOST, $taskId);
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
        $url = sprintf('%s/crm/v1/call_tasks/%s/commands/START', self::HOST, $taskId);
        return $this->httpPutStr($url, []);
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
        $url = sprintf('%s/crm/v1/call_tasks/%s/commands/STOP', self::HOST, $taskId);
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
        $url = sprintf('%s/crm/v1/call_tasks/%s', self::HOST, $taskId);
        return $this->httpDelStr($url, []);
    }




}