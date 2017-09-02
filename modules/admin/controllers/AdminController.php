<?php

namespace app\modules\admin\controllers;


use app\forms\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class AdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout'],
                'rules' => [
                    [
                        //'actions' => ['logout'],
//                        'allow' => Yii::$app->user->identity->role_id >= Role::ROLE_ADMIN ,
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login-admin'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Login action.
     *
     * @return string
     */
    public function actionLoginAdmin()
    {
        $this->layout = 'main-login.php';
        if (!Yii::$app->user->isGuest) {
            //return $this->goHome();
            return $this->redirect(Url::to('/admin/default'));
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::to('/admin/default'));
        }
        return $this->render('login-admin', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionClearCash()
    {
        if (Yii::$app->cache->flush()) {
            Yii::$app->getSession()->addFlash('success', "Кэш обновлен.");
        } else {
            Yii::$app->getSession()->addFlash('danger', "Обновить кэш не удалось. Попробуйте еще раз.");
        }

        // Url::remember(); in admin\views\layouts\left.php
        $this->redirect([Url::previous()]);
    }


    public function actionYesNo($id, $property = 'visible')
    {

        $model = $this->findModel($id);

        if ($model) {
            $model->$property = Yii::$app->request->post('data');
            $model->save();

            return json_encode(['success' => true]);
        }
        return json_encode(['success' => false]);
    }

}//AdminController