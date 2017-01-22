<?php

namespace frontend\controllers;

use common\models\Product;
use common\models\ProductsCategory;
use yii\data\ActiveDataProvider;
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
        $category = $this->findCategory($category);

        $query = Product::find()->where(['category' => $category->id]);
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

        return $this->render('view', [
            'category' => $category,
            'product' => $product,
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
}