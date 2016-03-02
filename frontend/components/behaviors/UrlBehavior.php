<?php

namespace frontend\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use yii\helpers\Url;

/**
 * UrlBehavior Записывает последнюю посещенную пользователем страницу в сессионную переменную previosUrl
 *
 * В любом месте приложения можно обратиться к сессионной переменной previousUrl и получить адрес предыдущей
 * просмотренной страницы:
 *      Yii::$app->session->get('previosUrl');
 *
 * Поведение подключается в контроллерах и выполняет метод afterAction по событию EVENT_AFTER_ACTION, т.е. после
 * выполнения действия в контроллере. В настройках при подключении поведения можно указать как разрешенные действия,
 * после которых будет записывать посещенная страница, так и исключенные действия, после которых последняя посещенная
 * страница записываться не будет. В противном случае, метод afterAction будет производить запись последней посещенной
 * страницы после каждого действия в контроллере. Таким образом можно исключить запись ненужных страниц, например,
 * страницы входа на сайт или регистрации.
 *
 * Свойства exceptions и allow должны передаваться в виде массивов, значениями которых должны быть ID действий.
 *
 * @package frontend\components\behaviors
 */
class UrlBehavior extends Behavior
{
    /**
     * @var array запрещенные действия
     */
    public $exceptions = [];

    /**
     * @var array разрешенные действия
     */
    public $allow = [];

    /**
     * @var bool разрешение на запись в сессию
     */
    public $allowRecording = true;

    /**
     * @inheritdoc
     */
    public function events(){
        return [
            Controller::EVENT_AFTER_ACTION => 'afterAction',
        ];
    }

    /**
     * Записывает URL данной страницы в сессию, если это разрешено
     * @return bool
     */
    public function afterAction(){
        $action = $this->owner->action->id;
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
        }
    }
}