<?php

namespace ListenRobot\Task;

use ListenRobot\Exceptions\LocalCacheException;
use ListenRobot\Exceptions\LocalDirException;
use ListenRobot\Kernel\BasicListenRobot;

/**
 * 通话记录 相关操作
 * Class Task
 * Author: DQ
 * @package ListenRobot\Task
 */
class Record extends BasicListenRobot {

    /**
     * 呼叫任务记录详情
     * @param string $recordId
     * Author: DQ
     */
    public function getRecordItem($recordId = ''){
        $url = sprintf('%s/crm/v1/call_records/%s',self::HOST, $recordId);
        return $this->httpGetJson($url);
    }

    /**
     * 获取通话详情文件流
     * @param string $recordId
     *
     * @return mixed
     * @throws \ErrorException
     * @throws \ListenRobot\Exceptions\InvalidResponseException
     * Author: DQ
     */
    public function getStream($recordId = ''){
        $url = sprintf('%s/crm/v1/call_records/%s/audio',self::HOST, $recordId);
        return $this->httpGetStr($url);
    }

    /**
     * 下载文件
     * @param string $recordId
     *                        通话记录ID
     * @param string $filePath
     *                        文件地址:路径和文件名
     *
     * @return bool
     * Author: DQ
     */
    public function download($recordId = '', $filePath = ''){
        $dir = dirname($filePath);
        if(!is_dir($dir)){
            throw new LocalDirException('dir name is not exist.');
        }
        return empty(file_put_contents($filePath, $this->getStream($recordId)));
    }



}