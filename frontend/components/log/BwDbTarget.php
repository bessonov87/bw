<?php

namespace app\components\log;

use yii\log\DbTarget;

class BwDbTarget extends DbTarget
{
    public function init(){
        parent::init();
    }

    /**
     * Сохраняет сообщения лога в базу данных.
     */
    public function export()
    {
        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName ([[level]], [[category]], [[log_time]], [[prefix]], [[message]])
                VALUES (:level, :category, :log_time, :prefix, :message)";
        $command = $this->db->createCommand($sql);
        $i = 1;
        $saveText = '';
        foreach ($this->messages as $message) {
            if($i == 1){
                list($text, $level, $category, $timestamp) = $message;
            } else {
                $text = $message[0];
            }
            if (!is_string($text)) {
                // exceptions may not be serializable if in the call stack somewhere is a Closure
                if ($text instanceof \Exception) {
                    $saveText .= (string) $text . "\n\n";
                } else {
                    $saveText .= VarDumper::export($text) . "\n\n";
                }
            } else {
                $saveText .= $text;
            }
            $i++;
        }

        $command->bindValues([
            ':level' => $level,
            ':category' => $category,
            ':log_time' => $timestamp,
            ':prefix' => $this->getMessagePrefix($message),
            ':message' => $saveText,
        ])->execute();
    }

    /**
     * Stores log messages to DB.
     */
    /*public function export()
    {
        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName ([[level]], [[category]], [[log_time]], [[prefix]], [[message]])
                VALUES (:level, :category, :log_time, :prefix, :message)";
        $command = $this->db->createCommand($sql);
        var_dump($this->messages);
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
            if (!is_string($text)) {
                // exceptions may not be serializable if in the call stack somewhere is a Closure
                if ($text instanceof \Exception) {
                    $text = (string) $text;
                } else {
                    $text = VarDumper::export($text);
                }
            }
            $command->bindValues([
                ':level' => $level,
                ':category' => $category,
                ':log_time' => $timestamp,
                ':prefix' => $this->getMessagePrefix($message),
                ':message' => $text,
            ])->execute();
        }
    }*/


}