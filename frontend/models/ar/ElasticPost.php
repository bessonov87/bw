<?php

namespace frontend\models\ar;

use yii\elasticsearch\ActiveRecord;


class ElasticPost extends ActiveRecord
{
    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        // path mapping for '_id' is setup to field 'id'
        return ['id', 'title', 'full', 'date'];
    }
}