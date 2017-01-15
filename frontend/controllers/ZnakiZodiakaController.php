<?php

namespace frontend\controllers;

use common\components\AppData;
use common\components\helpers\GlobalHelper;
use common\models\ar\Sovmestimost;
use common\models\ar\ZnakiZodiaka;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ZnakiZodiakaController extends Controller
{
    protected $types = ['common', 'man', 'woman', 'child', 'career', 'health', 'sex'];

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionZnak($znak, $type)
    {
        if(!in_array($type, $this->types)){
            throw new NotFoundHttpException('Страница не найдена. Неизвестный тип');
        }
        $znakModel = ZnakiZodiaka::find()
            ->where(['znak_id' => GlobalHelper::engZodiak($znak, true)])
            ->one();

        if(!$znakModel || !$znakModel->$type){
            throw new NotFoundHttpException('Страница не найдена');
        }

        $text = !$znakModel->$type || $znakModel->$type == '*' ? 'Ожидается скоро ...' : '';

        return $this->render('znak', [
            'znak' => $znak,
            'type' => $type,
            'znakModel' => $znakModel,
            'text' => $text,
        ]);
    }

    public function actionSovmestimostIndex($znak, $znakMan, $znakWoman)
    {
        $znaki = AppData::$engZnakiTranslit;
        if($znak && !in_array($znak, $znaki)){
            throw new NotFoundHttpException('Страница не найдена');
        }

        if(($znakMan && !in_array($znakMan, $znaki)) || ($znakWoman && !in_array($znakWoman, $znaki))){
            throw new NotFoundHttpException('Страница не найдена');
        }

        if(!$znak && !$znakWoman && !$znakMan){
            return $this->render('sovmestimost-index');
        } else {
            $znakModel = $znak ? ZnakiZodiaka::findOne(['znak_id' => GlobalHelper::engZodiak($znak, true)]) : null;
            return $this->render('sovmestimost-znak', [
                'znak' => $znak,
                'znakMan' => $znakMan,
                'znakWoman' => $znakWoman,
                'znakModel' => $znakModel,
            ]);
        }
    }

    public function actionSovmestimost($znakMan, $znakWoman)
    {
        $znaki = AppData::$engZnakiTranslit;
        if(!in_array($znakMan, $znaki) || !in_array($znakWoman, $znaki)){
            throw new NotFoundHttpException('Страница не найдена');
        }

        $znakMan = GlobalHelper::engZodiak($znakMan, true);
        $znakWoman = GlobalHelper::engZodiak($znakWoman, true);

        $sovmestimost = Sovmestimost::find()
            ->where(['man' => $znakMan, 'woman' => $znakWoman])
            ->one();

        if(!$sovmestimost){
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('sovmestimost-znaki-text', [
            'znakMan' => $znakMan,
            'znakWoman' => $znakWoman,
            'sovmestimost' => $sovmestimost,
        ]);
    }
}