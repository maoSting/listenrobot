<?php
namespace ListenRobot\tests;


use ListenRobot\Tools\Cache;

class TestCache extends BasicTest {

    private $_fileName = 'test_cache';

    private $_value = 'testbbbddd';

    /**
     * 测试生成缓存测试文件
     * @throws \ListenRobot\Exceptions\LocalCacheException
     * Author: DQ
     */
    public function testSetCache(){
        Cache::setCache($this->_fileName, $this->_value);
        $this->assertTrue(is_file(Cache::getCacheName($this->_fileName)), '缓存文件未生成');
    }

    /**
     * 测试删除缓存文件
     * Author: DQ
     */
    public function testGetCache(){
        Cache::delCache($this->_fileName);
        $this->assertNotTrue(is_file(Cache::getCacheName($this->_fileName)), '缓存文件未删除');
    }


}