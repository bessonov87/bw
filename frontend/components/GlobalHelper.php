<?php
namespace app\components;

use Yii;
use frontend\models\Category;
use yii\helpers\ArrayHelper;

class GlobalHelper
{
    public static function avatarSrc($user){
        $avatar = $user['profile']['avatar'];
        if(is_null($avatar)){
            $avatarPath = '/bw15/images/';
            $avatar = ($user['profile']['sex'] == 'm') ? 'noavatar_male.png' : 'noavatar_female.png';
        } else {
            $avatarPath = '/uploads/fotos/';
        }
        return $avatarPath.$avatar;
    }

    /**
     * Получаем список всех категорий статей
     *
     * Обращение к БД происходит только при первом вызове метода. Результат записывается в params.
     * При последующих вызовах метода, результат берется из свойства params.
     *
     * @return mixed
     */
    public static function getCategories(){
        if(isset(Yii::$app->params['categories']) && !empty(Yii::$app->params['categories'])){

        } else {
            // Получаем из базы все категории и переиндексируем по ID
            Yii::$app->params['categories'] = ArrayHelper::index(Category::find()->asArray()->all(), 'id');
        }

        return Yii::$app->params['categories'];
    }

    /**
     * Определяем Url категории по ее ID
     *
     * Url определяется с учетом наличия основной категории, если передан ID подкатегории
     *
     * @param $id
     * @return string
     */
    public static function getCategoryUrlById($id){
        $categories = self::getCategories();
        $thisCategory = $categories[$id];
        // Если есть родительская, ссылка на раздел будет составной, иначе только url данной категории
        return ($thisCategory['parent_id']) ? $categories[$thisCategory['parent_id']]['url'].'/'.$thisCategory['url'] : $thisCategory['url'];
    }
}