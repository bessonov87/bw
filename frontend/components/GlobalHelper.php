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
     * Определение ID категории(й) по ее URL
     *
     * Используется для выборки анонсов и др.
     *
     * Категория ($cat) передается в формате строки вида 'category_url' или 'category_url/subcategory_url'.
     * Если передана одна категория, метод вернет массив с ее ID и ID всех дочерних (подкатегорий) (за исключением
     * случая, когда вторым параметром передан true; тогда метод вернет только ID данной категории без дочерних).
     * Если передана подкатегория, метод вернет только ее ID в виде массива из одного элемента.
     * Если в массиве категорий ($categories) нет такой категории, генерируется исключение NotFoundHttpException.
     *
     * @param $cat
     * @param $categories
     * @param $noChilds
     * @return array
     * @throws NotFoundHttpException
     */
    public static function getCategoryIdByUrl($cat, $noChilds = false){
        $categories = self::getCategories();
        // Если адрес состоит из категории и подкатегории, выбираем только подкатегорию
        if(strpos($cat, '/')){
            $cat = end(explode('/', $cat));
        }
        // Переиндексируем массив категорий по значению url
        $categories = ArrayHelper::index($categories, 'url');
        if(is_null($categories[$cat])){
            throw new NotFoundHttpException('Такого раздела на сайте не существует. Проверьте правильно ли вы скопировали или ввели адрес в адресную строку. Если вы перешли на эту страницу по ссылке с данного сайта, сообщите пожалуйста о неработающей ссылке нам с помощью обратной связи.');
        }
        //var_dump($categories[$cat]);
        // Если у данной категории нет родительской, проверяем на наличие дочерних и добавляем их к запросу
        if($categories[$cat]['parent_id'] == 0 && !$noChilds){
            foreach($categories as $category){
                if($category['parent_id'] == $categories[$cat]['id']){
                    $categoryIds[] = $category['id'];
                }
            }
        }
        $categoryIds[] = $categories[$cat]['id'];
        return $categoryIds;
    }

    public static function getCategoryBreadcrumb($id) {
        $categories = self::getCategories();
        $thisCategory = $categories[$id];
        // Если есть родительская
        if($thisCategory['parent_id'] != 0){
            $breadcrumbs[0]['link'] = '/'.$categories[$thisCategory['parent_id']]['url'].'/';
            $breadcrumbs[0]['label'] = $categories[$thisCategory['parent_id']]['name'];
            $breadcrumbs[1]['link'] = $breadcrumbs[0]['link'] . $thisCategory['url'] . '/';
        } else {
            $breadcrumbs[1]['link'] = '/' . $thisCategory['url'] . '/';
        }
        $breadcrumbs[1]['label'] = $thisCategory['name'];
        // Если есть родительская, ссылка на раздел будет составной, иначе только url данной категории
        return $breadcrumbs;
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