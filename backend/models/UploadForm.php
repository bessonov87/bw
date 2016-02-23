<?php

namespace backend\models;

use common\components\helpers\GlobalHelper;
use common\models\ar\Images;
use Imagine\Image\Box;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;

class UploadForm extends Model
{
    public $files = [];
    public $post_id;
    public $user_id;
    public $create_thumb;
    public $max_pixel;
    public $max_pixel_side;
    public $on_server;
    public $watermark;
    public $folder = 'files';

    protected $_result = null;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'post_id', 'files'], 'required'],
            [['user_id', 'max_pixel'], 'integer'],
            ['max_pixel_side','in','range'=>['width','height'],'strict'=>false],
            [['create_thumb', 'watermark', 'post_id'], 'safe'],
            [['on_server', 'folder'], 'string'],
            [['files'], 'file',
                'skipOnEmpty' => 'false',
                'maxFiles' => 10,
                'extensions' => ArrayHelper::merge(Yii::$app->params['admin']['images']['allowedExt'], Yii::$app->params['admin']['files']['allowedExt']),
            ],
            ['user_id', 'exist',
                'targetClass' => '\common\models\ar\User',
                'targetAttribute' => 'id',
                'message' => 'There is no user with such id.'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'create_thumb' => 'Создавать уменьшенную копию',
            'watermark' => 'Добавлять водяной знак',
        ];
    }

    public function upload(){
        $options['post_id'] = $this->post_id;
        $options['user_id'] = $this->user_id;
        $options['create_thumb'] = $this->create_thumb;
        $options['max_pixel'] = $this->max_pixel;
        $options['max_pixel_side'] = $this->max_pixel_side;
        $options['on_server'] = $this->on_server;
        $options['watermark'] = $this->watermark;
        $options['folder'] = $this->folder;

        foreach($this->files as $file) {
            if(getimagesize($file->tempName) !== false){
                if($imageFileName = $this->uploadImage($file, $options)){
                    // Сохраняем в таблице images
                    $image = new Images();
                    $image->image_name = $imageFileName;
                    $image->folder = $options['folder'];
                    $image->post_id = $this->post_id;
                    $image->user_id = $this->user_id;
                    if(!$this->post_id){
                        $image->r_id = Yii::$app->request->cookies->getValue('r_id');
                    }
                    $image->date = time();
                    if($image->save()){
                        $this->_result[] = 'Изображение <strong>'.$file->name.'</strong> загружено';
                    } else {
                        $this->_result[] = 'Не удалось сохранить изображение <strong>'.$file->name.'</strong> в базе данных';
                        $this->_result[] = $image->getErrors();
                        @unlink(Yii::getAlias('@frontend/web/uploads/').$this->folder.'/'.$imageFileName);
                        @unlink(Yii::getAlias('@frontend/web/uploads/').$this->folder.'/thumbs/'.$imageFileName);
                    }


                }
            } else {
                if($this->uploadFile($file, $options)){
                    $this->_result[] = 'Файл <strong>'.$file->name.'</strong> загружен';
                }
            }
        }
    }

    public function uploadFile($file, $options){
        return true;
    }

    public function uploadImage($file, $options){
        /** @var $file \yii\web\UploadedFile */
        $basePath = Yii::getAlias('@frontend/web/uploads/');
        $resultFileName = GlobalHelper::normalizeName($file->name, true);
        $resultFilePath = $basePath.$options['folder'].'/'.$resultFileName;
        $thumbImagePath = $basePath.$options['folder'].'/thumbs/'.$resultFileName;
        // Проверяем существование и права доступа папки для загрузки
        if($this->checkFolder($basePath.$options['folder'], true)) {
            // Если файл получается сохранить
            if($file->saveAs($resultFilePath)) {
                // Если отмечена галочка "Создавать уменьшенную копию"
                if($options['create_thumb']){
                    $img = Image::getImagine()->open($resultFilePath);
                    $size = $img->getSize();
                    // Если размер выбранной стороны изображения больше заданного, создаем уменьшенную копию
                    $side = 'get'.GlobalHelper::ucfirst($options['max_pixel_side']);
                    if($size->$side() > $options['max_pixel']){
                        $ratio = $size->getWidth()/$size->getHeight();
                        if($options['max_pixel_side'] == 'width'){
                            $width = $options['max_pixel'];
                            $height = round($width/$ratio);
                        } elseif($options['max_pixel_side'] == 'height'){
                            $height = $options['max_pixel'];
                            $width = round($height*$ratio);
                        }
                        $img->resize(new Box($width, $height))->save($thumbImagePath);
                    }
                }
                return $resultFileName;
            }
        }
        return false;
    }

    public function getResult(){
        return $this->_result;
    }

    /**
     * Проверяет существование папки и права на запись в нее для загрузки файлов и изображений
     *
     * Если папки нет, пытается создать. Необязательный аргумент thumbs указывает, нужно ли проверять существование
     * папки для уменьшенных копий изображений. Используется для проверки папки при загрузке изображений.
     *
     * @param $basePath
     * @param $uploadFolder
     * @return bool true, если папка есть и запись в нее разрешена; false в противном случае
     */
    public function checkFolder($uploadFolder, $thumbs = false){
        $folderResult = false;
        $thumbsResult = ($thumbs) ? false : true;
        if(is_writable($uploadFolder)){
            $folderResult = true;
        } else {
            if(mkdir($uploadFolder, 0777)){
                $folderResult = true;
            }
        }

        if($thumbs){
            $thumbsFolder = $uploadFolder.'/thumbs';
            $thumbsResult = $this->checkFolder($thumbsFolder);
        }

        if($folderResult && $thumbsResult){
            return true;
        } else {
            return false;
        }
    }
}