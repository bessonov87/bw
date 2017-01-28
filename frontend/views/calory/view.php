<?php
/**
 * @var \yii\web\View $this
 * @var \common\models\ProductsCategory $category
 * @var \common\models\Product $product
 * @var \common\models\NormsFatProt $norms
 * @var array $norms_vit_min
 * @var array $vitamins
 * @var array $microelements
 * @var array $macroelements
 * @var array $caloriesArray
 * @var array $percents
 * @var array $caloriesPercents
 */

//var_dump($vitamins); die;

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\assets\ChartJsAsset;
use yii\helpers\ArrayHelper;

$this->params['breadcrumbs'][] = ['label' => Html::a('Таблица калорийности', '/tablica-kalorijnosti/'), 'encode' => false];
$this->params['breadcrumbs'][] = ['label' => Html::a($category->name, ['calory/category', 'category' => $category->url]), 'encode' => false];

$this->title = "{$product->name}. Химический состав, польза и вред, описание и полезные свойства";
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => "{$product->name}, калорийность, таблица калорийности, {$category->name}, продукты, питание, калорийность продуктов"
]);

$this->registerMetaTag([
    'name' => 'description',
    'content' => "{$this->title}. Считаем калории для здорового питания"
]);

$options = [
    'title' => $this->title,
    'ratingFav' => ['page' => md5($_SERVER['REQUEST_URI'])],
    'footer' => false,
    'comments' => false,
    'id' => md5($_SERVER['REQUEST_URI'])
];

ChartJsAsset::register($this);

//var_dump(array_values($caloriesArray)); die;

$data = implode(', ', array_values($caloriesArray));

//var_dump($data); die;

$microData = implode(', ', ArrayHelper::getColumn($microelements, 'flot_procent'));
$microBorderColors = implode(', ', array_map(function ($val){return '"'.$val.'"';}, ArrayHelper::getColumn($microelements, 'flot_color')));
$microColors = implode(', ', array_map(function ($val){return '"'.$val.'"';}, ArrayHelper::getColumn($microelements, 'color')));
$microLabels = implode(', ', array_map(function ($val){return '"'.$val.'"';}, ArrayHelper::getColumn($microelements, 'name')));

$macroData = implode(', ', ArrayHelper::getColumn($macroelements, 'flot_procent'));
$macroBorderColors = implode(', ', array_map(function ($val){return '"'.$val.'"';}, ArrayHelper::getColumn($macroelements, 'flot_color')));
$macroColors = implode(', ', array_map(function ($val){return '"'.$val.'"';}, ArrayHelper::getColumn($macroelements, 'color')));
$macroLabels = implode(', ', array_map(function ($val){return '"'.$val.'"';}, ArrayHelper::getColumn($macroelements, 'name')));

$js = <<<JS
$(function() {
    
    var ctx = $("#diagramChart");
    
    var data = {
    labels: [
        "Белки",
        "Жиры",
        "Углеводы"
    ],
    datasets: [
        {
            data: [$data],
            backgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ],
            hoverBackgroundColor: [
                "#FF6384",
                "#36A2EB",
                "#FFCE56"
            ]
        }]
    };
    
    // a doughnut chart
    var diagramChart = new Chart(ctx, {
        type: 'doughnut',
        data: data
        //options: options
    });
    
    var microData = {
        labels: [$microLabels],
        datasets: [
            {
                label: false,
                backgroundColor: [$microColors],
                borderColor: [$microBorderColors],
                borderWidth: 1,
                data: [$microData],
            }
        ]
    };
    
    var microChart = new Chart($("#microChart"), {
        type: 'horizontalBar',
        data: microData,
        options: {
            legend: {
                display: false
            }
        }
    });
    
    var macroData = {
        labels: [$macroLabels],
        datasets: [
            {
                label: false,
                backgroundColor: [$macroColors],
                borderColor: [$macroBorderColors],
                borderWidth: 1,
                data: [$macroData],
            }
        ]
    };
    
    var macroChart = new Chart($("#macroChart"), {
        type: 'bar',
        data: macroData,
        options: {
            legend: {
                display: false
            }
        }
    });
    
});
JS;

$this->registerJs($js, \yii\web\View::POS_END);

$caloriesList = [
    ['name' => 'Белки', 'value' => $caloriesArray['protein'], 'percent' => $caloriesPercents['protein']],
    ['name' => 'Жиры', 'value' => $caloriesArray['fat'], 'percent' => $caloriesPercents['fat']],
    ['name' => 'Углеводы', 'value' => $caloriesArray['carbohydrates'], 'percent' => $caloriesPercents['carbohydrates']],
    ['name' => 'Спирт', 'value' => $caloriesArray['alco'], 'percent' => null],
];

$nutriList = [
    ['name' => 'Вода', 'key' => 'water', 'sub' => false],
    ['name' => 'Белки', 'key' => 'protein', 'sub' => false],
    ['name' => 'Жиры', 'key' => 'fat', 'sub' => false],
    ['name' => 'НЖК', 'key' => 'unsaturated_fatty_acids', 'sub' => true],
    ['name' => 'ПНЖК', 'key' => 'saturated_fatty_acids', 'sub' => true],
    ['name' => 'Углеводы', 'key' => 'carbohydrates', 'sub' => false],
    ['name' => 'Пищевые волокна', 'key' => 'fiber', 'sub' => true],
    ['name' => 'Моно- и дисахариды', 'key' => 'saccharides', 'sub' => true],
    ['name' => 'Крахмал', 'key' => 'starch', 'sub' => true],
    ['name' => 'Органические кислоты', 'key' => 'organic_acids', 'sub' => false],
    ['name' => 'Холестерин', 'key' => 'cholesterol', 'sub' => false],
    ['name' => 'Зола', 'key' => 'ash', 'sub' => false],
    ['name' => 'Спирт', 'key' => 'alco', 'sub' => false],
];

$nutrition_facts = '<div class="nutrition_facts">
    <h2 class="nutrition_title">Пищевая ценность</h2>
    <div class="serving">
        <strong>Размер порции</strong><br>
        <div class="serving_value"><select name="sv" class="svtext">
        <option value="1" selected="">100 г</option>
        <option value="2">1 ст. л.</option>
        <option value="3">1 ч. л.</option>
        </select></div>
        <div class="serving_button"><input type="button" class="svtext" value="Пересчитать"></div>
    </div>
    <hr noshade="" style="height: 10px; background-color: #333333; margin: 7px 0;">
    <div>Количество на порцию</div>
    <hr noshade="" style="height: 1px; background-color: #333333; margin: 7px 0;">
    <div class="energy">Калорийность<sup>1</sup>: '.$product->calories.' ккал</div>
    <hr noshade="" style="height: 4px; background-color: #333333; margin: 7px 0;">
    <div align="right"><span class="hint--top" data-hint="Процент суточной нормы">% СН*</span></div>';

foreach ($nutriList as $nutrition){
    $value = isset($nutri[$nutrition['key']]) ? $nutri[$nutrition['key']].' г' : '-';
    $percent = isset($percents[$nutrition['key']]) ? $percents[$nutrition['key']].'%' : '-';
    $class = $nutrition['sub'] ? 'sub_nutri_value' : 'nutri_value';
    $facts_class = $nutrition['sub'] ? 'facts_sub_nutri_name' : 'facts_nutri_name';
    $nutrition_facts .= '<div class="'.$class.'">
        <div class="'.$facts_class.'">'.$nutrition['name'].'</div>
        <div class="facts_value">'.$value.'</div>
        <div class="nutri_procent">'.$percent.'</div>
        <div class="clear"></div>
    </div>';
}
$nutrition_facts .= '<hr noshade="" style="height: 4px; background-color: #333333; margin: 9px 0;">
    <div class="annotation">* %СН - Процент суточной нормы. Данный показатель определяется на основании норм для 
    организма среднестатистической молодой женщины 1-й группы активности в возрасте от 18 до 29 лет. Суточные 
    потребности вашего организма могут существенно отличаться. Подробнее читайте <a href="#">здесь</a>.</div>
</div>';

$microBox = '<div class="mikro">
    <h2 class="nutrition_title">Микроэлементы</h2>
    <div class="micro-canvas">
        <canvas id="microChart" width="220" height="220"></canvas>
    </div>
    <div align="right"><span data-hint="Процент суточной нормы">% СН*</span></div>';
foreach ($microelements as $key => $microelement) {
    $norma = $norms_vit_min[$key]->value.' '.$microelement['unit'];
    $value = $microelement['value'].' '.$microelement['unit'];
    $microBox .= '<div class="nutri_value">
        <div class="micro_name"><span data-hint="Норма: '.$norma.'">'.$microelement['name'].'</span></div>
        <div class="micro_value" style="background-color:'.$microelement['color'].';">'.$value.'</div>
        <div class="nutri_procent">'.$microelement['procent'].'</div>
        <div class="clear"></div>
    </div>';
}
$microBox .= '</div>';

$diagramBox = '<div class="diagramm-box">
    <div class="diagramm"><h2>Диаграмма калорийности</h2></div>
    <div class="diagram-canvas">
        <canvas id="diagramChart" width="400" height="250"></canvas>
    </div>
    <div align="right"><span class="hint--top" data-hint="Процент суточной нормы">% СН*</span></div>
    <div class="diagram_nutri">
        <div class="diagram_name"><strong>Энергетическая ценность</strong></div>
        <div class="diagram_value"><strong>'.$product->calories.' ккал</strong></div>
        <div class="diagram_procent"><strong>'.$percents['calories'].'%</strong></div>
        <div class="clear"></div>
    </div>';
foreach ($caloriesList as $calor){
    $diagram_sub_value = $calor['value'] ? $calor['value'].' ккал' : '-';
    $diagram_sub_procent = $calor['percent'] ? $calor['percent'].'%' : '-';
    $diagramBox .= '<div class="diagram_sub_nutri">
                        <div class="diagram_sub_name">'.$calor['name'].'</div>
                        <div class="diagram_sub_value">'.$diagram_sub_value.'</div>
                        <div class="diagram_sub_procent">'.$diagram_sub_procent.'</div>
                        <div class="clear"></div>
                    </div>';
}

$diagramBox .= '</div>';

$vitaminBox = '<div class="makro">
    <h2 class="nutrition_title">Витамины</h2>
    <div align="right"><span>% СН*</span></div>';
foreach ($vitamins as $key => $vitamin){
    $norma = $norms_vit_min[$key]->value.' '.$vitamin['unit'];
    $value = $vitamin['value'].' '.$vitamin['unit'];
    $vitaminBox .= '<div class="nutri_value">
        <div class="vita_name"><span data-hint="Норма: '.$norma.'">'.$vitamin['name'].'</span></div>
        <div class="vita_value">'.$value.'</div>
        <div class="vita_procent">'.$vitamin['procent'].'</div>
        <div class="clear"></div>
    </div>';
}
$vitaminBox .= '</div>';

$macroBox = '<div class="makro">
    <h2 class="nutrition_title">Макроэлементы</h2>
    <div class="macro-canvas">
        <canvas id="macroChart" width="400" height="250"></canvas>
    </div>
    <div align="right"><span data-hint="Процент суточной нормы">% СН*</span></div>';
foreach ($macroelements as $macroelement) {
    $norma = $norms_vit_min[$key]->value.' '.$macroelement['unit'];
    $value = $macroelement['value'].' '.$macroelement['unit'];
    $macroBox .= '<div class="nutri_value">
        <div class="makro_name"><span data-hint="Норма: '.$norma.'">'.$macroelement['name'].'</span></div>
        <div class="makro_value" style="background-color:'.$macroelement['color'].';">'.$value.'</div>
        <div class="makro_procent">'.$macroelement['procent'].'</div>
        <div class="clear"></div>
    </div>';
}
$macroBox .= '</div>';


$options['content'] = '';

$options['content'] .= '
<div class="product-nutritions">
    <div align="justify" class="product_short_text">
        <div class="row product-info">
            <div class="product-info-image"><img src="/uploads/icons/thumbs/'.$product->icon.'" width="150"></div>
            <div class="product-info-cal">
                <div><strong>Калорийность:</strong> '.$product->calories.' ккал</div>
                <div><strong>Белки:</strong> '.round($product->protein/1000, 3).' г</div>
                <div><strong>Жиры:</strong> '.round($product->fat/1000, 3).' г</div>
                <div><strong>Углеводы:</strong> '.round($product->carbohydrates/1000, 3).' г</div>
            </div>
        </div>
        <p>&nbsp;</p>'.$auto_product_description.'<p>&nbsp;</p>
        <p>По диаграмме калорийности вы можете оценить вклад жиров, белков и углеводов в калорийность продукта в процентном 
        соотношении. 1 г жиров дает 9 килокалорий, 1 г белков и 1 г углеводов - по 4 килокалории каждый. Для некоторых диет 
        данные показатели очень важны. Да и в целом важно знать, сколько белков, жиров и углеводов мы потребляем в пищу. 
        </p><br>
    </div>
    <br>
				
    <div class="row nutrition">
        <div class="col-md-4">
			'.$nutrition_facts.$microBox.'
        </div>
        <div class="col-md-8">
            '.$diagramBox.$vitaminBox.$macroBox.'
        </div>
	</div>
		
    <div class="nutri-info">
        <sup>1</sup> - <strong>Энергетическая ценность</strong> (или, по-другому, Калорийность) является одной из наиболее 
        важных характеристик продукта. Она показывает сколько энергии получит наш от данного продукта в процессе 
        пищеварения.
    </div>
</div>';

$options['content'] .= '<p>&nbsp;</p>';

// ПОХОЖИЕ ПО КАЛОРИЙНОСТИ
$options['content'] .= '';

// ТАКЖЕ В РАЗДЕЛЕ
$options['content'] .= '';

// Text
$options['content'] .= '';

echo $this->render('@frontend/views/post/post-layout', ['options' => $options]);