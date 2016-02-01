<?php
namespace app\components;


class AppData
{
    public static $moonHairLinksBase = "/horoscope/lunnyj-kalendar-strizhek/";

    public static $moonHairMonthLinks = [
        '2015' => [
            1 => "2095-lunnyj-kalendar-strizhek-na-yanvar-2015-goda.html",
            "2096-lunnyj-kalendar-strizhek-na-fevral-2015-goda.html",
            "2097-lunnyj-kalendar-strizhek-na-mart-2015-goda.html",
            "2098-lunnyj-kalendar-strizhek-na-aprel-2015-goda.html",
            "2099-lunnyj-kalendar-strizhek-na-maj-2015-goda.html",
            "2100-lunnyj-kalendar-strizhek-na-iyun-2015-goda.html",
            "2101-lunnyj-kalendar-strizhek-na-iyul-2015-goda.html",
            "2102-lunnyj-kalendar-strizhek-na-avgust-2015-goda.html",
            "2103-lunnyj-kalendar-strizhek-na-sentyabr-2015-goda.html",
            "2104-lunnyj-kalendar-strizhek-na-oktyabr-2015-goda.html",
            "2105-lunnyj-kalendar-strizhek-na-noyabr-2015-goda.html",
            "1846-lunnyj-kalendar-strizhek-na-dekabr-2014-goda.html"
        ],
        '2016' => [
            1 => "2409-lunnyj-kalendar-strizhek-na-yanvar-2016-goda.html",
            "2410-lunnyj-kalendar-strizhek-na-fevral-2016-goda.html",
            "2414-lunnyj-kalendar-strizhek-na-mart-2016-goda.html",
            "2416-lunnyj-kalendar-strizhek-na-aprel-2016-goda.html",
            "2417-lunnyj-kalendar-strizhek-na-maj-2016-goda.html",
            "2420-lunnyj-kalendar-strizhek-na-iyun-2016-goda.html",
            "2421-lunnyj-kalendar-strizhek-na-iyul-2016-goda.html",
            "2422-lunnyj-kalendar-strizhek-na-avgust-2016-goda.html",
            "2425-lunnyj-kalendar-strizhek-na-sentyabr-2016-goda.html",
            "2426-lunnyj-kalendar-strizhek-na-oktyabr-2016-goda.html",
            "2427-lunnyj-kalendar-strizhek-na-noyabr-2016-goda.html",
            "2428-lunnyj-kalendar-strizhek-na-dekabr-2016-goda.html"
        ],
    ];

    public static $moonCalLinksBase = "/horoscope/lunnyj-kalendar-na-god/";

    public static $moonCalMonthLinks = [
        '2016' => [
            1 => '2434-lunnyj_kalendar_na_janvar_2016_goda.html',
            '2435-lunnyj_kalendar_na_fevral_2016_goda.html',
            '2436-lunnyj_kalendar_na_mart_2016_goda.html',
            '2497-lunnyj-kalendar-na-aprel-2016-goda.html',
            '2498-lunnyj-kalendar-na-maj-2016-goda.html',
            '2499-lunnyj-kalendar-na-ijun-2016-goda.html',
            '2500-lunnyj-kalendar-na-ijul-2016-goda.html',
            '2501-lunnyj-kalendar-na-avgust-2016-goda.html',
            '2502-lunnyj-kalendar-na-sentjabr-2016-goda.html',
            '2503-lunnyj-kalendar-na-oktjabr-2016-goda.html',
            '2504-lunnyj-kalendar-na-nojabr-2016-goda.html',
            '2505-lunnyj-kalendar-na-dekabr-2016-goda.html',
        ],
    ];

    /**
     * Ссылки на лунные календари стрижек
     *
     * В зависимости от переданного года ($year) формируется и передается массив с полными ссылками на лунные календари
     * стрижек по месяцам.
     *
     * Если вторым параметром передать номер месяца, метод возвращает ссылку на этот месяц
     *
     * @param $year
     * @param null $month
     * @return array|string Массив со сслыками на весь год или строка со ссылкой на месяц
     */
    public static function getMoonHairLinks($year, $month = null) {
        if(!array_key_exists($year, self::$moonHairMonthLinks)){
            return null;
        }
        $mappedArray = array_map(
            function($val){
                return self::$moonHairLinksBase . $val;
            },
            self::$moonHairMonthLinks[$year]
        );

        // Если указан месяц, возвращаем ссылку на данный месяц
        if($month) {
            if(!array_key_exists($month, $mappedArray)){
                return null;
            }
            if($month < 1 || $month > 12)
                return null;
            return $mappedArray[$month];
        }

        return $mappedArray;
    }

    /**
     * Ссылки на общие лунные календари по месяцам
     *
     * В зависимости от переданного года ($year) формируется и передается массив с полными ссылками на общие лунные
     * календари по месяцам.
     *
     * Если вторым параметром передать номер месяца, метод возвращает ссылку на этот месяц
     *
     * @param $year
     * @param null $month
     * @return array|string Массив со сслыками на весь год или строка со ссылкой на месяц
     */
    public static function getMoonCalLinks($year, $month = null) {
        if(!array_key_exists($year, self::$moonCalMonthLinks)){
            return null;
        }
        $mappedArray = array_map(
            function($val){
                return self::$moonCalLinksBase . $val;
            },
            self::$moonCalMonthLinks[$year]
        );

        // Если указан месяц, возвращаем ссылку на данный месяц
        if($month) {
            if(!array_key_exists($month, $mappedArray)){
                return null;
            }
            if($month < 1 || $month > 12)
                return null;
            return $mappedArray[$month];
        }

        return $mappedArray;
    }
}