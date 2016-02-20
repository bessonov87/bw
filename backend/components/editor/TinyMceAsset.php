<?php
namespace backend\components\editor;

use yii\web\AssetBundle;

class TinyMceAsset extends AssetBundle
{
    public $sourcePath = '@backend/components/editor/src';

    public function init()
    {
        parent::init();
        $this->js[] = 'jquery.tinymce.js';
    }
}