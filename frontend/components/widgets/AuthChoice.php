<?php

namespace app\components\widgets;

use yii\helpers\Html;
use yii\base\Widget;
use Yii;

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
     * @param string $text link text, if not set - default value will be generated.
     * @param array $htmlOptions link HTML options.
     * @throws InvalidConfigException on wrong configuration.
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
        /*$this->autoRender = false;
        $url = $this->getBaseAuthUrl();
        $url[$this->clientIdGetParamName] = $provider->getId();

        return Url::to($url);*/

        return '/site/auth?authclient='.$client->getName();
    }

    /**
     * Renders the main content, which includes all external services links.
     */
    protected function renderMainContent()
    {
        /*$content = [];
        foreach ($this->getClients() as $externalService) {
            //$content[] = Html::tag('li', $this->clientLink($externalService), ['class' => 'bw-auth-client']);
            $content[] = $this->clientLink($externalService);
        }
        return Html::ul($content, ['class' => 'bw-auth-clients clear', 'encode' => false]);*/
        $content = '';
        foreach ($this->getClients() as $externalService) {
            //$content[] = Html::tag('li', $this->clientLink($externalService), ['class' => 'bw-auth-client']);
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