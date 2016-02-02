<?php
namespace frontend\controllers;

use app\components\GlobalHelper;
use app\components\PostAdditions;
use app\components\SocialButtonsWidget;
use app\models\Advert;
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
     * Если передана одна категория, метод вернет массив с ее ID и ID всех дочерних (подкатегорий) (за исключением
     * случая, когда третьим параметром передан true; тогда метод вернет только ID данной категории без дочерних).
     * Если передана подкатегория, метод вернет только ее ID в виде массива из одного элемента.
     * Если в массиве категорий ($categories) нет такой категории, генерируется исключение NotFoundHttpException.
     *
     * @param $cat
     * @param $categories
     * @param $noChilds
     * @return array
     * @throws NotFoundHttpException
     */
    protected function postCategory($cat, $categories, $noChilds = false){
        // Если адрес состоит из категории и подкатегории, выбираем только подкатегорию
        if(strpos($cat, '/')){
            $cats = explode('/', $cat);
            $cat = end($cats);
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

    public function actionShort()
    {
        // Получаем список всех категорий, переиндексированный по id категорий
        $categories = GlobalHelper::getCategories();

        // Создаем объект ActiveQuery, общий для всех вариантов (категорий, поиска, вывода по датам)
        $query = Post::find()->where(['approve' => Post::APPROVED])
            ->orderBy(['date' => SORT_DESC]);

        // Определяем тип
        $type = Yii::$app->request->get('type');
        $subCategories = '';
        // Если выборка по категориям
        if($type == 'byCat'){
            // Получаем id категорий
            $categoryIds = $this->postCategory(Yii::$app->request->get('cat'), $categories);
            // Записываем id текущей категории в глобальный параметр
            $categoryId = GlobalHelper::getCategoryIdByUrl(Yii::$app->request->get('cat'), true);
            Yii::$app->params['category'] = $categoryId;
            // Проверяем, является ли категория статьей и если да, запускаем метод actionFull
            if($categories[$categoryId[0]]['category_art'] != 0) {
                Yii::$app->params['category_art'] = $categories[$categoryId[0]]['category_art'];

                return $this->actionFull();
            }
            // Если страница первая, проверяем, есть ли у данной категории подкатегории.
            // Если есть, выводим их сверху
            $subCats = [];
            if(Yii::$app->request->get('page') == 1){
                foreach($categories as $cat){
                    if($cat['parent_id'] == $categoryId[0] && $cat['category_art'] == 0){
                        $subCats[] = $cat['id'];
                    }
                }
                if(!empty($subCats)){
                    $subCategories = $this->renderPartial('short_cat', ['categories' => $subCats]);
                }
            }

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
        // Если выборка по датам
        if($type == 'byDate') {
            //var_dump(Yii::$app->request->get('year'));
            $y = (Yii::$app->request->get('year')) ? Yii::$app->request->get('year') : date('Y');
            $m = Yii::$app->request->get('month');
            $d = Yii::$app->request->get('day');

            // Записываем дату в глобальный параметр для постраничной навигации
            Yii::$app->params['date'] = $y . ($m ? '/'.$m : '') . ($d ? '/'.$d : '');

            $date = $y;
            $dateFormat = '%Y';

            // Если задан месяц
            if($m){
                $dateFormat .= '-%m';
                $date .= '-'.$m;
                if($d){
                    $dateFormat .= '-%d';
                    $date .= '-'.$d;
                }
            }

            $query->andWhere("DATE_FORMAT( DATE, '$dateFormat' ) = :date", [':date' => $date]);
        }

        // Если главная страница и просто страницы
        if(!$type || $type == 'index') {
            $query->andWhere(['allow_main' => 1]);
        }

        $countPosts = clone $query;
        $pages = new Pagination(['totalCount' => $countPosts->count(), 'route' => 'post/short']);
        $posts = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->with('postCategories')
            ->all();

        return $this->render('short', ['posts' => $posts, 'pages' => $pages, 'categories' => $categories, 'subCategories' => $subCategories]);
    }

    public function actionFull()
    {
        //$request = Yii::$app->request;
        //$post = Post::find()->where(['id' => $request->get('id'), 'approve' => Post::APPROVED])->one();
        // или можно без approve
        //$post = Post::findOne($request->get('id'));
        // или

        // Определяем Id
        // Если это статья-категория, берем из params, иначе из request->get
        $postId = (Yii::$app->params['category_art']) ? Yii::$app->params['category_art'] : Yii::$app->request->get('id');

        $post = Post::findOne([
            'id' => $postId,
            'approve' => Post::APPROVED,
        ]);

        if(is_null($post)){
            throw new NotFoundHttpException('Статьи с данным адресом на сайте не существует. Проверьте правильно ли вы скопировали или ввели адрес в адресную строку. Если вы перешли на эту страницу по ссылке с данного сайта, сообщите пожалуйста о неработающей ссылке нам с помощью обратной связи.');
        }

        // Записываем id текущей категории в виде массива в глобальный параметр
        $categoryId = $post->postCategories[0]->category_id;
        Yii::$app->params['category'] = [$categoryId];

        // Добавление комментариев
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

        // Применение дополнительных методов для обработки полного текста статей
        if($m = GlobalHelper::getCategories()[$categoryId]['add_method']){
            $methodName = 'full'.ucfirst($m);
            if(method_exists('app\components\PostAdditions', $methodName)) {
                PostAdditions::$methodName($post);
            }
        }

        // Социальные кнопки
        $post->full .= SocialButtonsWidget::widget();

        // Рекламные материалы
        $post = $this->insertAdvert($post);

        // Обновление количества просмотров статьи
        $post->updateCounters(['views' => 1]);

        // Если статья-категория, используем представление full_cat.php, иначе full.php
        $viewFile = Yii::$app->params['category_art'] ? 'full_cat' : 'full';

        return $this->render($viewFile, ['post' => $post, 'model' => $model]);
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
     * @param $post
     * @return mixed
     */
    protected function insertAdvert($post) {
        $adverts = Advert::find()
            ->where(['approve' => 1])
            ->asArray()
            ->all();

        if(is_null($adverts))
            return $post;

        foreach($adverts as $advert) {
            if(!$advert['replacement_tag']) $advert['replacement_tag'] = 'none';
            if($advert['location'] != 'various'){
                if($advert['replacement_tag'] != 'none' && strstr($post->full, "[{$advert['replacement_tag']}]"))
                {
                    $post->full = str_replace("[{$advert['replacement_tag']}]", $advert['code'], $post->full);
                }
                else if($advert['replacement_tag'] == "none" && strstr($post->full, "[advert-{$advert['block_number']}]"))
                {
                    $post->full = str_replace("[advert-{$advert['block_number']}]", $advert['code'], $post->full);
                }
                else if($advert['location'] == "inside")
                {
                    if(!$advert['on_request'])
                    {
                        $dlina_full = strlen($post->full);
                        $seredina_full = round($dlina_full/2);
                        $diapazon_start = $seredina_full - 100;
                        $diapazon_finish = $seredina_full + 100;

                        $perv_chast = substr($post->full, 0, $diapazon_start-1);
                        $sred_chast = substr($post->full, $diapazon_start, 201);
                        $vtor_chast = substr($post->full, $diapazon_finish+1);

                        $pos_tochka = strpos($sred_chast, ".");

                        $sred_1 = substr($sred_chast, 0, $pos_tochka);
                        $sred_2 = substr($sred_chast, $pos_tochka+1);

                        $post->full = $perv_chast.$sred_1.'.<br />' . $advert['code'] . '<br>'.$sred_2.$vtor_chast;
                    }
                }
                else if($advert['location'] == "top")
                {
                    $post->full = $advert['code'] . "<br>" . $post->full;
                }
                else if($advert['location'] == "bottom")
                {
                    $post->full = $post->full . "<br>" . $advert['code'];
                }
            }
        }

        return $post;
    }

}