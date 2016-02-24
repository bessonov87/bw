<?php

namespace backend\models;

use common\models\ar\Images;
use Yii;
use yii\base\Model;

class DeleteFilesForm extends Model
{
    public $files;

    private $_result = [];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['files', 'each', 'rule' => ['string']],
        ];
    }

    public function delete(){
        if(is_array($this->files)){
            foreach($this->files as $file){
                $filesArray = explode('|', $file);
                if($filesArray[0] == 'image'){
                    $baseId = $filesArray[1];
                    $imageFolder = $filesArray[2];
                    $imageName = $filesArray[3];
                    $thumb = $filesArray[5];
                    $imageAr = Images::findOne($baseId);
                    if($imageAr->delete()){
                        $this->_result[] = 'Изображение <strong>'.$imageName.'</strong> удалено из базы данных';
                        $imagePath = Yii::getAlias(Yii::$app->params['admin']['uploadsPathAlias']).$imageFolder.'/'.$imageName;
                        if(unlink($imagePath)){
                            $this->_result[] = 'Изображение <strong>'.$imagePath.'</strong> удалено с диска';
                        } else {
                            $this->_result[] = 'При удалении изображения <strong>'.$imagePath.'</strong> произошла ошибка';
                        }
                        if($thumb){
                            $thumbPath = Yii::getAlias(Yii::$app->params['admin']['uploadsPathAlias']).$imageFolder.'/thumbs/'.$imageName;
                            if(unlink($thumbPath)){
                                $this->_result[] = 'Изображение <strong>thumbs/'.$imageName.'</strong> удалено с диска';
                            } else {
                                $this->_result[] = 'При удалении изображения <strong>thumbs/'.$imageName.'</strong> произошла ошибка';
                            }
                        }
                    }
                } elseif($filesArray[0] == 'file') {
                    $baseId = $filesArray[1];
                }
            }
        }
    }

    /**
     * Возвращает массив с результатами
     *
     * @return null
     */
    public function getResult(){
        return $this->_result;
    }
}