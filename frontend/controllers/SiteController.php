<?php
namespace frontend\controllers;

use app\components\GlobalHelper;
use app\components\TemporaryUnavailableException;
use app\models\Contact2Form;
use common\models\User;
use frontend\models\ConfirmEmailForm;
use frontend\models\Post;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\ErrorException;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\MethodNotAllowedHttpException;

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
                    var_dump(Yii::$app->request->userIP);
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
            return $this->goBack();
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

        return $this->goHome();
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
                return $this->goHome();
                // Было раньше
                /*if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }*/
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

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionConfirmEmail($token = 'none'){
        if(Yii::$app->user->identity->status == User::STATUS_ACTIVE){
            return $this->goHome();
        }
        $model = new ConfirmEmailForm($token);
        if($model->userFound){
            if($model->activateUser()) {
                Yii::$app->session->setFlash('success', 'Ваш Email адрес подтвержден. Теперь вы можете пользоваться всеми функциями, доступными для авторизованных пользователей сайта.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка.');
            }
        } elseif($token != 'none') {
            Yii::$app->session->setFlash('error', 'Код подтверждения не найден или не является разрешенным к использованию.');
        }

        return $this->render('confirmEmail', ['model' => $model]);
    }


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
     * Выводит XML карту сайта
     *
     * Карта берется из кэша, в котором она хранится 12 часов. Если в кэше ее нет, генерируется новая.
     *
     * @return mixed|string
     */
    public function actionSitemap(){

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
			<loc>" . Yii::$app->params['frontendUrl'] . "</loc>
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
			<loc>" . Yii::$app->params['frontendUrl'] . $xml_name . "/</loc>
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
            ->with('categories')
            ->all();

        //var_dump($posts);
        foreach($posts as $post) {
            $xml_map .= "
		<url>
			<loc>" . substr(Yii::$app->params['frontendUrl'],0,-1) . $post->link . "</loc>
			<lastmod>" . date("Y-m-d", strtotime($post->date)) . "</lastmod>
			<changefreq>weekly</changefreq>
			<priority>0.6</priority>
		</url>";
        }

        $xml_map .= "
</urlset>";

        return $xml_map;
    }

}
