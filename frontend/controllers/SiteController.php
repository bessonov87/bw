<?php
namespace frontend\controllers;

use common\models\ar\UserProfile;
use frontend\components\behaviors\UrlBehavior;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use common\models\ar\User;
use common\models\ar\Post;
use common\models\ar\Auth;
use common\models\LoginForm;
use frontend\models\form\Contact2Form;
use frontend\models\form\ConfirmEmailForm;
use frontend\models\form\SearchForm;
use frontend\models\form\PasswordResetRequestForm;
use frontend\models\form\ResetPasswordForm;
use frontend\models\form\SignupForm;
use frontend\models\form\ContactForm;
use app\components\TemporaryUnavailableException;
use common\components\helpers\GlobalHelper;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'url' => [
                'class' => UrlBehavior::className(),
                'allow' => ['feedback'],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
                'successUrl' => Yii::$app->session->get('previosUrl'),
            ],
        ];
    }

    /**
     * Контроль доступа к методам, связанным с регистрацией/авторизацией пользователей
     *
     * В зависимости от параметров приложения в секции ['users'] запрещает доступ к тем или иным методам,
     * связанным с регистрацией и авторизацией. В конфигурации ($config) указано, какие методы от каких параметров
     * зависят. Чтобы метод был доступен, все параметры должны иметь значение true или любое другое значение,
     * которое при сравнении преобразуется в true.
     *
     * @param \yii\base\Action $action
     * @return bool true, если метод разрешен
     * @throws TemporaryUnavailableException Исключение "Временно недоступно", если доступ к запрашиваемому методу не разрешен
     */
    public function beforeAction($action){
        $config = [
            'login' => ['allowModule', 'allowAuthorization'],
            'logout' => ['allowModule', 'allowAuthorization'],
            'signup' => ['allowModule', 'allowRegistration'],
            'reset-password' => ['allowModule', 'allowAuthorization'],
            'request-password-reset' => ['allowModule', 'allowAuthorization'],
            'confirm-email' => ['allowModule', 'allowRegistration'],
        ];

        $action = $action->id;

        if(array_key_exists($action, $config)){
            foreach($config[$action] as $property){
                if(!Yii::$app->params['users'][$property] && !in_array(Yii::$app->request->userIP, Yii::$app->params['fullAccessIps'])) {
                    throw new TemporaryUnavailableException();
                }
            }
        }

        return true;
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->goHome();
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', 'Вход произведен. Теперь вы можете использовать все дополнительные возможности сайта.');
            $this->redirect($this->getPreviosUrl());
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goBack();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                $activation = (Yii::$app->params['emailActivation']) ? ' Ваша учетная запись пока не является активной. На адрес email, указанный вами при регистрации было отправлено письмо с данными для активации учетной записи. Проверьте свою электронную почту и следуйте инструкциям из письма.' : '';
                Yii::$app->session->setFlash('success', 'Спасибо за регистрацию. Теперь вы можете войти на сайт используя свои имя пользователя и пароль.'.$activation);
                return $this->redirect($this->getPreviosUrl());
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту и следуйте инструкциям из письма.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Извините, мы не можем отправить письмо на ваш email. Обратитесь к администрации.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен. Теперь вы можете войти на сайт, используя новый пароль.');

            return $this->redirect(['site/login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Подтверждение email
     *
     * @param string $token
     * @return string|Response
     */
    public function actionConfirmEmail($token = 'none'){
        if(!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->status == User::STATUS_ACTIVE) {
                return $this->goHome();
            }
        }
        $model = new ConfirmEmailForm($token);
        if($model->userFound){
            if($model->activateUser()) {
                Yii::$app->session->setFlash('success', 'Ваш Email адрес подтвержден. Теперь вы можете пользоваться всеми функциями, доступными для авторизованных пользователей сайта.');
                return $this->redirect($this->getPreviosUrl());
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка.');
            }
        } elseif($token != 'none') {
            Yii::$app->session->setFlash('error', 'Код подтверждения не найден или не является разрешенным к использованию.');
        }

        return $this->render('confirmEmail', ['model' => $model]);
    }


    /**
     * Обратная связь
     *
     * @return string
     */
    public function actionFeedback()
    {
        $model = new Contact2Form();

        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            if($model->sendEmail()){
                Yii::$app->session->setFlash('success', 'Письмо отправлено.');
            } else {
                Yii::$app->session->setFlash('error', 'При отправке письма произошла ошибка. Попробуйте отправить письмо еще раз. Если ошибка повторяется, пожалуйста, сообщите об этом в службу поддержки по адресу '. Yii::$app->params['supportEmail']);
            }
        }else{
            Yii::$app->session->setFlash('info', 'Все поля формы обязательны к заполнению. Если вы хотите получить ответ, укажите правильный email адрес.
            <br>Если вы обращаетесь к администрации по вопросам рекламы, в теме сообщения укажите "Реклама на сайте"');
        }

        return $this->render('contact2Form', ['model' => $model]);
    }

    /**
     * Поиск по сайту
     *
     * @return string
     */
    public function actionSearch() {
        $posts = [];
        $date = date('Y-m-d H:i:s');
        $searchModel = new SearchForm();
        if ($searchModel->load(Yii::$app->request->post()) && $searchModel->validate()) {
            $posts = Post::find()
                ->select("*, MATCH(short, full, title, meta_title) AGAINST('$searchModel->story') as rel")
                ->where("MATCH(short, full, title, meta_title) AGAINST('$searchModel->story')")
                ->andWhere(['approve' => Post::APPROVED])
                ->andWhere(['category_art' => 0])
                ->orderBy(['rel' => SORT_DESC])
                ->limit(20)
                ->all();
        }

        return $this->render('@app/views/post/search', ['searchModel' => $searchModel, 'posts' => $posts]);
    }

    /**
     * Возвращает XML c заголовком application/xml
     *
     * Любой запрос типа http://site.ru/<имя_файла>.xml перенаправляется сюда.
     * В зависимости от имени файла вызывается соответствующий метод, который должен генерировать и возвращать
     * содержимое в формате XML.
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionXml() {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
        $response->getHeaders()->set('Content-Type', 'application/xml; charset=utf-8');

        $xmlFileName = Yii::$app->request->get('xmlname');
        switch($xmlFileName) {
            case 'sitemap': $xml = $this->getSitemap(); break;
            case 'rss': $xml = $this->getRss(); break;
            case 'browserconfig': $xml = $this->getBrowserconfig(); break;
            default: throw new NotFoundHttpException('Страница не найдена. Проверьте правильно ли вы скопировали или ввели адрес в адресную строку. Если вы перешли на эту страницу по ссылке с данного сайта, сообщите пожалуйста о неработающей ссылке нам с помощью обратной связи.');
        }

        return $xml;
    }

    /**
     * Возвращает xml-содержимое RSS ленты
     *
     * @return mixed|string
     */
    public function getRss() {
        $rss = Yii::$app->cache->get('rss_xml');
        if(!$rss) {
            $rss = $this->generateRss();
            Yii::$app->cache->set('rss_xml', $rss, 43200);
        }
        return $rss;
    }

    /**
     * Генерирует xml-содержимое RSS ленты
     *
     * @return string
     */
    public function generateRss() {
        $siteUrl = Yii::$app->params['frontendBaseUrl'];
        $rss = '<?xml version="1.0" encoding="UTF-8"?>
        <rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
        <channel>
        <title>' . Yii::$app->params['site']['title'] . '</title>
        <link>' . $siteUrl . '</link>
        <description>' . Yii::$app->params['site']['description'] . '</description>
        <copyright>' . Yii::$app->params['site']['shortTitle'] . '</copyright>
        <language>ru</language>
        <managingEditor>' . Yii::$app->params['feedbackEmail'] . ' (Elena Bessonova)</managingEditor>
        <webMaster>' . Yii::$app->params['supportEmail'] . ' (Sergey Bessonov)</webMaster>
        <atom:link href="'.$siteUrl.'rss.xml" rel="self" type="application/rss+xml" />
        ';

        $posts = Post::find()
            ->where(['approve' => Post::APPROVED])
            ->andWhere(['allow_main' => 1])
            ->andWhere(['<=', 'date', date("Y-m-d H:i:s")])
            ->orderBy(['date' => SORT_DESC])
            ->limit(10)
            ->all();

        $data = '';
        foreach($posts as $post) {
            $absoluteLink = $siteUrl.substr($post->link, 1);
            $data.="<item>";
            $data.="<title>" . $post->title . "</title>";
            $data.="<link>" . $absoluteLink . "</link>";
            $data.="<description><![CDATA[<div align=\"justify\">
	" . $post->short . "<br /><br />
	<a style=\"float: right;\" href=\"" . $absoluteLink . "\">Прочитать полностью на сайте " . Yii::$app->params['site']['shortTitle'] . "</a>
	<br style='clear: both; display: block; content: \"\";' />
	<hr />
	</div>]]></description>";
            $data.="<guid>".$absoluteLink."</guid>";
            //$data.="<dc:creator>admin</dc:creator>";
            //$data.="<dc:date>" . date("D, j M Y G:i:s", strtotime($post->date)) . " GMT</dc:date>";
            $data.="<pubDate>".date("D, j M Y G:i:s", strtotime($post->date)-10800)." GMT</pubDate>\n</item>";
        }

        $rss .= $data . '</channel></rss>';

        return $rss;
    }

    /**
     * Возвращает xml-содержимое для файта browserconfig.xml, используемого новыми браузерами Microsoft
     *
     * @return string
     */
    public function getBrowserconfig() {
        return '<?xml version="1.0" encoding="utf-8"?>
<browserconfig>
  <msapplication>
    <tile>
      <square70x70logo src="/bw15/images/tiles/smalltile.png"/>
      <square150x150logo src="/bw15/images/tiles/mediumtile.png"/>
      <wide310x150logo src="/bw15/images/tiles/widetile.png"/>
      <square310x310logo src="/bw15/images/tiles/largetile.png"/>
      <TileColor>#FFC1B4</TileColor>
    </tile>
  </msapplication>
</browserconfig>';
    }

    /**
     * Возвращает XML карту сайта
     *
     * Карта берется из кэша, в котором она хранится 12 часов. Если в кэше ее нет, генерируется новая.
     *
     * @return mixed|string
     */
    public function getSitemap(){
        $xml_map = Yii::$app->cache->get('sitemap_xml');
        if(!$xml_map) {
            $xml_map = $this->generateSitemap();
            Yii::$app->cache->set('sitemap_xml', $xml_map, 43200);
        }
        return $xml_map;
    }

    /**
     * Генерация XML карты сайта
     *
     * @return string
     */
    public function generateSitemap() {
        $xml_map = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        // Главная страница
        $xml_map .= "
		<url>
			<loc>" . Yii::$app->params['frontendBaseUrl'] . "</loc>
			<lastmod>" . date("Y-m-d") . "</lastmod>
			<changefreq>daily</changefreq>
			<priority>1.0</priority>
		</url>";
        // Категории
        $categories = GlobalHelper::getCategories();
        foreach($categories as $mass)		// Добаление категорий
        {
            $id = $mass['id'];
            $xml_name = GlobalHelper::getCategoryUrlById($id);
            $xml_date = date("Y-m-d");
            $xml_map .= "
		<url>
			<loc>" . Yii::$app->params['frontendBaseUrl'] . $xml_name . "/</loc>
			<lastmod>" . $xml_date . "</lastmod>
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
		</url>";
        }
        // Статьи
        $posts = Post::find()
            ->where(['approve' => '1'])
            ->andWhere(['<=', 'date', date('Y-m-d')])
            ->andWhere(['!=', 'category_art', 1])
            ->orderBy('date')
            ->all();

        //var_dump($posts);
        foreach($posts as $post) {
            $xml_map .= "
		<url>
			<loc>" . $post->absoluteLink . "</loc>
			<lastmod>" . date("Y-m-d", strtotime($post->date)) . "</lastmod>
			<changefreq>weekly</changefreq>
			<priority>0.6</priority>
		</url>";
        }

        $xml_map .= "
</urlset>";

        return $xml_map;
    }


    /**
     * CallBack метод для oAuth авторизации через внешние сервисы
     *
     * @param $client
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        // VK
        if($client instanceof \yii\authclient\clients\VKontakte)
        {
            $auth_params = $client->getAccessToken()->getParams();
            $email = ArrayHelper::getValue($auth_params,'email','');
            // Аватарка из VK да ПОБОЛЬШЕ!!!
            $vk_data_response = $client->api('users.get','POST',['uids'=>  $attributes['id'] , 'fields'=> 'photo_max_orig']);
            if($vk_data_response = ArrayHelper::getValue($vk_data_response,'response',false))
            {
                $vk_data = array_shift($vk_data_response);
            }
            $userInfo['source_id'] = $attributes['id'];
            $userInfo['username'] = ($attributes['screen_name']) ? $attributes['screen_name'] : GlobalHelper::usernameFromEmail($attributes['email']);
            $userInfo['email'] = $attributes['email'];
            $userInfo['name'] = $attributes['first_name'];
            $userInfo['surname'] = $attributes['last_name'];
            $userInfo['birth_date'] = date('Y-m-d', strtotime($attributes['bdate']));
            $userInfo['sex'] = ($attributes['sex'] == 2) ? 'm' : 'f';
        }
        // YANDEX
        if($client instanceof \yii\authclient\clients\YandexOAuth){
            $userInfo['source_id'] = $attributes['id'];
            $userInfo['username'] = ($attributes['login']) ? $attributes['login'] : GlobalHelper::usernameFromEmail($attributes['emails'][0]);
            $userInfo['email'] = $attributes['emails'][0];
            $userInfo['name'] = $attributes['first_name'];
            $userInfo['surname'] = $attributes['last_name'];
            $userInfo['birth_date'] = $attributes['birthday'];
            $userInfo['sex'] = ($attributes['sex'] == 'male') ? 'm' : 'f';
        }
        // FACEBOOK
        if($client instanceof \yii\authclient\clients\Facebook) {
            //var_dump($attributes); die();
            $userInfo['source_id'] = $attributes['id'];
            $userInfo['username'] = GlobalHelper::usernameFromEmail($attributes['email']);
            $userInfo['email'] = $attributes['email'];
            $userInfo['name'] = $attributes['name'];
            $userInfo['surname'] = '';
            $userInfo['birth_date'] = '';
            $userInfo['sex'] = '';
        }
        // GOOGLE
        if($client instanceof \yii\authclient\clients\GoogleOAuth) {
            //var_dump($attributes); die();
            $userInfo['source_id'] = $attributes['id'];
            $userInfo['username'] = GlobalHelper::usernameFromEmail($attributes['emails'][0]["value"]);
            $userInfo['email'] = $attributes['emails'][0]["value"];
            $userInfo['name'] = $attributes['name']["givenName"];
            $userInfo['surname'] = $attributes['name']["familyName"];
            $userInfo['birth_date'] = '';
            $userInfo['sex'] = ($attributes['gender'] == 'male') ? 'm' : 'f';
        }
        // MAIL.RU
        if($client instanceof \frontend\components\auth\Mailru) {
            //var_dump($attributes[0]); die();
            $userInfo['source_id'] = $attributes['id'];
            $userInfo['username'] = GlobalHelper::usernameFromEmail($attributes[0]['email']);
            $userInfo['email'] = $attributes[0]["email"];
            $userInfo['name'] = $attributes[0]["first_name"];
            $userInfo['surname'] = $attributes[0]["last_name"];
            $userInfo['birth_date'] = date('Y-m-d', strtotime($attributes[0]["birthday"]));
            $userInfo['sex'] = ($attributes[0]["sex"] == 0) ? 'm' : 'f';
        }
        /*// ODNOKLASSNIKI
        if($client instanceof \frontend\components\auth\Odnoklassniki) {
            var_dump($attributes); die();
            $userInfo['source_id'] = $attributes['uid'];
            $userInfo['username'] = GlobalHelper::usernameFromEmail($attributes[0]['email']);
            if($attributes['has_email']) $userInfo['email'] = $attributes[0]["email"];
            $userInfo['name'] = $attributes["first_name"];
            $userInfo['surname'] = $attributes["last_name"];
            $userInfo['birth_date'] = $attributes["birthday"];
            $userInfo['sex'] = ($attributes["gender"] == 'male') ? 'm' : 'f';
        }*/

        if(!isset($userInfo['email']) || empty($userInfo['email'])){
            throw new BadRequestHttpException('Не удалось получить email адрес');
        }

        /* @var $auth Auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // авторизация
                $user = $auth->user;
                Yii::$app->user->login($user);
                Yii::$app->session->setFlash('success', 'Вход произведен. Теперь вы можете использовать все дополнительные возможности сайта.');
            } else { // регистрация
                if (isset($userInfo['email']) && User::find()->where(['email' => $userInfo['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "Пользователь с электронной почтой как в <strong>{client} (".$userInfo['email'].")</strong> уже существует, но не связан с этим аккаунтом. Вероятно, вы уже регистрировались на нашем сайте с помощью другой социальной сети, к которой привязан email <strong>".$userInfo['email']."</strong>, или с использованием классического способа регистрации.
                        Для входа на сайт используйте тот сервис, который вы использовали в первый раз. Если это невозможно, перейдите <a href='/site/request-password-reset'>на эту страницу</a> и пройдите процедуру восстановления доступа, указав email <strong>".$userInfo['email']."</strong>. На этот адрес будет отправлено письмо с дальнейшими действиями. После восстановления доступа вы сможете привязать
                        к своему аккаунту любую из социальных сетей и далее входить на сайт в один клик.", ['client' => $client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $userInfo['username'],
                        'email' => $userInfo['email'],
                        'password' => $password,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    $transaction = $user->getDb()->beginTransaction();
                    if ($user->save()) {
                        $profile = new UserProfile();
                        $profile->user_id = $user->id;
                        $profile->name = $userInfo['name'];
                        $profile->surname = $userInfo['surname'];
                        $profile->birth_date = $userInfo['birth_date'];
                        if(isset($userInfo['sex'])){
                            $profile->sex = $userInfo['sex'];
                        }
                        $profile->save();

                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$userInfo['source_id'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Вход на сайт произведен. Для вас была автоматически создана учетная запись. Информация о ней отправлена на ваш email (<strong>('.$userInfo['email'].')</strong>). В дальнейшем вы можете входить на сайт как с помощью {client}, так и с помощью своего логина и пароля.');
                            Yii::$app->user->login($user);
                        } else {
                            print_r($auth->getErrors());
                        }
                    } else {
                        print_r($user->getErrors());
                    }
                }
            }
        } else { // Пользователь уже зарегистрирован
            if($auth->user_id != Yii::$app->user->getId()){ // Если аккаунт привязан к другому пользователю
                Yii::$app->session->setFlash('error', 'Данный аккаунт '.$client->getTitle().' привязан к учетной записи другого пользователя сайта. Привязать аккаунт к двум учетным записям невозможно.');
            } else {
                Yii::$app->session->setFlash('info', 'Данный аккаунт '.$client->getTitle().' уже привязан к вашей учетной записи.');
            }
            if (!$auth) { // добавляем внешний сервис аутентификации
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }

    /**
     * Возвращает URL последней просмотренной страницы
     * @return mixed
     */
    public function getPreviosUrl(){
        return ($url = Yii::$app->session->get('previosUrl')) ? $url : Yii::$app->params['frontendBaseUrl'];
    }

}
