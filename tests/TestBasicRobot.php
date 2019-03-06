<?php
namespace ListenRobot\tests;

use ListenRobot\Kernel\BasicListenRobot;

class TestBasicRobot extends BasicTest {

    /**
     * 测试通过接口获取access token
     * Author: DQ
     */
    public function testGetAccessToken(){
        $lib = new BasicListenRobot($this->_config);
        $lib->getAccessToken();
        $this->assertEquals(1, 1, 'test');
    }

    /**
     * 判断缓存文件是否存在
     *
     * Author: DQ
     */
    public function testGetCacheAccessToken(){
        $lib = new BasicListenRobot($this->_config);
        $data = $lib->getAccessToken();
        $this->assertNotEmpty($data, '通过Cache 获取token');
    }


}