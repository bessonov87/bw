<?php

namespace app\components\widgets;

use common\models\ar\Queue;
use common\models\ar\Share;
use yii\base\Widget;
use yii\helpers\Json;

class SharerWidget extends Widget
{
    /**
     * @inheritdoc
     */
    public function run(){
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'https://' : 'http://';
        $host = YII_DEBUG ? 'beauty-women.ru' : $_SERVER['HTTP_HOST'];
        $url = $protocol.$host.$_SERVER['REQUEST_URI'];
        $share = Share::find()->where(['url' => $host.$_SERVER['REQUEST_URI']])->one();
        if(!$share || $share->updated_at < time() - Share::UPDATE_INTERVAL){
            Queue::addTask(Json::encode(['url' => $url]), Queue::PRIORITY_NORMAL, 'updateSocial');
        }

        if($share){
            $shares = $share->vk + $share->ok + $share->fa + $share->go + $share->mr;
        } else {
            $shares = null;
        }

        return $this->render('sharer', ['shares' => $shares]);
    }

    /**
     * @inheritdoc
     */
    public function getViewPath(){
        return '@app/views/site';
    }
}