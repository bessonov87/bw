<?php

namespace backend\components\grids;

use yii\grid\ActionColumn;

class BwActionColumn extends ActionColumn
{
    public $contentOptions = [
        'style' => 'white-space: nowrap; text-align: center; letter-spacing: 0.1em; max-width: 7em;',
    ];
}