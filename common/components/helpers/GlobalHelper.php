<?php
namespace app\components;

use Yii;
use app\models\Category;
use yii\helpers\ArrayHelper;

class GlobalHelper
{

    /**
     * Convert BR tags to newlines and carriage returns.
     *
     * @param string The string to convert
     * @return string The converted string
     */
    public static function br2nl ( $string )
    {
        return preg_replace('/\<br(\s*)?\/?\>/i', PHP_EOL, $string);
    }

    public static function avatarSrc($user){
        $avatar = $user['profile']['avatar'];
        $avatarPath = '/uploads/fotos/';
        if(!$avatar) {
            $avatar = ($user['profile']['sex'] == 'm') ? 'noavatar_male.png' : 'noavatar_female.png';
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
            $cats = explode('/', $cat);
            $cat = end($cats);
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

    /**
     * Добавление в breadcrumbs для статьи ее категории (подкатегории)
     *
     * Если статья размещена в подкатегории, результатом будет массив с двумя ссылками - на категорию и подкатегорию.
     * Если статья размещена в категории, результатом будет массив с одной ссылкой - только на категорию.
     *
     * @param $id ID категории (или подкатегории)
     * @return array Массив c относительной ссылкой(-ами) и текстом ссылки(-ок)
     */
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
     * При преобразовании названия месяца в номер падеж не имеет значения, т.к. для поиска изпользуется только корень.
     *
     * @param int|string $monthNum Номер месяца (1-12) или название в любом падеже
     * @param string $case Падеж
     * @param bool $invert  Обратное преобразование (название месяца в номер)
     * @return string
     */
    public static function rusMonth($monthNum, $case = 'i', $invert = false){
        $rootMonth = [1 => 'январ', 'феврал', 'март', 'апрел', 'ма', 'июн', 'июл', 'август', 'сентябр', 'октябр', 'ноябр', 'декабр'];
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

    /**
     * Преобразование номера месяца в транслит названия
     *
     * Аналогично методу rusMonth(), описанному выше
     *
     * @param $monthNum
     * @param string $case
     * @param bool $invert
     * @return string
     */
    public static function engMonth($monthNum, $case = 'i', $invert = false) {
        $rootMonth = [1 => 'janvar', 'fevral', 'mart', 'aprel', 'maj', 'ijun', 'ijul', 'avgust', 'sentjabr', 'oktjabr', 'nojabr', 'dekabr'];
        $endMonth[1] =  ['i' => '', 'r' => 'ja', 'd' => 'ju', 'v' => '', 't' => 'jem', 'p' => 'e'];
        $endMonth[2] =  ['i' => '', 'r' => 'ja', 'd' => 'ju', 'v' => '', 't' => 'jem', 'p' => 'e'];
        $endMonth[3] =  ['i' => '', 'r' => 'a',  'd' => 'u',  'v' => '', 't' => 'om',  'p' => 'e'];
        $endMonth[4] =  ['i' => '', 'r' => 'ja', 'd' => 'ju', 'v' => '', 't' => 'em',  'p' => 'e'];
        $endMonth[5] =  ['i' => '', 'r' => 'a',  'd' => 'u',  'v' => '', 't' => 'em',  'p' => 'e'];
        $endMonth[6] =  ['i' => '', 'r' => 'ja', 'd' => 'ju', 'v' => '', 't' => 'em',  'p' => 'e'];
        $endMonth[7] =  ['i' => '', 'r' => 'ja', 'd' => 'ju', 'v' => '', 't' => 'em',  'p' => 'e'];
        $endMonth[8] =  ['i' => '', 'r' => 'a',  'd' => 'u',  'v' => '', 't' => 'om',  'p' => 'e'];
        $endMonth[9] =  ['i' => '', 'r' => 'ja', 'd' => 'ju', 'v' => '', 't' => 'jem', 'p' => 'e'];
        $endMonth[10] = ['i' => '', 'r' => 'ja', 'd' => 'ju', 'v' => '', 't' => 'jem', 'p' => 'e'];
        $endMonth[11] = ['i' => '', 'r' => 'ja', 'd' => 'ju', 'v' => '', 't' => 'jem', 'p' => 'e'];
        $endMonth[12] = ['i' => '', 'r' => 'ja', 'd' => 'ju', 'v' => '', 't' => 'jem', 'p' => 'e'];

        if(!$invert) {
            // Возвращаем название месяца
            return $rootMonth[(int)$monthNum] . $endMonth[(int)$monthNum][$case];
        } else {
            // Ищем и возвращаем номер месяца
            foreach($rootMonth as $key => $root){
                if(strpos($root, $monthNum) !== false){
                    return $key;
                }
            }
        }
    }

    public static function rusZodiac($zodiac, $case = 'i', $invert = false) {
        $rootZodiac = [1 => 'Ов', 'Тел', 'Близнец', 'Рак', 'Л', 'Дев', 'Вес', 'Скорпион', 'Стрел', 'Козерог', 'Водоле', 'Рыб'];
        $endZodiac[1] =  ['i' => 'ен', 'r' => 'на',  'd' => 'ну',  'v' => 'на',  't' => 'ном',  'p' => 'не'];
        $endZodiac[2] =  ['i' => 'ец', 'r' => 'ьца', 'd' => 'ьцу', 'v' => 'ьца', 't' => 'ьцом', 'p' => 'ьце'];
        $endZodiac[3] =  ['i' => 'ы',  'r' => 'ов',  'd' => 'ам',  'v' => 'ов',  't' => 'ами',  'p' => 'ах'];
        $endZodiac[4] =  ['i' => '',   'r' => 'а',   'd' => 'у',   'v' => 'а',   't' => 'ом',   'p' => 'е'];
        $endZodiac[5] =  ['i' => 'ев', 'r' => 'ьва', 'd' => 'ьву', 'v' => 'ьва', 't' => 'ьвом', 'p' => 'ьвe'];
        $endZodiac[6] =  ['i' => 'а',  'r' => 'ы',   'd' => 'е',   'v' => 'ы',   't' => 'ой',   'p' => 'e'];
        $endZodiac[7] =  ['i' => 'ы',  'r' => 'ов',  'd' => 'ам',  'v' => 'ов',  't' => 'ами',  'p' => 'ах'];
        $endZodiac[8] =  ['i' => '',   'r' => 'а',   'd' => 'у',   'v' => 'а',   't' => 'ом',   'p' => 'е'];
        $endZodiac[9] =  ['i' => 'ец', 'r' => 'ьца', 'd' => 'ьцу', 'v' => 'ьца', 't' => 'ьцом', 'p' => 'ьце'];
        $endZodiac[10] = ['i' => '',   'r' => 'а',   'd' => 'у',   'v' => 'а',   't' => 'ом',   'p' => 'е'];
        $endZodiac[11] = ['i' => 'й',  'r' => 'я',   'd' => 'ю',   'v' => 'я',   't' => 'ем',   'p' => 'е'];
        $endZodiac[12] = ['i' => 'ы',  'r' => '',    'd' => 'ам',  'v' => '',    't' => 'ами',  'p' => 'ах'];

        if(!$invert) {
            // Возвращаем название знака Зодиака
            return $rootZodiac[(int)$zodiac] . $endZodiac[(int)$zodiac][$case];
        } else {
            // Ищем и возвращаем номер знака
            foreach($rootZodiac as $key => $root){
                $znak = $root . $endZodiac[$key][$case];
                if(strcmp($znak, $zodiac) === 0){
                    return $key;
                }
            }
        }
    }

    /**
     * Преобразование первой буквы UTF-8 строки в верхний регистр
     *
     * @param $string
     * @return string
     */
    public static function ucfirst($string){
        $string = mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
        return $string;
    }

    /**
     * Форматирование даты и времени
     *
     * @param $timestamp
     * @return string
     */
    public static function dateFormat($timestamp){
        if(!$timestamp){
            $timestamp = time();
        }
        $year = date('Y', $timestamp);
        $month = static::rusMonth(date('m', $timestamp), 'r');
        $day = date('j', $timestamp);
        $time = date('H:i', $timestamp);

        return "$day $month $year, $time";
    }

    /**
     * Возвращает символ по номеру из строки в кодировке UTF-8
     *
     * @param $str строка utf-8
     * @param $pos позиция символа
     * @return string символ
     */
    public static function utf8char($str, $pos) {
        return mb_substr($str,$pos,1,'UTF-8');
    }

}