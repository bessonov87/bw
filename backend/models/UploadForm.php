<?php

namespace backend\models;

use common\components\helpers\GlobalHelper;
use common\models\ar\Files;
use common\models\ar\Images;
use Imagine\Image\Box;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

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

    private $_result = null;
    private $_baseUploadPathAlias = '@frontend/web/uploads/';
    private $_watermarkFileName = 'watermark_dark.png';
    private $_filesFolder = 'files';

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

    /**
     * Загружает файл или изоображение
     *
     * Результаты загрузки записываются в массив _result и могут быть получены на странице загрузки с помощью метода
     * getResult() модели.
     *
     */
    public function upload(){
        // Цикл по файлам, выбранным для загрузки
        foreach($this->files as $file) {
            // Если файл - изображение
            if(getimagesize($file->tempName) !== false){
                if($imageFileName = $this->uploadImage($file)){
                    // Сохраняем в таблице images
                    $image = new Images();
                    $image->image_name = $imageFileName;
                    $image->folder = $this->folder;
                    $image->post_id = $this->post_id;
                    $image->user_id = $this->user_id;
                    if(!$this->post_id){
                        $image->r_id = Yii::$app->request->cookies->getValue('r_id');
                    }
                    $image->date = time();
                    // Сохраняем в базу. Если не удалось, пытаемся удалить изображения с диска
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
                if($fileName = $this->uploadFile($file)){
                    // Сохраняем в таблице images
                    $uFile = new Files();
                    $uFile->name = $fileName;
                    $uFile->folder = $this->_filesFolder;
                    $uFile->post_id = $this->post_id;
                    $uFile->user_id = $this->user_id;
                    $uFile->size = filesize(Yii::getAlias($this->_baseUploadPathAlias).$this->_filesFolder.'/'.$fileName);
                    if(!$this->post_id){
                        $uFile->r_id = Yii::$app->request->cookies->getValue('r_id');
                    }
                    // Сохраняем в базу. Если не удалось, пытаемся удалить файл с диска
                    if($uFile->save()){
                        $this->_result[] = 'Файл <strong>'.$file->name.'</strong> загружен';
                    } else {
                        $this->_result[] = 'Не удалось сохранить файл <strong>'.$file->name.'</strong> в базе данных';
                        $this->_result[] = $uFile->getErrors();
                        @unlink(Yii::getAlias('@frontend/web/uploads/').$this->_filesFolder.'/'.$fileName);
                    }
                }
            }
        }
    }

    public function uploadFile(UploadedFile $file){
        $basePath = Yii::getAlias($this->_baseUploadPathAlias);
        $resultFileName = GlobalHelper::normalizeName($file->name, true);
        $resultFilePath = $basePath.$this->_filesFolder.'/'.$resultFileName;
        if(!is_writeable($basePath.$this->_filesFolder.'/')){
            $this->_result[] = 'Не удалось загрузить файл. Папка для загрузки не найдена или недоступна для записи';
            return false;
        }
        // Если файл получается сохранить
        if($file->saveAs($resultFilePath)) {
            return $resultFileName;
        }
        return false;
    }

    /**
     * Загружает изображение на диск
     *
     * При необходимости производит наложение водяного знака и создание уменьшенной копии
     *
     * @param UploadedFile $file
     * @param $options
     * @return bool|string
     */
    public function uploadImage(UploadedFile $file){
        /** @var $file \yii\web\UploadedFile */
        $basePath = Yii::getAlias($this->_baseUploadPathAlias);
        $resultFileName = GlobalHelper::normalizeName($file->name, true);
        $resultFilePath = $basePath.$this->folder.'/'.$resultFileName;
        $thumbImagePath = $basePath.$this->folder.'/thumbs/'.$resultFileName;
        $watermarkImagePath = $basePath.$this->_watermarkFileName;
        // Проверяем существование и права доступа папки для загрузки
        if($this->checkFolder($basePath.$this->folder, true)) {
            // Если файл получается сохранить
            if($file->saveAs($resultFilePath)) {
                // Если отмечена галочка "Создавать уменьшенную копию"
                if($this->create_thumb){
                    if($this->createThumb($resultFilePath, $thumbImagePath)){
                        $this->_result[] = 'Уменьшенная копия изображения создана';
                    }
                }
                // Если отмечена галочка "Добавлять водяной знак"
                if($this->watermark){
                    if($this->putWatermark($resultFilePath, $watermarkImagePath)){
                        $this->_result[] = 'Водяной знак наложен';
                    }
                }
                return $resultFileName;
            }
        }
        return false;
    }

    /**
     * Возвращает массив с результатами
     *
     * @return null
     */
    public function getResult(){
        return $this->_result;
    }

    /**
     * Проверяет существование папки и права на запись в нее для загрузки файлов и изображений
     *
     * Если папки нет, пытается создать. Необязательный аргумент thumbs указывает, нужно ли проверять существование
     * папки для уменьшенных копий изображений. Используется для проверки папки при загрузке изображений.
     *
     * @param $uploadFolder
     * @param $thumbs
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

    /**
     * Создает уменьшенную копию изображения
     *
     * @param string $sourceFilePath
     * @param string $thumbImagePath
     * @return bool
     */
    public function createThumb($sourceFilePath, $thumbImagePath){
        // Если значение 'max_pixel_side' не равно 'width' или 'height', прерываем процесс
        if(!in_array($this->max_pixel_side, ['width', 'height'])){
            $this->_result[] = 'Невозможно создать уменьшенную копию изображения. Не определена сторона для уменьшения';
            return false;
        }
        $img = Image::getImagine()->open($sourceFilePath);
        $size = $img->getSize();
        // Если размер выбранной стороны изображения больше заданного, создаем уменьшенную копию
        $side = 'get'.GlobalHelper::ucfirst($this->max_pixel_side);
        if($size->$side() > $this->max_pixel){
            $ratio = $size->getWidth()/$size->getHeight();
            if($this->max_pixel_side == 'width'){
                $width = $this->max_pixel;
                $height = round($width/$ratio);
            } elseif($this->max_pixel_side == 'height'){
                $height = $this->max_pixel;
                $width = round($height*$ratio);
            }
            if($img->resize(new Box($width, $height))->save($thumbImagePath)){
                // Если отмечена галочка "Добавлять водяной знак"
                if($this->watermark){
                    $watermarkImagePath = Yii::getAlias($this->_baseUploadPathAlias).$this->_watermarkFileName;
                    if($this->putWatermark($thumbImagePath, $watermarkImagePath)){
                        $this->_result[] = 'Водяной знак наложен';
                    }
                }
                return true;
            }
        }
    }

    /**
     * Накладывает водяной знак на изображение и сохраняет его
     *
     * Если указан аргумент $saveImagePath, изображение сохранится по этому пути. Иначе изображение с водяным знаком
     * будет сохранено вместо исходного изображения.
     *
     * @param string $sourceImagePath Полный путь к изображению, на которое накладывается водяной знак
     * @param string $watermarkImagePath Полный путь к водяному знаку
     * @param int $padding Отступ от нужней и правой границы изображения до водяного знака
     * @param string|null $saveImagePath Полный путь для сохранения изображения с водяным знаком
     * @return bool
     */
    protected function putWatermark($sourceImagePath, $watermarkImagePath, $padding = 10, $saveImagePath = null){
        /* TODO Переделать "return false" на исключения */
        // Получаем размеры изображения и водяного знака
        if(!$imgSize = getimagesize($sourceImagePath)){
            $this->_result[] = 'Не удалось наложить водяной знак. Файл не найден или не является изображением';
            return false;
        }
        if(!$watermarkSize = getimagesize($watermarkImagePath)){
            $this->_result[] = 'Не удалось наложить водяной знак. Водяной знак не найден или не является изображением';
            return false;
        }
        if(($watermarkSize[0] + $padding) > $imgSize[0] || ($watermarkSize[1] + $padding) > $imgSize[1]){
            $this->_result[] = 'Не удалось наложить водяной знак. Размеры водяного знака превышают размеры изображения';
            return false;
        }
        // Определяем координаты стартовой точки
        $startX = $imgSize[0] - $watermarkSize[0] - $padding;
        $startY = $imgSize[1] - $watermarkSize[1] - $padding;
        // Накладываем водяной знак
        $img = Image::watermark($sourceImagePath, $watermarkImagePath, [$startX, $startY]);
        // Если задан путь для сохранения изображения
        if($saveImagePath) $sourceImagePath = $saveImagePath;
        // Сохраняем файл
        if($img->save($sourceImagePath)){
            return true;
        }
        return false;
    }
}