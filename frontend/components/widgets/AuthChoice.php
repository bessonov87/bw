<?php

namespace app\components\widgets;

use yii\helpers\Html;
use yii\base\Widget;
use Yii;

/**
 * Выводит кнопки для oAuth авторизации
 *
 * (Переработанный виджет из расширения yii\authclient)
 */
class AuthChoice extends Widget
{
    /**
     * @var string name of the auth client collection application component.
     * This component will be used to fetch services value if it is not set.
     */
    public $clientCollection = 'authClientCollection';
    /**
     * @var bool выводить маленькие кнопки для inline формы входа?
     */
    public $inlineForm = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        return Html::tag('div', $this->renderMainContent(), ['class' => 'social-auth']);
    }

    /**
     * Outputs client auth link.
     * @param \yii\authclient\ClientInterface $client external auth client instance.
     * @return string
     */
    public function clientLink($client)
    {
        if(!$this->inlineForm){
            $text = '<i class="icon-social icon-'.$client->getName().'"></i> '.$client->getTitle();
            $class = 'auth-btn';
        } else {
            $text = '<i class="icon-social icon-'.$client->getName().'-small"></i>';
            $class = 'auth-btn-small';
        }
        return Html::a($text, $this->createClientUrl($client), ['class' => $class.' auth-' . $client->getName(), 'title' => $client->getTitle()]);

    }

    /**
     * Composes client auth URL.
     * @param \yii\authclient\ClientInterface $client external auth client instance.
     * @return string auth URL.
     */
    public function createClientUrl($client)
    {
        return '/site/auth?authclient='.$client->getName();
    }

    /**
     * Renders the main content, which includes all external services links.
     */
    protected function renderMainContent()
    {
        $content = '';
        foreach ($this->getClients() as $externalService) {
            $content .= $this->clientLink($externalService);
        }
        return $content;
    }

    /**
     * Returns default auth clients list.
     * @return \yii\authclient\ClientInterface[] auth clients list.
     */
    protected function getClients()
    {
        /* @var $collection \yii\authclient\Collection */
        $collection = Yii::$app->get($this->clientCollection);

        return $collection->getClients();
    }
}