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

    /**
     * Преобразование номера месяца в название
     *
     * При преобразовании учитывается падеж. По умолчанию именительный.
     * 'i' - Именительный
     * 'r' - Родительный
     * 'd' - Дательный
     * 'v' - Винительный
     * 't' - Творительный
     * 'p' - Предложный
     *
     * @param $monthNum
     * @param string $case
     * @return string
     */
    public static function rusMonth($monthNum, $case = 'i'){
        $rootMonth = [1 => 'Январ', 'Феврал', 'Март', 'Апрел', 'Ма', 'Июн', 'Июл', 'Август', 'Сентябр', 'Октябр', 'Ноябр', 'Декабр'];
        $endMonth[1] =  ['i' => 'ь', 'r' => 'я', 'd' => 'ю', 'v' => 'ь', 't' => 'ем', 'p' => 'е'];
        $endMonth[2] =  ['i' => 'ь', 'r' => 'я', 'd' => 'ю', 'v' => 'ь', 't' => 'ем', 'p' => 'е'];
        $endMonth[3] =  ['i' => '',  'r' => 'а', 'd' => 'у', 'v' => '',  't' => 'ом', 'p' => 'е'];
        $endMonth[4] =  ['i' => 'ь', 'r' => 'я', 'd' => 'ю', 'v' => 'ь', 't' => 'ем', 'p' => 'е'];
        $endMonth[5] =  ['i' => 'й', 'r' => 'я', 'd' => 'ю', 'v' => 'й', 't' => 'ем', 'p' => 'е'];
        $endMonth[6] =  ['i' => 'ь', 'r' => 'я', 'd' => 'ю', 'v' => 'ь', 't' => 'ем', 'p' => 'е'];
        $endMonth[7] =  ['i' => 'ь', 'r' => 'я', 'd' => 'ю', 'v' => 'ь', 't' => 'ем', 'p' => 'е'];
        $endMonth[8] =  ['i' => '',  'r' => 'а', 'd' => 'у', 'v' => '',  't' => 'ом', 'p' => 'е'];
        $endMonth[9] =  ['i' => 'ь', 'r' => 'я', 'd' => 'ю', 'v' => 'ь', 't' => 'ем', 'p' => 'е'];
        $endMonth[10] = ['i' => 'ь', 'r' => 'я', 'd' => 'ю', 'v' => 'ь', 't' => 'ем', 'p' => 'е'];
        $endMonth[11] = ['i' => 'ь', 'r' => 'я', 'd' => 'ю', 'v' => 'ь', 't' => 'ем', 'p' => 'е'];
        $endMonth[12] = ['i' => 'ь', 'r' => 'я', 'd' => 'ю', 'v' => 'ь', 't' => 'ем', 'p' => 'е'];

        return $rootMonth[(int)$monthNum].$endMonth[(int)$monthNum][$case];
    }
}