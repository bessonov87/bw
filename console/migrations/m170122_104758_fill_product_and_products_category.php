<?php

use yii\db\Migration;

class m170122_104758_fill_product_and_products_category extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $products_category = file_get_contents(\Yii::getAlias('@console/.data/product_categories.json'));
        $products_category = \yii\helpers\Json::decode($products_category);
        foreach ($products_category as $prod_cat){
            $prodCat = new \common\models\ProductsCategory($prod_cat);
            if(!$prodCat->save()){
                throw new \yii\base\ErrorException('Can not save ProductsCategory '.json_encode($prodCat->getErrors()));
            }
        }

        var_dump(\common\models\ProductsCategory::find()->all());

        $products = file_get_contents(\Yii::getAlias('@console/.data/products.json'));
        $products = \yii\helpers\Json::decode($products);
        foreach ($products as $prod){
            if(!$prod){
                throw new \yii\web\ServerErrorHttpException('EMPTY');
            }
            $product = new \common\models\Product($prod);
            if(!$product->save()){
                echo "{$product->name}\n";
                throw new \yii\base\ErrorException('Can not save Product '.json_encode($product->category).' '.json_encode($product->name).' '.json_encode($product->getErrors()));
            }
        }
    }

    public function safeDown()
    {
        \common\models\Product::deleteAll();

        \common\models\ProductsCategory::deleteAll();
    }
}
