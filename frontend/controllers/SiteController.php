<?php
namespace frontend\controllers;

use app\models\Contact2Form;
use common\models\User;
use frontend\models\ConfirmEmailForm;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
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


    public function actionContact2()
    {
        $model = new Contact2Form();

        if($model->load(Yii::$app->request->post()) && $model->validate())
        {
            Yii::$app->session->setFlash('success', 'Данные введены верно');
        }else{
            Yii::$app->session->setFlash('info', 'Все поля формы обязательны к заполнению. Если вы хотите получить ответ, укажите правильный email адрес.
            <br>Если вы обращаетесь к администрации по вопросам рекламы, в теме сообщения укажите "Реклама на сайте"');
        }

        return $this->render('contact2Form', ['model' => $model]);
    }

}
