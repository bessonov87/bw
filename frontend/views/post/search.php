<?php

/** @var \yii\data\Pagination $pages */
/** @var \common\models\ar\Post $post */
/** @var \frontend\models\form\SearchForm $searchModel */

use yii\helpers\Html;
use app\components\widgets\SearchWidget;
use common\components\helpers\GlobalHelper;

$this->title = 'Поиск по сайту';
// Если задана поисковая фраза
if($searchPhrase = Html::encode($searchModel->story)){
    $this->title .= ': ' . $searchPhrase;
}
?>


<?php
// Выводим поисковую форму
echo SearchWidget::widget(['full' => true]);

// Если задана поисковая фраза, но нет статей, выводим блок "По вашему запросу ничего не найдено".
if($searchPhrase && !$posts):
    $posts = [];
    Yii::$app->session->setFlash('error', 'К сожалению, по вашему запросу ничего не найдено. Попробуйте уменьшить запрос или изменить его, задав более общее понятие.');
endif;

if($posts) {
    $searchPattern = '';
    // избавляемся от любых символов, кроме букв и пробелов
    $searchPhrase = mb_ereg_replace("[^a-zA-ZА-Яа-я\s]", "", $searchPhrase);
    $searchPhrase = mb_ereg_replace("[\s]+", " ", $searchPhrase);
    $searchPhrase = trim($searchPhrase);
    //var_dump($searchPhrase);
    // делим поисковую фразу на слова
    $searchWords = explode(' ', $searchPhrase);
    // проходим по словам и для каждого слова создаем набор совпадений от полной длины слова до его первых 4-х символов
    foreach ($searchWords as $searchW) {
        $baseWord = $searchW;
        $searchPattern[$baseWord] = '';
        if (mb_strlen($searchW) < 4) {
            $searchPattern[$baseWord] = $searchW;
        } else {
            while (mb_strlen($searchW) >= 4) {
                $searchPattern[$baseWord] .= $searchW . '|';
                $searchW = mb_substr($searchW, 0, -1);
            }
            $searchPattern[$baseWord] = mb_substr($searchPattern[$baseWord], 0, -1);
        }
        $patterns[] = "/((?:^|>)[^<]*)(" . $searchPattern[$baseWord] . ")/siu"; //регулярное выражение
    }
}
// Проходим по всем найденным статьям
foreach($posts as $post):
    $tCount = 0;
    $sCount = 0;
    $full = '';
    $replace = '$1<strong style="color:#525252;font-size: 1.1em;">$2</strong>'; // шаблон замены строки
    $title = preg_replace($patterns, $replace, $post->title, -1, $tCount); // замена
    $short = preg_replace($patterns, $replace, $post->short, -1, $sCount); // замена
    // если количество замен в title и short равняется нулю, ищем вхождение слов фразы в полном тексте статьи
    // и выводим часть текста с подсвеченным первым словом фразы
    if(!$tCount && !$sCount){
        // убираем теги
        $fullText = strip_tags($post->full);
        // вычисляем позиции первого вхождения для всех слов фразы
        foreach($searchWords as $searchWord){
            $pos[$searchWord] = mb_stripos($fullText, $searchWord);
        }
        // берем позицию вхождения первого слова из поисковой разы
        $start = $pos[$searchWords[0]];
        // проходимся циклом по символам строки с полным текстом статьи, начиная от позиции вхождения слова
        // из поисковой фразы. Проход производим в обратном порядке. Останавливаемся, когда найдем точку.
        // Начиная с этой позиции и возьмем подстроку с выдержкой для вывода подсвеченного слова из поисковой фразы.
        $symbol = '';
        $i = 1;
        while($symbol != '.'){
            $position = $start-$i;
            $symbol = GlobalHelper::utf8char($fullText, $position);
            $i++;
        }
        $full = mb_substr($fullText, $position+1, 200);
        // подсвечиваем слова из поисковой фразы
        $full = preg_replace($patterns, $replace, $full);
        // формируем блок для вывода
        $full = '<div style="border-radius: 5px; border: 1px #eee solid; padding: 10px; margin: 7px; background-color: #f5f5f5;"><strong style="display: block;">Выдержка из полного текста статьи:</strong>'.$full.' ...</div>';
    }
?>
    <div id="content-item">
        <div id="content-item-top" class="content-item-pink"><a href="<?= $post->link ?>"><?= $title ?></a></div>
        <div id="content-item-content">
            <div id="content-small-10">
                <div class="search-short"><?= $short ?></div>
                <?= $full ?>
            </div>
            <div class="clear"></div>
            <div id="content-item-footer">
                <div class="content-item-footer-left"><strong>Добавлено:</strong> <?= $post->date ?> | <strong>Просмотров:</strong> <?=$post->views?></div>
                <div class="content-item-footer-right"><a href="<?= $post->link ?>">Подробнее >></a></div>
            </div>
        </div>
    </div>
<?php
endforeach;