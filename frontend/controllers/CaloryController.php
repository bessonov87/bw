<?php

namespace frontend\controllers;

use common\models\NormsFatProt;
use common\models\NormsVitMin;
use common\models\Product;
use common\models\ProductsCategory;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CaloryController extends Controller
{
    public function actionIndex()
    {
        $categories = ProductsCategory::find()->all();
        return $this->render('index', [
            'categories' => $categories,
        ]);
    }

    public function actionCategory($category)
    {
        //var_dump($category); die;

        $category = $this->findCategory($category);

        $query = Product::find()->where(['category' => $category->id, 'approve' => 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['approve'],
                //'defaultOrder' => ['name' => SORT_ASC],
            ],
            'pagination' => [
                'defaultPageSize' => 100,
                'pageSizeLimit' => [1, 200],
            ],
        ]);

        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($category, $product)
    {
        $category = $this->findCategory($category);
        $product = $this->findProduct($product);

        //var_dump($product); die;

        // Нормы
        $norms = NormsFatProt::find()
            ->where(['groupa' => 1, 'sex' => 'w', 'age' => '18-29'])
            ->one();

        $calories_norm = $norms->energy;
        $protein_norm = $norms->protein;
        $fat_norm = $norms->fat;
        $carbohydrate_norm = $norms->carbohydrate;

        // Пищевая ценность
        $calories = $nutri['calories'] = str_replace(',', '.', round($product->calories, 1));
        $water = $nutri['water'] = round($product->water / 1000, 1);
        $protein = $nutri['protein'] = round($product->protein / 1000, 1);
        $fat = $nutri['fat'] = round($product->fat / 1000, 1);
        $unsaturated_fatty_acids = $nutri['unsaturated_fatty_acids'] = round($product->unsaturated_fatty_acids / 1000, 1);
        $saturated_fatty_acids = $nutri['saturated_fatty_acids'] = round($product->saturated_fatty_acids / 1000, 1);
        $carbohydrates = $nutri['carbohydrates'] = round($product->carbohydrates / 1000, 1);
        $fiber = $nutri['fiber'] = round($product->fiber / 1000, 1);
        $saccharides = $nutri['saccharides'] = round($product->saccharides / 1000, 1);
        $starch = $nutri['starch'] = round($product->starch / 1000, 1);
        $organic_acids = $nutri['organic_acids'] = round($product->organic_acids / 1000, 1);
        $cholesterol = $nutri['cholesterol'] = round($product->cholesterol, 1);
        $ash = $nutri['ash'] = round($product->ash / 1000, 1);
        $alco = $nutri['alco'] = round($product->alco / 1000, 1);

        $percents['calories'] = round( ($calories / $calories_norm) * 100, 1 );
        $percents['protein'] = round( ($protein / $protein_norm) * 100, 1 );
        $percents['fat'] = round( ($fat / $fat_norm) * 100, 1 );
        $percents['carbohydrates'] = round( ($carbohydrates / $carbohydrate_norm) * 100, 1 );
        $percents['fiber'] = round( ($fiber / 20) * 100, 1 );
        $percents['cholesterol'] = round( ($cholesterol / 300) * 100, 1 );

        // Диаграмма калорийности
        $caloriesArray = [];
        $caloriesArray['protein'] = str_replace(',', '.', round($protein * 4, 1));
        $caloriesArray['fat'] = str_replace(',', '.', round($fat * 9, 1));
        $caloriesArray['carbohydrates'] = str_replace(',', '.', round($carbohydrates * 4, 1));
        $caloriesArray['alco'] = str_replace(',', '.', round($alco * 7, 1));

        $caloriesPercents = [];
        foreach ($caloriesArray as $key => $value){
            $caloriesPercents[$key] = round( ($value / $calories_norm) * 100, 1 );
        }


        // Нормы витаминов, макро- и микроэлементов
        $norms_vit_min = NormsVitMin::find()
            ->where(['sex' => 'w'])
            ->orWhere(['sex' => 'a'])
            ->all();
        $norms_vit_min = ArrayHelper::index($norms_vit_min, 'alt_name');
        //var_dump($norms_vit_min); die;

        // Микроэлементы
        $microelements = [];
        $microelementsOptions = [
            ['name' => 'Железо', 'key' => 'micro_fe', 'color' => '#C4EDA0', 'flot_color' => '#6BD113'],
            ['name' => 'Цинк', 'key' => 'micro_zn', 'color' => '#FBE2B3', 'flot_color' => '#F5B642'],
            ['name' => 'Йод', 'key' => 'micro_j', 'color' => '#B3E9FB', 'flot_color' => '#42C8F5'],
            ['name' => 'Медь', 'key' => 'micro_cu', 'color' => '#FBB3D7', 'flot_color' => '#F5429B'],
            ['name' => 'Марганец', 'key' => 'micro_mn', 'color' => '#B3FBEE', 'flot_color' => '#42F5D4'],
            ['name' => 'Селен', 'key' => 'micro_se', 'color' => '#FBF5B3', 'flot_color' => '#F5E642'],
            ['name' => 'Хром', 'key' => 'micro_cr', 'color' => '#FBB3BC', 'flot_color' => '#F54257'],
            ['name' => 'Фтор', 'key' => 'micro_f', 'color' => '#9DDDFF', 'flot_color' => '#0AAAFE'],
            ['name' => 'Молибден', 'key' => 'micro_mo', 'color' => '#DE9BCD', 'flot_color' => '#AD0481'],
            ['name' => 'Бор', 'key' => 'micro_b', 'color' => '#D6EBAD', 'flot_color' => '#99CC33'],
            ['name' => 'Ванадий', 'key' => 'micro_v', 'color' => '#FEFC99', 'flot_color' => '#FDF800'],
            ['name' => 'Кремний', 'key' => 'micro_si', 'color' => '#DFF7F8', 'flot_color' => '#AFEAEE'],
            ['name' => 'Кобальт', 'key' => 'micro_co', 'color' => '#ECD0A3', 'flot_color' => '#FF9623'],
        ];

        foreach($microelementsOptions as $one_micro)
        {
            $one_micro_name = $one_micro['key'];
            # Значения
            $micro_val = $this->to_unit_value($product->$one_micro_name, $norms_vit_min[$one_micro_name]['unit']);
            $microelements[$one_micro_name]['value'] = str_replace(',', '.', round($micro_val, 1));
            # Названия
            $microelements[$one_micro_name]['name'] = $norms_vit_min[$one_micro_name]['name'];
            # Единицы измерения
            $microelements[$one_micro_name]['unit'] = $norms_vit_min[$one_micro_name]['unit'];
            # Нормы
            $microelements[$one_micro_name]['norm'] = $norms_vit_min[$one_micro_name]['value'];
            # Процент дневной нормы
            $microelements[$one_micro_name]['procent'] = round(($microelements[$one_micro_name]['value']/$norms_vit_min[$one_micro_name]['value']) * 100, 1) . "%";
            if($microelements[$one_micro_name]['procent'] == "0%") $microelements[$one_micro_name]['procent'] = "";
            # Процент дневной нормы для графика
            $microelements[$one_micro_name]['flot_procent'] = str_replace(',', '.', round(($microelements[$one_micro_name]['value']/$norms_vit_min[$one_micro_name]['value']) * 100, 1));
            # Цвет для фона и графика
            $microelements[$one_micro_name]['color'] = $one_micro['color'];
            $microelements[$one_micro_name]['flot_color'] = $one_micro['flot_color'];
        }

        // Витамины
        $vitamins = [];
        $vitamins_alt_names = array('vit_c', 'vit_b1', 'vit_b2', 'vit_b5', 'vit_b6', 'vit_pp_niacin', 'vit_b12', 'vit_b9', 'vit_h', 'vit_a_re', 'vit_a_re', 'vit_e_te', 'vit_d', 'vit_k', 'vit_choline');

        $y = 0;
        foreach($vitamins_alt_names as $one_vita_name)
        {
            # Значения
            $vita_val = $this->to_unit_value($product->$one_vita_name, $norms_vit_min[$one_vita_name]['unit']);
            $vitamins[$one_vita_name]['value'] = str_replace(',', '.', round($vita_val, 1));
            # Названия
            $vitamins[$one_vita_name]['name'] = $norms_vit_min[$one_vita_name]['name'];
            # Единицы измерения
            $vitamins[$one_vita_name]['unit'] = $norms_vit_min[$one_vita_name]['unit'];
            # Нормы
            $vitamins[$one_vita_name]['norm'] = $norms_vit_min[$one_vita_name]['value'];
            # Процент дневной нормы
            $vitamins[$one_vita_name]['procent'] = round(($vitamins[$one_vita_name]['value']/$norms_vit_min[$one_vita_name]['value']) * 100, 1) . "%";
            # Процент дневной нормы для графика (Графика нет. Используется для сортировки)
            $vitamins[$one_vita_name]['flot_procent'] = str_replace(',', '.', round(($vitamins[$one_vita_name]['value']/$norms_vit_min[$one_vita_name]['value']) * 100, 1));
            if($vitamins[$one_vita_name]['procent'] == "0%") $vitamins[$one_vita_name]['procent'] = "";
            $y++;
        }

        // Макроэлементы
        $macroelements = [];
        $macroelementsOptions = [
            ['name' => 'Калий', 'key' => 'macro_k', 'color' => '#6BD113', 'flot_color' => '#C4EDA0'],
            ['name' => 'Кальций', 'key' => 'macro_ca', 'color' => '#F5B642', 'flot_color' => '#FBE2B3'],
            ['name' => 'Магний', 'key' => 'macro_mg', 'color' => '#42C8F5', 'flot_color' => '#B3E9FB'],
            ['name' => 'Натрий', 'key' => 'macro_na', 'color' => '#F5429B', 'flot_color' => '#FBB3D7'],
            ['name' => 'Сера', 'key' => 'macro_s', 'color' => '#42F5D4', 'flot_color' => '#B3FBEE'],
            ['name' => 'Фосфор', 'key' => 'macro_p', 'color' => '#F5E642', 'flot_color' => '#FBF5B3'],
            ['name' => 'Хлор', 'key' => 'macro_cl', 'color' => '#F54257', 'flot_color' => '#FBB3BC'],
        ];

        $z = 0;
        foreach($macroelementsOptions as $one_macro)
        {
            $one_macro_name = $one_macro['key'];
            # Значения
            $macro_val = $this->to_unit_value($product->$one_macro_name, $norms_vit_min[$one_macro_name]['unit']);
            $macroelements[$one_macro_name]['value'] = str_replace(',', '.', round($macro_val, 1));
            # Названия
            $macroelements[$one_macro_name]['name'] = $norms_vit_min[$one_macro_name]['name'];
            # Единицы измерения
            $macroelements[$one_macro_name]['unit'] = $norms_vit_min[$one_macro_name]['unit'];
            # Нормы
            $macroelements[$one_macro_name]['norm'] = $norms_vit_min[$one_macro_name]['value'];
            # Процент дневной нормы
            $macroelements[$one_macro_name]['procent'] = round(($macroelements[$one_macro_name]['value']/$norms_vit_min[$one_macro_name]['value']) * 100, 1) . "%";
            if($macroelements[$one_macro_name]['procent'] == "0%") $macroelements[$one_macro_name]['procent'] = "";
            # Процент дневной нормы для графика
            $macroelements[$one_macro_name]['flot_procent'] = str_replace(',', '.', round(($macroelements[$one_macro_name]['value']/$norms_vit_min[$one_macro_name]['value']) * 100, 1));
            # Цвет для фона и графика
            $macroelements[$one_macro_name]['color'] = $one_macro['color'];
            $macroelements[$one_macro_name]['flot_color'] = $one_macro['flot_color'];
            $z++;
        }

        $microelements_sort = $microelements;
        usort($microelements_sort, [$this, "mysort"]);

        $vitamins_sort = $vitamins;
        usort($vitamins_sort, [$this, "mysort"]);

        $macroelements_sort = $macroelements;
        usort($macroelements_sort, [$this, "mysort"]);

        $product_score = 0.710 - 0.0538 * $fat - 0.423 * $saturated_fatty_acids - 0.00398 * $cholesterol - 0.00254 * $product->macro_na - 0.0300 * $carbohydrates + 0.561 * $fiber - 0.0245 * $saccharides + 0.123 * $protein + 0.00562 * $vitamins['vit_a_re']['flot_procent'] + 0.0137 * $vitamins['vit_c']['flot_procent'] + 0.0685 * $macroelements['macro_ca']['flot_procent'] - 0.0186 * $microelements['micro_fe']['flot_procent'];

        //echo "Score: " . $product_score . "<br />";

        $num_micros = 0;
        if($microelements_sort[0]["procent"] > 0 && $microelements_sort[1]["procent"] > 0 && $microelements_sort[2]["procent"] > 0) $num_micros = 3;
        if($microelements_sort[0]["procent"] > 0 && $microelements_sort[1]["procent"] > 0 && $microelements_sort[2]["procent"] == 0) $num_micros = 2;
        if($microelements_sort[0]["procent"] > 0 && $microelements_sort[1]["procent"] == 0 && $microelements_sort[2]["procent"] == 0) $num_micros = 1;
        if($microelements_sort[0]["procent"] == 0 && $microelements_sort[1]["procent"] == 0 && $microelements_sort[2]["procent"] == 0) $num_micros = 0;

        $auto_product_description = "<p>Как определить, является ли продукт полезным? Конечно же, в первую очередь нужно внимательно изучить его состав. 
        Ниже вы сможете посмотреть таблицы с подробным составом данном продукта. Но сначала следует отметить, какие из витаминов 
        микро- и макроэлементов наиболее сильно выделяются в составе этого продукта:</p>
        <strong>Витамины</strong>
        <p>Следует выделить <em>" . $vitamins_sort[0]["name"] . "</em>, который  на 100 грамм продукта 
        обеспечивает ".$vitamins_sort[0]["procent"]." суточной нормы, 
        <em>" . $vitamins_sort[1]["name"] . "</em> - " . $vitamins_sort[1]["procent"] . " и 
        <em>" . $vitamins_sort[2]["name"] . "</em> - " . $vitamins_sort[2]["procent"] . "</p>
        <strong>Микроэлементы</strong>
        <p>Здесь можно отметить ";
        $microNames = [];
        $microPercents = [];
        for($i=0;$i<=2;$i++){
            if($microelements_sort[$i]["procent"] > 0){
                $microNames[] = " <em>" . $microelements_sort[$i]["name"] . "</em>";
                $microPercents[] = $microelements_sort[$i]["procent"];
            }
        }

        $auto_product_description .= implode(', ', $microNames);
        $auto_product_description .= " с содержанием в 100 г продукта ";
        $auto_product_description .= implode(', ', $microPercents);
        if(count($microNames) > 1) {
            $auto_product_description .= " соответственно.";
        } else {
            $auto_product_description .= ".";
        }

        $auto_product_description .= "</p>
        <strong>Макроэлементы</strong>
        <ul>
        <li>" . $macroelements_sort[0]["name"] . " - ".$macroelements_sort[0]["procent"]." суточной нормы;</li>
        <li>" . $macroelements_sort[1]["name"] . " - ".$macroelements_sort[1]["procent"]." суточной нормы;</li> 
        <li>" . $macroelements_sort[2]["name"] . " - ".$macroelements_sort[2]["procent"]." суточной нормы;</li>
        </ul>";

        //$auto_product_keywords = "<strong>Ключевые слова</strong>: " . $product_name . ", химический состав, калорийность, содержание витаминов, макроэлементы, микроэлементы, минералы, полезные свойства <strong>" . $product_name . "</strong>, пищевая ценность, чем полезен продукт " . $product_name . ".";

        /*if($product->screen == ""){
            $art_screen = "";
        } else {
            $art_screen = '<img src="/'.$product->screen.'" border="0">';
        }
        $product_cats_table = $product->category;*/

        return $this->render('view', [
            'category' => $category,
            'product' => $product,
            'norms' => $norms,
            'caloriesArray' => $caloriesArray,
            'norms_vit_min' => $norms_vit_min,
            'microelements' => $microelements,
            'macroelements' => $macroelements,
            'vitamins' => $vitamins,
            'auto_product_description' => $auto_product_description,
            'percents' => $percents,
            'caloriesPercents' => $caloriesPercents,
            'nutri' => $nutri,
        ]);
    }

    protected function findCategory($catUrl)
    {
        if(!$category = ProductsCategory::find()->where(['url' => $catUrl])->one()){
            throw new NotFoundHttpException('Страница не найдена');
        }
        return $category;
    }

    protected function findProduct($prodAltName)
    {
        if(!$product = Product::find()->where(['alt_name' => $prodAltName])->one()){
            throw new NotFoundHttpException('Страница не найдена');
        }
        return $product;
    }

    protected function to_unit_value($mg_value, $unit)
    {
        $value = $mg_value;
        if($unit == "мг") $value = $mg_value;
        if($unit == "мкг") $value = $mg_value * 1000;
        return $value;
    }

    // Функция сортировки элементов массива
    protected function mysort($a, $b)
    {
        if ($a["flot_procent"] == $b["flot_procent"])
        {
            if ($a["value"] == $b["value"])
            {
                return 0;
            }
            return ($a["value"] < $b["value"]) ? -1 : 1;
        }
        return ($a["flot_procent"] > $b["flot_procent"]) ? -1 : 1;
    }
}