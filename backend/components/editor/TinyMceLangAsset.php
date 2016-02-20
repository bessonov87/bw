<?php
namespace backend\components\editor;

use yii\web\AssetBundle;

class TinyMceLangAsset extends AssetBundle
{
    public $sourcePath = '@backend/components/editor/src';

    public $depends = [
        'backend\components\editor\TinyMceAsset'
    ];
}
