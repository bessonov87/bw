<?php

namespace backend\models;

use common\models\ar\Goroskop;
use yii\helpers\ArrayHelper;

class GoroskopVseZnakiForm extends Goroskop
{
    public $znakiText;

    protected $models;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [['znakiText', 'safe']]);
    }

    public function afterFind()
    {
        //var_dump($this); die;
        if(!$this->isNewRecord){
            $models = Goroskop::find()->where([
                'date' => $this->date,
                'week' => $this->week,
                'month' => $this->month,
                'year' => $this->year,
                'period' => $this->period,
                'type' => $this->type,
                //'month' => $this->month,

            ])->all();
            foreach ($models as $model){
                /** @var Goroskop $model */
                $this->znakiText[$model->zodiak] = $model->text;
            }

            $this->models = ArrayHelper::index($models, 'zodiak');
        }
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $this->saveGoroskops();
    }

    public function saveGoroskops()
    {
        foreach ($this->znakiText as $znak => $text){
            if(isset($this->models[$znak])) {
                $model = $this->models[$znak];
            } else {
                $model = new Goroskop([
                    'created_at' => time()
                ]);
                $model->zodiak = $znak;
            }
            $model->text = $text ?: 'Ожидается скоро ...';
            $model->date = $this->date;
            $model->week = $this->week?:0;
            $model->month = $this->month?:0;
            $model->year = $this->year;
            $model->period = $this->period;
            $model->type = $this->type;
            $model->approve = $this->approve;
            if(!$model->save()){
                var_dump($model->getErrors()); die;
            }
        }
    }

}