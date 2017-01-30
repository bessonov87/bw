<?php
namespace common\components\helpers;

use common\models\ar\Advert;
use common\models\ar\Countries;
use backend\models\Log;
use common\models\ar\Comment;
use common\models\ar\Post;
use common\models\ar\User;
use Yii;
use common\models\ar\Category;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * GlobalHelper содержит дополнительные часто применяемые функции
 *
 * @author Sergey Bessonov <bessonov87@gmail.com>
 * @version 1.0
 */
class GlobalHelper
{
    /**
     * Возвращает укороченную версию текста.
     * Примерно первые $symbols символов. В конце троеточие ...
     * @param $text
     * @param int $symbols
     * @return string
     */
    public static function getShortText($text, $symbols = 100)
    {
        $text = strip_tags($text);
        $words = explode(' ', $text);
        $substr = '';
        foreach ($words as $word){
            if(mb_strlen($substr) >= $symbols){
                break;
            }
            $substr .= $word.' ';
        }

        return $substr.'...';
    }
    /**
     * Преобразует тэги <br> в перевод строки и возврат каретки
     *
     * @param $string string Строка для конвертирования
     * @return string Конвертированная строка
     */
    public static function br2nl ( $string )
    {
        return preg_replace('/\<br(\s*)?\/?\>/i', PHP_EOL, $string);
    }

    /**
     * Возвращает путь к аватару пользователя
     *
     * Используется при выводе комментариев. Информация о пользователь передается в виде массива. В случае, если
     * "пользователь" представляет собой объект класса \common\models\ar\User следует использовать его метод getAvatar()
     *
     * @param $user
     * @return string
     */
    public static function avatarSrc($user){
        $avatar = $user['profile']['avatar'];
        $avatarPath = '/uploads/fotos/';
        if(!$avatar) {
            $avatar = ($user['profile']['sex'] == 'm') ? 'noavatar_male.png' : 'noavatar_female.png';
        }
        return $avatarPath.$avatar;
    }

    /**
     * Возвращает список всех категорий статей
     *
     * Обращение к БД происходит только при первом вызове метода. Результат записывается в params.
     * При последующих вызовах метода, результат берется из свойства params.
     *
     * @return array Список категорий в виде массива, индексированного по id категории
     */
    public static function getCategories(){
        if(!isset(Yii::$app->params['categories']) || empty(Yii::$app->params['categories'])){
            // Получаем из базы все категории и переиндексируем по ID
            Yii::$app->params['categories'] = ArrayHelper::index(Category::find()->asArray()->all(), 'id');
        }
        return Yii::$app->params['categories'];
    }

    /**
     * Возвращает список категорий в формате ['id' => 'name']
     *
     * Применяется в админке в фильтре по категориям статей
     *
     * @return array
     */
    public static function getCategoriesFilter(){
        $categoriesFilter = [];
        $mainCats = [];
        $categories = self::getCategories();
        if(!$categories) return ['0' => 'Нет категорий'];
        foreach($categories as $cat){
            if($cat['parent_id'] == 0){
                $mainCats[$cat['id']] = $cat['name'];
            }
            //$categoriesFilter[$cat['id']] = $cat['name'];
        }
        foreach($mainCats as $id => $name){
            $categoriesFilter[$id] = $name;
            foreach($categories as $cat){
                if($cat['parent_id'] == $id){
                    $categoriesFilter[$cat['id']] = '---'.$cat['name'];
                }
            }
        }
        return $categoriesFilter;
    }

    /**
     * Определяем Url категории по ее ID
     *
     * Url определяется с учетом наличия основной категории, если передан ID подкатегории
     *
     * @param $id int ID категории
     * @return string Относительный URL категории (в виде category или category/subcategory)
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
        if(!isset($categories[$cat]) || is_null($categories[$cat])){
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

    /**
     * Возвращает список из дней в виде массива ('число' => 'число')
     *
     * Нулевой элемент массива - пустая строка
     *
     * @param $days int Количество дней (по умолчанию 31)
     * @return array
     */
    public static function getDaysList($days = 31){
        $array = range(1, $days);
        array_unshift($array, '');
        return $array;
    }

    /**
     * Возвращает список месяцев в виде массива
     *
     * Нулевой элемент массива - пустая строка
     *
     * @return array
     */
    public static function getMonthsList(){
        $array[0] = '';
        for($i=1;$i<=12;$i++){
            $array[sprintf('%02d', $i)] = self::ucfirst(self::rusMonth($i));
        }
        return $array;
    }

    /**
     * Возвращает список годов в виде массива ('год' => 'год')
     *
     * Нулевой элемент массива - пустая строка
     *
     * @param int $from С какого года начать
     * @param int $to Каким годом закончить
     * @return array
     */
    public static function getYearsList($from = 1945, $to = 2015){
        $array[0] = '';
        for($i=$from;$i<=$to;$i++){
            $array[$i] = $i;
        }
        return $array;
    }

    /**
     * Возвращает список знаков Зодиака в виде массива (1 => 'Овен', ...)
     * @return mixed
     */
    public static function getZodiakList()
    {
        $array[0] = 'Выбрать ...';
        for($i=1;$i<=12;$i++){
            $array[$i] = self::rusZodiac($i);
        }
        return $array;
    }

    /**
     * Преобразование номера знака Зодиака в название
     *
     * Аналогично методу rusMonth(), описанному выше
     *
     * @param $zodiac int|string Номер знака или название (если invert = true)
     * @param string $case Падеж
     * @param bool|false $invert Инвертировать поиск (искать номер знака Зодиака по названию)
     * @return int|string
     */
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

    public static function engZodiak($zodiac, $invert = false)
    {
        $znaki = [1 => 'oven', 2 => 'telec', 3 => 'bliznecy', 4 => 'rak', 5 => 'lev', 6 => 'deva', 7 => 'vesy', 8 => 'skorpion', 9 => 'strelec', 10 => 'kozerog', 11 => 'vodoley', 12 => 'ryby'];

        if(!$invert && !isset($znaki[$zodiac])){
            return null;
        }

        return !$invert ? $znaki[$zodiac] : array_search($zodiac, $znaki);
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
            return '-';
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

    public static function translit($str){
        $transliterator = \Transliterator::create('Cyrillic-Latin');
        return $transliterator->transliterate($str);
    }

    /**
     * Приведение имени файла
     *
     * Удаляет из имени файла нежелательные символы, пробелы заменяет на подчеркивание, русские буквы - на транслит
     *
     * @param string $fileName Имя загружаемого пользователем файла
     * @return string Имя файла
     */
    public static function normalizeName($fileName, $timestamp = false){
        $normalized = self::translit($fileName);  // Транслитерация
        $normalized = trim($normalized);				// Убираем пробелы в начале и конце
        $normalized = mb_strtolower($normalized);	// Переводим полученную строку в нижний регистр
        $normalized = mb_ereg_replace("\s+", "-", $normalized);	// Пробелы заменяем на _
        $normalized = mb_ereg_replace("[^\.a-z0-9_-]+", "", $normalized);	// Избавляемся от "лишних символов", если они остались
        $normalized = mb_ereg_replace('[\-]+', '-', $normalized);		// Несколько подряд идущих знаков "-" превращаем в один

        if($timestamp){
            $normalized = time() . '_' . $normalized;
        }

        return $normalized;
    }

    /**
     * Возвращает список стран в формате массива
     *
     * Ключ массива и значение одинаковы - название страны на русском языке
     *
     * @return mixed
     */
    public static function getCountriesList(){
        $countries = Countries::find()
            ->select('title_ru')
            ->orderBy('title_ru')
            ->asArray()
            ->all();

        $countriesList[null] = '';

        foreach($countries as $c){
            $country = $c['title_ru'];
            $countriesList[$country] = $country;
        }

        return $countriesList;
    }

    /**
     * Возвращает username из email
     * @param $email
     * @return string
     */
    public static function usernameFromEmail($email){
        $atPos = mb_strpos($email, '@');
        $username = mb_substr($email, 0, $atPos);
        $username = mb_ereg_replace("[^A-Za-z0-9_-]+", "", $username);	// Избавляемся от "лишних символов"
        return $username;
    }

    public static function getMetrikaData($params){
        $metrikaBaseUrl = "http://api-metrika.yandex.ru/stat/v1/data?";
        foreach($params as $key => $value){
            $getData[] = $key.'='.$value;
        }
        $getData[] = 'id='.Yii::$app->params['YandexCounterID'];
        $getData[] = 'oauth_token='.Yii::$app->params['YandexToken'];
        $getParams = implode('&', $getData);
        $metrikaUrl = $metrikaBaseUrl.$getParams;
        //stat/traffic/summary.json?id=".Yii::$app->params['YandexCounterID']."&pretty=1&date1=$start&date2=$end&oauth_token=".Yii::$app->params['YandexToken'];
        var_dump($metrikaUrl);

        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL,$metrikaUrl);
        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $metrikaData = curl_exec ($ch);
        curl_close($ch);

        return json_decode($metrikaData);
    }

    public static function getSiteSummary() {
        $today_begin = strtotime(date("Y-m-d")." 00:00:00");
        $today_end = strtotime("+1 day", $today_begin);
        $yesterday_begin = $today_begin - 86400;
        $yesterday_end = $today_end - 86400;
        // Статьи
        $summary['postsCount'] = Post::find()->count();
        $summary['postsToday'] = Post::find()->where(['between', 'date', $today_begin, $today_end])->count();
        $summary['postsYesterday'] = Post::find()->where(['between', 'date', $yesterday_begin, $yesterday_end])->count();
        // Пользователи
        $summary['usersCount'] = User::find()->count();
        $summary['usersToday'] = User::find()->where(['between', 'created_at', $today_begin, $today_end])->count();
        $summary['usersYesterday'] = User::find()->where(['between', 'created_at', $yesterday_begin, $yesterday_end])->count();
        // Комментарии
        $summary['commentsCount'] = Comment::find()->count();
        $summary['commentsToday'] = Comment::find()->where(['between', 'date', $today_begin, $today_end])->count();
        $summary['commentsYesterday'] = Comment::find()->where(['between', 'date', $yesterday_begin, $yesterday_end])->count();
        // Ошибки
        $summary['errorsCount'] = Log::find()->count();
        $summary['errorsToday'] = Log::find()->where(['between', 'log_time', $today_begin, $today_end])->count();
        $summary['errorsYesterday'] = Log::find()->where(['between', 'log_time', $yesterday_begin, $yesterday_end])->count();

        return $summary;
    }

    public static function getRelatedCalendars($year, $month, $hair = false)
    {
        $similar = [];
        $currentMonth = date('m');
        $currentYear = date('Y');
        $nextMonth = $currentMonth < 12 ? $currentMonth + 1 : 1;
        $nextYear = $currentMonth < 12 ? $currentYear : $currentYear + 1;

        if($year == $currentYear && $month == $currentMonth) {
            if($hair){
                $similar[] = [
                    'url' => Url::to(['horoscope/moon-month-calendar', 'year' => $currentYear, 'month' => GlobalHelper::engMonth($currentMonth, 'i')]),
                    'title' => 'Лунный календарь на ' . GlobalHelper::rusMonth($currentMonth) . ' ' . $currentYear . ' года'
                ];
            } else {
                $similar[] = [
                    'url' => Url::to(['horoscope/hair-month-calendar', 'year' => $currentYear, 'month' => GlobalHelper::engMonth($currentMonth, 'i')]),
                    'title' => 'Лунный календарь стрижек на ' . GlobalHelper::rusMonth($currentMonth) . ' ' . $currentYear . ' года',
                ];
            }
        } else {
            // Current Month
            $similar[] = [
                'url' => Url::to(['horoscope/moon-month-calendar', 'year' => $currentYear, 'month' => GlobalHelper::engMonth($currentMonth, 'i')]),
                'title' => 'Лунный календарь на ' . GlobalHelper::rusMonth($currentMonth) . ' ' . $currentYear . ' года'
            ];
            $similar[] = [
                'url' => Url::to(['horoscope/hair-month-calendar', 'year' => $currentYear, 'month' => GlobalHelper::engMonth($currentMonth, 'i')]),
                'title' => 'Лунный календарь стрижек на ' . GlobalHelper::rusMonth($currentMonth) . ' ' . $currentYear . ' года',
            ];
        }
        // Next Month
        $similar[] = [
            'url' => Url::to(['horoscope/moon-month-calendar', 'year' => $nextYear, 'month' => GlobalHelper::engMonth($nextMonth, 'i')]),
            'title' => 'Лунный календарь на '.GlobalHelper::rusMonth($nextMonth).' '.$nextYear.' года',
        ];
        $similar[] = [
            'url' => Url::to(['horoscope/hair-month-calendar', 'year' => $nextYear, 'month' => GlobalHelper::engMonth($nextMonth, 'i')]),
            'title' => 'Лунный календарь стрижек на '.GlobalHelper::rusMonth($nextMonth).' '.$nextYear.' года',
        ];

        return $similar;
    }

    /**
     * Возвращает дату понедельника заданной недели заданного года
     * @param $week
     * @param string $year
     * @return int
     */
    public static function getMonday($week, $year=""){
        $year = $year ?: date('Y');
        $dto = new \DateTime();
        return $dto->setISODate((int)$year, (int)$week)->getTimestamp();
    }

    /**
     * Аналог self::getMonday(), но возвращает дату воскресенья
     * @param $week
     * @param string $year
     * @return mixed
     */
    public static function getSunday($week, $year=""){
        return static::getMonday($week, $year) + 6 * 86400;
    }

    /**
     * Вставка рекламных материалов в текст статьи
     *
     * Рекламные материалы задаются в базе данных в таблице 'advert'. Они могут иметь 3 варианта расположения:
     * bottom (под текстом статьи), top (над текстом статьи) и inside (в середине текста статьи), а также выводиться
     * в любом месте статьи при помощи тэга подстановки, указываемого в виде произвольной строки (напр. [yandex]) или
     * конструкцией вида [advert-<block_number>] (где block_number - номер рекламного блока), если не указан строковый
     * тэг подстановки.
     *
     * @param $text
     * @return mixed
     */
    public static function insertAdvert($text) {
        $adverts = Advert::find()
            ->where(['approve' => 1])
            ->asArray()
            ->all();

        if(is_null($adverts))
            return $text;

        foreach($adverts as $advert) {
            if(!$advert['replacement_tag']) {
                $advert['replacement_tag'] = 'none';
            }
            if($advert['location'] != 'various'){
                if($advert['replacement_tag'] != 'none' && strstr($text, "[{$advert['replacement_tag']}]"))
                {
                    $text = str_replace("[{$advert['replacement_tag']}]", $advert['code'], $text);
                }
                else if($advert['replacement_tag'] == "none" && strstr($text, "[advert-{$advert['block_number']}]"))
                {
                    $text = str_replace("[advert-{$advert['block_number']}]", $advert['code'], $text);
                }
            }
        }

        return $text;
    }

}