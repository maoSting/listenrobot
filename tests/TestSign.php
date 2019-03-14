<?php

namespace ListenRobot\tests;

use ListenRobot\Task\Notify;

class TestSign extends BasicTest {

    /**
     * 验证签名算法是否正确
     * Author: DQ
     */
    public function testGetSign(){
        $taskLib = new Notify($this->_config);
        $token = 'p9wOq0e9PZESRSIq';
        $evenType = 'CALL_RECORD_RETURN';
        $timeStamp = "1551930482143";
        $nonce = 'QLPrGRYr';
        $data = '{"callRecords":[{"callDuration":1,"callRecordId":"132324424434096136","callStartTime":1551929703000,"callTaskId":"132323864494509059","customerPhone":"18551663773","intentCode":"04","intentName":"D类","levelRuleId":"30853754039311364","levelRuleName":"声讯推荐1——单项条件&通话评分分级规则"},{"callDuration":0,"callRecordId":"132330796034856962","callStartTime":1551930462000,"callTaskId":"132323864494509059","customerPhone":"18551663773","intentCode":"100","intentName":"E类","levelRuleId":"30853754039311364","levelRuleName":"声讯推荐1——单项条件&通话评分分级规则"}],"callTaskId":"132323864494509059"}';
        $sign = 'f6e7825230d9c66e4f44bc0bcb14fa02e17257c3';
        $returnSign = $taskLib->getNotifySign($token, $evenType, $timeStamp, $nonce, $data);
        $this->assertSame($sign, $returnSign, '签名错误');
    }
}