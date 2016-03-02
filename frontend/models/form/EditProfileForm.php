<?php

namespace frontend\models\form;

use common\models\ar\User;
use common\models\ar\UserProfile;
use common\models\BwImage;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ManipulatorInterface;
use yii\base\Model;
use Yii;
use yii\imagine\Image;
use app\components\StartPoint;

/**
 * Форма редактирования профиля пользователя
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @since 1.0
 */
class EditProfileForm extends UserProfile
{
    public $birthYear;
    public $birthMonth;
    public $birthDay;
    public $image = null;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birthYear', 'birthMonth', 'birthDay'], 'integer'],
            [['info'], 'string', 'max' => 1000],
            [['sex'], 'string', 'max' => 1],
            [['name', 'surname'], 'string', 'max' => 50],
            [['country'], 'string', 'max' => 60],
            [['city'], 'string', 'max' => 50],
            [['image'], 'image',
                'extensions' => 'png, jpg', 'mimeTypes' => 'image/jpeg, image/png',
                'minWidth' => 100, 'minHeight' => 100,
                'maxSize' => 2*1024*1024,
                'skipOnEmpty' => true,
            ],
            [['signature'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image' => 'Фотография/Аватар',
            'name' => 'Имя',
            'sex' => 'Пол',
            'surname' => 'Фамилия',
            'info' => 'Информация о себе',
            'signature' => 'Подпись',
        ];
    }

    /**
     * Загружает аватар
     *
     * @param \yii\web\UploadedFile $avatar
     * @return bool
     */
    public function uploadAvatar(\yii\web\UploadedFile $avatar){
        $uploadPath = Yii::getAlias(Yii::$app->params['admin']['uploadsPathAlias'].'/fotos/');
        $avatarFileName = 'foto_' . Yii::$app->user->getId() . '.' . $avatar->extension;
        $avatarFilePath = $uploadPath . $avatarFileName;
        if($avatar->saveAs($avatarFilePath)){
            $this->createThumb($avatarFilePath);
            $this->avatar = $avatarFileName;
            return true;
        }
        return false;
    }

    /**
     * Сохраняет профиль, предварительно задавая некоторые значения
     *
     * @return bool
     */
    public function saveProfile(){
        $this->birth_date = sprintf('%04d', $this->birthYear) . '-' . sprintf('%02d', $this->birthMonth) . '-' . sprintf('%02d', $this->birthDay);
        if($this->save()){
            return true;
        }
        return false;
    }

    /**
     * Создает уменьшенную и обрезанную копию изображения
     *
     * Обрезка производится до 200 пикселей
     *
     * @param string $sourceFilePath
     * @param string $thumbImagePath
     * @return bool
     */
    public function createThumb($sourceFilePath){
        $imageWidth = 200;
        $imageRatio = 1.5;
        $img = Image::getImagine()->open($sourceFilePath);
        $size = $img->getSize();
        // Если высота больше ширины
        if($size->getHeight() > $size->getWidth()){
            //$img = BwImage::thumbnail($sourceFilePath, $imageWidth, $imageWidth, ManipulatorInterface::THUMBNAIL_INSET)->save($sourceFilePath);
            $imageHeight = round($imageWidth*$imageRatio);
            $box = new Box($size->getWidth(), $size->getWidth()*$imageRatio);
            $start = new StartPoint($box);
            $img->crop($start, $box);
            $img->resize(new Box($imageWidth, $imageHeight))->save($sourceFilePath);
        } else {
            $imageHeight = round($imageWidth/$imageRatio);
            $img = BwImage::thumbnail($sourceFilePath, $imageWidth, $imageHeight)->save($sourceFilePath);
        }
    }
}