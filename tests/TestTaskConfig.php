<?php
namespace ListenRobot\tests;

use ListenRobot\Task\Task;
use ListenRobot\Tools\Cache;

class TestTaskConfig extends BasicTest {
    protected $_taskId = '';

    /**
     * 测试获取配置
     * Author: DQ
     */
    public function testGetConfig(){
        $taskLib = new Task($this->_config);
        $data = $taskLib->getTaskInfo();
        $this->assertNotEmpty($data, '获取电话任务配置列表失败');
    }


    public function testModifiedCacheToken(){
        $file = Cache::getCacheName($this->_config['app_id'].'_access_token');
        if(is_file($file)){
            $cache = unserialize(file_get_contents($file));
            $cache['value'] .= time();
            Cache::setCache($this->_config['app_id'].'_access_token', $cache['value']);


            $taskLib = new Task($this->_config);
            $data = $taskLib->getTaskInfo();

            $this->assertNotEmpty($data, '修改缓存文件, 获取电话任务配置列表失败');
        }
    }

}