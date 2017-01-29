<?php

namespace common\models\ar;

use common\models\Queue as BaseQueue;

class Queue extends BaseQueue
{
    const STATUS_NEW = 1;
    const STATUS_PROCCESSING = 2;
    const STATUS_DONE = 3;
    const STATUS_ERROR = 4;

    const PRIORITY_LOWEST = 1;
    const PRIORITY_LOW = 3;
    const PRIORITY_NORMAL = 5;
    const PRIORITY_HIGH = 7;
    const PRIORITY_HIGHEST = 10;

    public static function addTask($taskData, $priority, $taskType)
    {
        $task = new self([
            'taskData' => $taskData,
            'priority' => $priority,
            'taskType' => $taskType,
            'created_at' => time()
        ]);

        if(!$task->save()){
            \Yii::error('Can not add new task: '.json_encode($task->getErrors()));
        }
    }
}