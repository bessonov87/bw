<?php
namespace frontend\controllers;

use app\components\GlobalHelper;
use frontend\models\Category;
use frontend\models\PostCategory;
use frontend\models\CommentForm;
use frontend\models\Post;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller{

    /**
     * Определение ID категории(й) для выборки анонсов
     *
     * Категория ($cat) передается в формате строки вида 'category_url' или 'category_url/subcategory_url'.
     * Если передана одна категория, метод вернет массив с ее ID и ID всех дочерних (подкатегорий).
     * Если передана подкатегория, метод вернет только ее ID в виде массива из одного элемента.
     * Если в массиве категорий ($categories) нет такой категории, генерируется исключение NotFoundHttpException.
     *
     * @param $cat
     * @param $categories
     * @return array
     * @throws NotFoundHttpException
     */
    protected function postCategory($cat, $categories){
        // Если адрес состоит из категории и подкатегории, выбираем только подкатегорию
        if(strpos($cat, '/')){
            $cat = end(explode('/', $cat));
        }
        // Переиндексируем массив категорий по значению url
        $categories = ArrayHelper::index($categories, 'url');
        if(is_null($categories[$cat])){
            throw new NotFoundHttpException('Такого раздела на сайте не существует. Проверьте правильно ли вы скопировали или ввели адрес в адресную строку. Если вы перешли на эту страницу по ссылке с данного сайта, сообщите пожалуйста о неработающей ссылке нам с помощью обратной связи.');
        }
        //var_dump($categories[$cat]);
        // Если у данной категории нет родительской, проверяем на наличие дочерних и добавляем их к запросу
        if($categories[$cat]['parent_id'] == 0){
            foreach($categories as $category){
                if($category['parent_id'] == $categories[$cat]['id']){
                    $categoryIds[] = $category['id'];
                }
            }
        }
        $categoryIds[] = $categories[$cat]['id'];
        return $categoryIds;
    }

    public function actionIndex(){

    }

    public function actionShort()
    {
        // Получаем список всех категорий, переиндексированный по id категорий
        $categories = GlobalHelper::getCategories();

        $query = Post::find()->where(['approve' => Post::APPROVED])
            ->orderBy(['date' => SORT_DESC]);

        $type = Yii::$app->request->get('type');
        if($type == 'byCat'){
            // Получаем id категорий
            $categoryIds = $this->postCategory(Yii::$app->request->get('cat'), $categories);
            // Получаем список постов для данных категорий
            $cateroryPostIds = PostCategory::find()
                ->asArray()
                ->where(['in', 'category_id', $categoryIds])
                ->all();
            // Выбираем только ID постов
            $postIds = ArrayHelper::getColumn($cateroryPostIds, 'post_id');
            // Добавляем условие к запросу на выборку статей
            $query->andWhere(['in', 'id', $postIds]);

        }

        $countPosts = clone $query;
        $pages = new Pagination(['totalCount' => $countPosts->count()]);
        $posts = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->with('postCategories')
            ->all();

        return $this->render('short', ['posts' => $posts, 'pages' => $pages, 'categories' => $categories]);


        $request = Yii::$app->request;
        $format = $request->get('format');
        if($format == 'byCat'){
            $title = 'Статьи раздела ' . $request->get('cat');
            $params = [
                'cat' => $request->get('cat'),
            ];
        }
        elseif($format == 'byDate'){
            $title = 'Статьи за ' . $request->get('year');
            $params = [
                'year' => $request->get('year'),
                'month' => $request->get('month'),
                'day' => $request->get('day'),
            ];
        }
        $params['page'] = $request->get('page');
        $params['title'] = $title;
        return $this->render('short', $params);
    }

    public function actionFull()
    {
        $request = Yii::$app->request;
        //$post = Post::find()->where(['id' => $request->get('id'), 'approve' => Post::APPROVED])->one();
        // или можно без approve
        //$post = Post::findOne($request->get('id'));
        // или
        $post = Post::findOne([
            'id' => $request->get('id'),
            'approve' => Post::APPROVED,
        ]);

        if(!Yii::$app->user->isGuest) {
            $model = new CommentForm();
            // Значение для hidden user_id
            $model->user_id = Yii::$app->user->identity->getId();
            $model->post_id = $post->id;
            if ($model->load(Yii::$app->request->post())) {
                if ($id = $model->addComment()) {
                    Yii::$app->session->setFlash('comment-success', $id);
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('comment-error');
                }
            }
        }

        return $this->render('full', ['post' => $post, 'model' => $model]);
    }

}