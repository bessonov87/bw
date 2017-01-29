<?php

namespace console\controllers;

use common\models\ar\Queue;
use common\models\ar\Share;
use yii\console\Controller;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\ServerErrorHttpException;

class QueueController extends Controller
{
    const TASKS_LIMIT = 5;

    public $lockFile = '@console/runtime/queue.lock';

    public $model;

    public function beforeAction($action)
    {
        if($action->id == 'handle') {
            if (file_exists(\Yii::getAlias($this->lockFile))) {
                echo "locked\n";
                return false;
            }
            file_put_contents(\Yii::getAlias($this->lockFile), '');
        }
        return parent::beforeAction($action);
    }

    public function afterAction($action)
    {
        if($action->id == 'handle') {
            unlink(\Yii::getAlias($this->lockFile));
        }
    }

    public function actionHandle()
    {
        $tasks = Queue::find()
            ->where(['status' => Queue::STATUS_NEW])
            ->orderBy(['priority' => SORT_DESC])
            ->limit(self::TASKS_LIMIT)
            ->all();

        foreach ($tasks as $task){
            /** @var Queue $task */
            $task->updated_at = time();
            try {
                $method = $task->taskType;
                $this->$method(Json::decode($task->taskData));
                $task->status = Queue::STATUS_DONE;
            } catch (\Exception $e) {
                $task->status = Queue::STATUS_ERROR;
                $task->message = $e->getMessage();
            } finally {
                if(!$task->save()){
                    \Yii::error('Can not save Queue model');
                }
            }
        }
    }

    protected function updateSocial($data)
    {
        $url = str_ireplace('https://', '', $data['url']);
        $url = str_ireplace('http://', '', $url);
        $this->model = $this->findShareModel($url);
        $services = ['vk', 'ok', 'fa', 'mr', 'go'];

        foreach ($services as $service) {
            try {
                $this->updateCount($service, $url, $this->model);
            } catch (\Exception $e) {
                \Yii::error($service.' social update error: ' . $e->getMessage());
            }
        }

        //var_dump($vkCount);
    }

    protected function updateCount($service, $url, $share)
    {
        $httpsUrl = 'https://'.$url;
        $httpUrl = 'http://'.$url;
        if($service === 'vk' || $service === 'ok' || $service === 'fa') {
            switch ($service){
                case 'vk':
                    $serviceUrl1 = 'https://vk.com/share.php?act=count&index=1&url=' . $httpsUrl . '&format=json&callback=?';
                    $serviceUrl2 = 'https://vk.com/share.php?act=count&index=1&url=' . $httpUrl . '&format=json&callback=?';
                    break;
                case 'ok':
                    $serviceUrl1 = 'https://connect.ok.ru/dk?st.cmd=extLike&tp=json&ref='.$httpsUrl;
                    $serviceUrl2 = 'https://connect.ok.ru/dk?st.cmd=extLike&tp=json&ref='.$httpUrl;
                    break;
                case 'fa':
                    $serviceUrl1 = 'http://graph.facebook.com/?id='.$httpsUrl;
                    $serviceUrl2 = 'http://graph.facebook.com/?id='.$httpUrl;
                    break;
            }
            $count = 0;
            $data = file_get_contents($serviceUrl1);
            $count += $this->parseUpdateResult($service, $data);
            $data = file_get_contents($serviceUrl2);
            var_dump($data);
            $count += $this->parseUpdateResult($service, $data);
            var_dump($service.' '.$count);
            if ($count > 0) {
                $share->$service = $count;
                $share->updated_at = time();
                if (!$share->save()) {
                    throw new ServerErrorHttpException('Can not save Share model: ' . json_encode($share->getErrors()));
                }
            }
        } elseif($service === 'mr') {
            $data = file_get_contents('http://appsmail.ru/share/count/'.$url);
            $count = $this->parseUpdateResult($service, $data);
            if ($count > 0) {
                $share->$service = $count;
                $share->updated_at = time();
                if (!$share->save()) {
                    throw new ServerErrorHttpException('Can not save Share model: ' . json_encode($share->getErrors()));
                }
            }
        } elseif ($service === 'go') {
            $count = 0;
            $count += $this->googleApiRequest($httpsUrl);
            $count += $this->googleApiRequest($httpUrl);
            if ($count > 0) {
                $share->$service = $count;
                $share->updated_at = time();
                if (!$share->save()) {
                    throw new ServerErrorHttpException('Can not save Share model: ' . json_encode($share->getErrors()));
                }
            }
        }
    }

    protected function googleApiRequest($url)
    {
        $post = [
            'method' => 'pos.plusones.get',
            'id' => $url,
            'params' => [
                'nolog' => true,
                'id' => $url,
                'source' => 'widget',
                'userId' => '@viewer',
                'groupId' => '@self'
            ],
            'jsonrpc' => '2.0',
            'key' => 'p',
            'apiVersion' => 'v1'
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://clients6.google.com/rpc');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($post));
        //curl_setopt($curl, CURLOPT_VERBOSE, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $json = curl_exec($curl);
        curl_close($curl);

        return $this->parseUpdateResult('go', $json);
    }

    protected function parseUpdateResult($service, $result)
    {
        switch ($service){
            case 'vk':
                if (preg_match('/VK\.Share\.count\([0-9]{1,2}, ([0-9]+)\);/', $result, $matches)) {
                    return $matches[1];
                }
                break;
            case 'ok':
                $result = Json::decode($result);
                return isset($result['count']) ? $result['count'] : 0;
            case 'fa':
                $result = Json::decode($result);
                return isset($result['share']['share_count']) ? $result['share']['share_count'] : 0;
            case 'mr':
                $result = Json::decode($result);
                return isset($result['share_mm']) ? $result['count'] : 0;
            case 'go':
                $result = Json::decode($result);
                $res = isset($result['result']['metadata']['globalCounts']['count']) ? $result['result']['metadata']['globalCounts']['count'] : 0;
                return intval($res);
        }

        return 0;
    }

    protected function findShareModel($url)
    {
        $share = Share::find()->where(['url' => $url])->one();
        if(!$share){
            $share = new Share();
            $share->url = $url;
            $share->created_at = time();
            if(!$share->save()){
                throw new ServerErrorHttpException('Can not save Share model: ' . json_encode($share->getErrors()));
            }
        }
        return $share;
    }

    public function actionTest($url)
    {
        $this->updateSocial(['url' => $url]);
    }
}