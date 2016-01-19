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

    public static function getMoonHairLinks($year) {
        return array_map(
            function($val){
                return self::$moonHairLinksBase . $val;
            },
            self::$moonHairMonthLinks[$year]
        );
    }
}