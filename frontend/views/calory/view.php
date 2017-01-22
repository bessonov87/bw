<?php
/**
 * @var \yii\web\View $this
 * @var \common\models\ProductsCategory $category
 * @var \common\models\Product $product
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

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

$options['content'] = '';

$options['content'] .= $product->icon.'
<div class="product-nutritions">
    <div align="justify" class="product_short_text">
        <div class="icon-info">
            <div class="icon" align="center"><img src="/uploads/icons/thumbs/'.$product->icon.'" width="150"></div>
            <div class="info-cal">
                <div><strong>Калорийность:</strong> '.$product->calories.' ккал</div>
                <div><strong>Белки:</strong> '.round($product->protein/1000, 3).' г</div>
                <div><strong>Жиры:</strong> '.round($product->fat/1000, 3).' г</div>
                <div><strong>Углеводы:</strong> '.round($product->carbohydrates/1000, 3).' г</div>
            </div>
        </div>
    <p>&nbsp;</p>
    <p>Как определить, является ли продукт полезным? Конечно же, в первую очередь нужно внимательно изучить его состав. 
    Ниже вы сможете посмотреть таблицы с подробным составом данном продукта. А сейчас мы выделим наиболее интересные 
    вещества.</p>
    <p>&nbsp;</p>
    <h4>Витамины</h4>
    <p></p>
    Полезность любого продукта определяется содержанием в его составе необходимых витаминов, макро- и микроэлементов. 
    Продукт <strong>Язык свиной</strong> содержит наибольшее количество следующих, необходимых нашему организму, веществ:<br>
    - среди витаминов высоким содержанием выделяются <strong>Витамин PP (ниацин)</strong>, обеспечивающий 37,5% суточной нормы на 100 г продукта, <strong>Витамин B12 (цианокобаламин)</strong> - 26,7% и <strong>Витамин B2 (рибофлавин)</strong> - 22,2%;<br>- среди макроэлементов выделяются <strong>Фосфор</strong>, <strong>Сера</strong> и <strong>Натрий</strong> (в 100 г продукта содержится 20,8%, 15,9% и 7,2% суточной потребности этих элементов соответственно);<br>- среди микроэлементов самыми лучшими показателями отличаются <strong>Кобальт</strong>, <strong>Железо</strong>, содержание которых в 100 граммах продукта <strong>Язык свиной</strong> обеспечивает 30%, 17,8% суточной нормы соответственно.</p><br>
    <p>Ниже представлены таблицы с подробным составом продукта. В таблицах, помимо пищевой ценности, приводятся данные по содержанию и суточной потребности таких веществ, как витамины, макро- и микроэлементы. На графиках микро- и макроэлементов отражены данные по процентному содержанию этих элементов относительно рекомендованной суточной нормы.</p><br>
    <p>Диаграмма калорийности показывает вклад белков, жиров и углеводов в калорийность продукта белков в процентном соотношении. Каждый грамм белков дает 4 ккал, углеводов - 4 ккал, жиров - 9 ккал. Эти данные очень важно знать при поддержании некоторых диет, которые подразумевают то или иное процентное соотношение углеводов, жиров и белков в рационе.</p><br>
    </div>
    <br>
				
    <div class="nutrition">
				
			<div class="left-col">
			<div class="nutrition_facts">
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
				<hr size="10" noshade="" color="#333333">
				<div>Количество на порцию</div>
	            <hr noshade="" color="#000000" size="1">
				<div class="energy">Калорийность<sup>1</sup>: 208 ккал</div>
				<hr size="4" noshade="" color="#000000">
				<div align="right"><span class="hint--top" data-hint="Процент суточной нормы">% СН*</span></div>
				<div class="nutri_value"><div class="facts_nutri_name">Вода</div><div class="facts_value">65,1 г</div><div class="nutri_procent"></div><div class="clear"></div></div>
				<div class="nutri_value"><div class="facts_nutri_name">Белки</div><div class="facts_value">15,9 г</div><div class="nutri_procent">26,1%</div><div class="clear"></div></div>
				<div class="nutri_value"><div class="facts_nutri_name">Жиры</div><div class="facts_value">16 г</div><div class="nutri_procent">23,9%</div><div class="clear"></div></div>
				<div class="sub_nutri_value"><div class="facts_sub_nutri_name">НЖК</div><div class="facts_value">5,1 г</div><div class="nutri_procent"></div><div class="clear"></div></div>
				<div class="sub_nutri_value"><div class="facts_sub_nutri_name">ПНЖК</div><div class="facts_value">0 г</div><div class="nutri_procent"></div><div class="clear"></div></div>
				<div class="nutri_value"><div class="facts_nutri_name">Углеводы</div><div class="facts_value">2,1 г</div><div class="nutri_procent">0,7%</div><div class="clear"></div></div>
				<div class="sub_nutri_value"><div class="facts_sub_nutri_name">Пищевые волокна</div><div class="facts_value">0 г</div><div class="nutri_procent">0%</div><div class="clear"></div></div>
				<div class="sub_nutri_value"><div class="facts_sub_nutri_name">Моно- и дисахариды</div><div class="facts_value">0 г</div><div class="nutri_procent"></div><div class="clear"></div></div>
				<div class="sub_nutri_value"><div class="facts_sub_nutri_name">Крахмал</div><div class="facts_value">0 г</div><div class="nutri_procent"></div><div class="clear"></div></div>
				<div class="nutri_value"><div class="facts_nutri_name">Органические кислоты</div><div class="facts_value">0 г</div><div class="nutri_procent"></div><div class="clear"></div></div>
				<div class="nutri_value"><div class="facts_nutri_name">Холестерин</div><div class="facts_value">50 мг</div><div class="nutri_procent">16,7%</div><div class="clear"></div></div>
				<div class="nutri_value"><div class="facts_nutri_name">Зола</div><div class="facts_value">0,9 г</div><div class="nutri_procent"></div><div class="clear"></div></div>
				<div class="nutri_value"><div class="facts_nutri_name">Спирт</div><div class="facts_value">0 г</div><div class="nutri_procent"></div><div class="clear"></div></div>
				<hr size="4" noshade="" color="#000000">
				<div class="annotation">* Процент суточной нормы вычисляется исходя из потребностей организма среднестатистической женщины I-й группы активности в возрасте 18-29 лет. Ваша суточная потребность может быть выше или ниже. Подробнее читайте <a href="#">здесь</a>.</div>
			</div>
			
				<div class="mikro">
					<h2 class="nutrition_title">Микроэлементы</h2>
					<div align="center" id="placeholder_mikro" class="mikro-placeholder" style="padding: 0px; position: relative;"><canvas class="flot-base" width="230" height="200" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 230px; height: 200px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 29px; text-align: center;">1</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 44px; text-align: center;">2</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 60px; text-align: center;">3</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 75px; text-align: center;">4</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 90px; text-align: center;">5</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 106px; text-align: center;">6</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 121px; text-align: center;">7</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 136px; text-align: center;">8</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 152px; text-align: center;">9</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 163px; text-align: center;">10</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 179px; text-align: center;">11</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 194px; text-align: center;">12</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 17px; top: 182px; left: 209px; text-align: center;">13</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 169px; left: 15px; text-align: right;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 127px; left: 8px; text-align: right;">25</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 85px; left: 8px; text-align: right;">50</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 42px; left: 8px; text-align: right;">75</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 0px; left: 2px; text-align: right;">100</div></div></div><canvas class="flot-overlay" width="230" height="200" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 230px; height: 200px;"></canvas></div>
					<div align="right"><span class="hint--top" data-hint="Процент суточной нормы">% СН*</span></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 18 мг">1. Железо</span></div><div class="facts_value" style="background-color:#C4EDA0;">3.2 мг</div><div class="nutri_procent">17,8%</div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 12 мг">2. Цинк</span></div><div class="facts_value" style="background-color:#FBE2B3;">0 мг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 150 мкг">3. Йод</span></div><div class="facts_value" style="background-color:#B3E9FB;">0 мкг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 1 мг">4. Медь</span></div><div class="facts_value" style="background-color:#FBB3D7;">0 мг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 2 мг">5. Марганец</span></div><div class="facts_value" style="background-color:#B3FBEE;">0 мг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 55 мкг">6. Селен</span></div><div class="facts_value" style="background-color:#FBF5B3;">0 мкг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 50 мкг">7. Хром</span></div><div class="facts_value" style="background-color:#FBB3BC;">0 мкг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 4000 мкг">8. Фтор</span></div><div class="facts_value" style="background-color:#9DDDFF;">0 мкг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 70 мкг">9. Молибден</span></div><div class="facts_value" style="background-color:#DE9BCD;">0 мкг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 2 мг">10. Бор</span></div><div class="facts_value" style="background-color:#D6EBAD;">0 мг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 40 мкг">11. Ванадий</span></div><div class="facts_value" style="background-color:#FEFC99;">0 мкг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 30 мг">12. Кремний</span></div><div class="facts_value" style="background-color:#DFF7F8;">0 мг</div><div class="nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="facts_nutri_name"><span class="hint--top" data-hint="Норма: 10 мкг">13. Кобальт</span></div><div class="facts_value" style="background-color:#ECD0A3;">3 мкг</div><div class="nutri_procent">30%</div><div class="clear"></div></div>
				</div>
			
			</div>
			
			<div class="right-col">
				<div class="flot_container">
					<div class="diagramm"><h2>Диаграмма калорийности</h2></div>
					<div align="center" id="placeholder" class="demo-placeholder" style="padding: 0px; position: relative;"><canvas class="flot-base" width="200" height="200" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 200px; height: 200px;"></canvas><canvas class="flot-overlay" width="200" height="200" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 200px; height: 200px;"></canvas><div class="pieLabelBackground" style="position: absolute; width: 31px; height: 36px; top: 37px; left: 144.5px; opacity: 0.5; background-color: rgb(0, 0, 0);"></div><span class="pieLabel" id="pieLabel0" style="position: absolute; top: 37px; left: 144.5px;"><div style="font-size:8pt; text-align:center; padding:2px; color:white;">Белки<br>29%</div></span><div class="pieLabelBackground" style="position: absolute; width: 31px; height: 36px; top: 134px; left: 30.5px; opacity: 0.5; background-color: rgb(0, 0, 0);"></div><span class="pieLabel" id="pieLabel1" style="position: absolute; top: 134px; left: 30.5px;"><div style="font-size:8pt; text-align:center; padding:2px; color:white;">Жиры<br>67%</div></span><div class="pieLabelBackground" style="position: absolute; width: 48px; height: 36px; top: 8px; left: 67px; opacity: 0.5; background-color: rgb(0, 0, 0);"></div><span class="pieLabel" id="pieLabel2" style="position: absolute; top: 8px; left: 67px;"><div style="font-size:8pt; text-align:center; padding:2px; color:white;">Углеводы<br>4%</div></span></div>
					<div align="right"><span class="hint--top" data-hint="Процент суточной нормы">% СН*</span></div>
					<div class="diagram_nutri"><div class="diagram_name"><strong>Энергетическая ценность</strong></div><div class="diagram_value"><strong>208 ккал</strong></div><div class="diagram_procent"><strong>10,4%</strong></div><div class="clear"></div></div>
					<div class="diagram_sub_nutri"><div class="diagram_sub_name">От Углеводов</div><div class="diagram_value">8.4 ккал</div><div class="nutri_procent"></div><div class="clear"></div></div>
					<div class="diagram_sub_nutri"><div class="diagram_sub_name">От Жиров</div><div class="diagram_value">144 ккал</div><div class="nutri_procent"></div><div class="clear"></div></div>
					<div class="diagram_sub_nutri"><div class="diagram_sub_name">От Белков</div><div class="diagram_value">63.6 ккал</div><div class="nutri_procent"></div><div class="clear"></div></div>
					<div class="diagram_sub_nutri"><div class="diagram_sub_name">От Спирта</div><div class="diagram_value">0 ккал</div><div class="nutri_procent"></div><div class="clear"></div></div>
				</div>
				
				<div class="makro">
					<h2 class="nutrition_title">Витамины</h2>
					
					<div align="right"><span class="hint--top" data-hint="Процент суточной нормы">% СН*</span></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 90 мг">1. Витамин C</span></div><div class="vita_facts_value">0 мг</div><div class="vita_nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 1.5 мг">2. Витамин B1 (тиамин)</span></div><div class="vita_facts_value">0.2 мг</div><div class="vita_nutri_procent">13,3%</div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 1.8 мг">3. Витамин B2 (рибофлавин)</span></div><div class="vita_facts_value">0.4 мг</div><div class="vita_nutri_procent">22,2%</div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 5 мг">4. Витамин B5 (пантотеновая кислота)</span></div><div class="vita_facts_value">0 мг</div><div class="vita_nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 2 мг">5. Витамин B6 (пиридоксин)</span></div><div class="vita_facts_value">0.3 мг</div><div class="vita_nutri_procent">15%</div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 20 мг">6. Витамин PP (ниацин)</span></div><div class="vita_facts_value">7.5 мг</div><div class="vita_nutri_procent">37,5%</div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 3 мкг">7. Витамин B12 (цианокобаламин)</span></div><div class="vita_facts_value">0.8 мкг</div><div class="vita_nutri_procent">26,7%</div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 400 мкг">8. Витамин B9 (фолиевая кислота)</span></div><div class="vita_facts_value">3 мкг</div><div class="vita_nutri_procent">0,8%</div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 50 мкг">9. Витамин H (биотин)</span></div><div class="vita_facts_value">0 мкг</div><div class="vita_nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 900 мкг">10. Витамин A (РЭ)</span></div><div class="vita_facts_value">0 мкг</div><div class="vita_nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 15 мг">11. Витамин E (ТЭ)</span></div><div class="vita_facts_value">0.9 мг</div><div class="vita_nutri_procent">6%</div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 10 мкг">12. Витамин D</span></div><div class="vita_facts_value">0 мкг</div><div class="vita_nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 120 мкг">13. Витамин K (филлохинон)</span></div><div class="vita_facts_value">0 мкг</div><div class="vita_nutri_procent"></div><div class="clear"></div></div><div class="nutri_value"><div class="vita_nutri_name"><span class="hint--top" data-hint="Норма: 500 мг">14. Холин</span></div><div class="vita_facts_value">0 мг</div><div class="vita_nutri_procent"></div><div class="clear"></div></div>
				</div>
				
				<div class="makro">
					<h2 class="nutrition_title">Макроэлементы</h2>
					<div align="center" id="placeholder_makro" class="makro-placeholder" style="padding: 0px; position: relative;"><canvas class="flot-base" width="300" height="200" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 300px; height: 200px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 42px; top: 182px; left: 39px; text-align: center;">1</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 42px; top: 182px; left: 78px; text-align: center;">2</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 42px; top: 182px; left: 117px; text-align: center;">3</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 42px; top: 182px; left: 156px; text-align: center;">4</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 42px; top: 182px; left: 195px; text-align: center;">5</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 42px; top: 182px; left: 234px; text-align: center;">6</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 42px; top: 182px; left: 273px; text-align: center;">7</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 169px; left: 15px; text-align: right;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 127px; left: 8px; text-align: right;">25</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 85px; left: 8px; text-align: right;">50</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 42px; left: 8px; text-align: right;">75</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 0px; left: 2px; text-align: right;">100</div></div></div><canvas class="flot-overlay" width="300" height="200" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 300px; height: 200px;"></canvas></div>
					<div align="right"><span class="hint--top" data-hint="Процент суточной нормы">% СН*</span></div>
					<div class="nutri_value"><div class="makro_nutri_name"><span class="hint--top" data-hint="Норма: 2500 мг">1. Калий</span></div><div class="facts_value" style="background-color:#C4EDA0;">178 мг</div><div class="nutri_procent">7,1%</div><div class="clear"></div></div><div class="nutri_value"><div class="makro_nutri_name"><span class="hint--top" data-hint="Норма: 1000 мг">2. Кальций</span></div><div class="facts_value" style="background-color:#FBE2B3;">11 мг</div><div class="nutri_procent">1,1%</div><div class="clear"></div></div><div class="nutri_value"><div class="makro_nutri_name"><span class="hint--top" data-hint="Норма: 400 мг">3. Магний</span></div><div class="facts_value" style="background-color:#B3E9FB;">22 мг</div><div class="nutri_procent">5,5%</div><div class="clear"></div></div><div class="nutri_value"><div class="makro_nutri_name"><span class="hint--top" data-hint="Норма: 1300 мг">4. Натрий</span></div><div class="facts_value" style="background-color:#FBB3D7;">93 мг</div><div class="nutri_procent">7,2%</div><div class="clear"></div></div><div class="nutri_value"><div class="makro_nutri_name"><span class="hint--top" data-hint="Норма: 1000 мг">5. Сера</span></div><div class="facts_value" style="background-color:#B3FBEE;">159 мг</div><div class="nutri_procent">15,9%</div><div class="clear"></div></div><div class="nutri_value"><div class="makro_nutri_name"><span class="hint--top" data-hint="Норма: 800 мг">6. Фосфор</span></div><div class="facts_value" style="background-color:#FBF5B3;">166 мг</div><div class="nutri_procent">20,8%</div><div class="clear"></div></div><div class="nutri_value"><div class="makro_nutri_name"><span class="hint--top" data-hint="Норма: 2300 мг">7. Хлор</span></div><div class="facts_value" style="background-color:#FBB3BC;">0 мг</div><div class="nutri_procent"></div><div class="clear"></div></div>
				</div>
				
			</div><!-- .right-col -->
				
		</div><!-- .nutrition -->
		
    <div class="nutri-info">
        <sup>1</sup> - Калорийность, или <strong>энергетическая ценность</strong>, продукта имеет очень важное значение. Этот показатель отражает количество энергии, которую получает наш организм из того или иного продукта в процессе пищеварения. Из наших таблиц Вы сможете узнать сколько килокалорий дает организму тот или иной продукт питания, что позволит приблизительно рассчитать свой дневной рацион.
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