<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "{{%files}}".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $r_id
 * @property string $name
 * @property string $folder
 * @property integer $size
 * @property integer $user_id
 * @property string $date
 * @property integer $download_count
 *
 * @property User $user
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%files}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'size', 'download_count'], 'integer'],
            [['user_id'], 'required'],
            [['date', 'folder', 'r_id'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'ID статьи',
            'r_id' => 'R ID',
            'name' => 'Имя файла',
            'folder' => 'Папка',
            'size' => 'Размер',
            'user_id' => 'User ID',
            'date' => 'Дата загрузки',
            'download_count' => 'Кол-во скачиваний',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
