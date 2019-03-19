# listen robot PHP Composer 扩展包

https://www.lsrai.com/

## Introduction
灵声机器人,机器人客服系统,智能电销机器人价格,人工智能语音对话机器人等


## Requirement
1. PHP >= 7.0
2. **[Composer](https://getcomposer.org/)**
3. php-curl-class/php-curl-class



## Usage

#### 任务操作

```php
<?php

use ListenRobot\Task\Task;

$config = [
    'client_id'=> 'xxxxxxxx',
    'client_secret' => 'xxxxxxxx',
    'app_id' =>  'xxxxxxxx',
    'token' => 'xxxxxxxx',
];

$taskLib = new Task($config);

// 获取话术
$taskLib->getTaskInfo();

// 创建任务
$taskData = []; // 详见文档
$taskLib->createTask($taskData);

// 获取任务执行详情
$taskLib->getTaskDetail('任务ID');

// 添加通话号码
$taskLib->addTaskPhone('任务ID', ['phones' => ['手机号码1', '手机号码2']]);

// 设置任务开始
$taskLib->setTaskStatusStart('任务ID');

// 设置任务停止
$taskLib->setTaskStatusStop('任务ID');

// 删除任务
$taskLib->delTask('任务ID');

// 获取任务下通话详情
$taskLib->getTaskRecord('任务ID', '页数', '每页条数');


```

#### 通话记录

```php
<?php

use ListenRobot\Task\Record;

$config = [
    'client_id'=> 'xxxxxxxx',
    'client_secret' => 'xxxxxxxx',
    'app_id' =>  'xxxxxxxx',
    'token' => 'xxxxxxxx',
];

$recordLib = new Record($config);

// 获取通话记录详情
$recordLib->getRecordItem('通话记录ID');

// 获取通话声音文件流
$recordLib->getStream('通话记录ID');

// 下载通话声音文件
$recordLib->download('通话记录ID', '文件路径');
```



#### 服务器通知

```php
<?php

use ListenRobot\Task\Notify;

$config = [
    'client_id'=> 'xxxxxxxx',
    'client_secret' => 'xxxxxxxx',
    'app_id' =>  'xxxxxxxx',
    'token' => 'xxxxxxxx',
];

$taskLib = new Notify($config);

// 获取通知数据，并且验证签名
$taskLib->getNotify();

// 获取通知数据签名
$taskLib->getNotifySign('加密token', 'evenType 参数', 'timeStamp 参数', 'nonce 参数', 'eventData 参数');
```

## TODO


## License

MIT