<?php

namespace frontend\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use yii\helpers\Url;

class UrlBehavior extends Behavior
{
    public $exceptions = [];

    public $allow = [];

    public $allowRecording = true;

    public function events(){
        return [
            Controller::EVENT_AFTER_ACTION => 'afterAction',
        ];
    }

    public function afterAction(){
        $action = $this->owner->action->id;
        //$route = $this->owner->module->requestedRoute;
        //var_dump(Yii::$app->session->get('previosUrl'));
        $url = Yii::$app->request->absoluteUrl;
        if(!empty($this->exceptions) && empty($this->allow)) {
            if(in_array($action, $this->exceptions)){
                return false;
            }
        }
        if(!empty($this->allow)){
            if(!in_array($action, $this->allow)){
                return false;
            }
        }

        if($this->allowRecording) {
            Yii::$app->session->set('previosUrl', $url);
            //var_dump($url);
        }
    }
}