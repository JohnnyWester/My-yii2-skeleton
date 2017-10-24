<?php

namespace app\modules\api\v1\controllers;

use app\helpers\ApiResp;
use app\services\AuthService;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class AuthController extends Controller
{
    const TYPE_EMAIL  = 1;
    const TYPE_SOCIAL = 2;

    public static $registerTypes = [
        self::TYPE_EMAIL,
        self::TYPE_SOCIAL,
    ];

    protected function verbs()
    {
        return [
            'signup' => ['post'],
            'login'  => ['post'],
        ];
    }

    protected $authService;
    protected $apiResp;

    public function __construct($id, $module, AuthService $authService, ApiResp $apiResp, $config = [])
    {
        $this->authService = $authService;
        $this->apiResp = $apiResp;
        parent::__construct($id, $module, $config);
    }

    /**
     * @apiDescription Регистрация клиентов
     *
     * При регистрации через email, email - уникален.
     *
     * Если при регистрации через соцсеть email совпвдет с уже имеющимся, придет exception
     *
     * При регистрации через соцсети, provider_id и client_id обязательны.
     * В таблицу user добавляется отдельный пользователь.
     * Если уже существует такой client_id + provider, происходит ЛОГИН пользователя.
     *
     * При последующих входах, если совпадает email, пользователь считается одним и тем же
     * и его профили и все данные объединяются.
     *
     * @api {post} /v1/auth/signup Sign Up
     * @apiName PostSignup
     * @apiGroup Auth
     *
     *
     * @apiParam {Int} type           Метод регистрации(1 - email, 2 - соцсети)
     * @apiParam {Int} [provider_id]  Соцсеть(1 - GOOGLE, 2 - FACEBOOK, 3 - VK) если регистрация через соцсеть
     * @apiParam {String} [client_id] Токен клиента в соцсети
     * @apiParam {String} username    Имя клиента
     * @apiParam {String} password    Пароль клиента(НЕОБЯЗАТЕЛЕН при регистрации через соцсети)
     * @apiParam {String} email       Email клиента(НЕОБЯЗАТЕЛЕН при регистрации через соцсети)
     * @apiParam {String} [tel]       Телефон клиента
     * @apiParam {String} [city]      Город клиента
     * @apiParam {String} [img]       Url фото клиента
     *
     * @apiSuccess {Int} id              Id пользователя в базе
     * @apiSuccess {String} username     Имя пользователя
     * @apiSuccess {String} email        Email пользователя
     * @apiSuccess {String} access_token Токен доступа к api
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *        "id": 5,
     *        "username": "Test Email",
     *        "email": "test@test.com",
     *        "access_token": "kMfbANUvzLKihb16RseerhM5zoyLYdJF"
     *     }
     *
     * @apiError BadRequest Если переданы не все данные.
     *
     * @apiErrorExample Неправильные данные:
     *     HTTP/1.1 400 Bad Request
     *     {
     *        "name": "Bad Request",
     *        "message": "Invalid data",
     *        "code": 10,
     *        "status": 400,
     *        "type": "yii\\web\\BadRequestHttpException"
     *     }
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *        "name": "Bad Request",
     *        "message": "This email address has already been taken.",
     *        "code": 20,
     *        "status": 400,
     *        "type": "yii\\web\\BadRequestHttpException"
     *      }
     */
    public function actionSignup()
    {
        $params = Yii::$app->request->bodyParams;

        $type = $params['type'];
        if (!$type || !in_array($type, self::$registerTypes)) {
            throw new BadRequestHttpException('Invalid data. Not correct type', 10);
        }

        $res = null;
        if ($type == self::TYPE_EMAIL) {
            $res = $this->authService->emailRegister($params);
        } elseif ($type == self::TYPE_SOCIAL) {
            $res = $this->authService->socialRegister($params);
        }

        if (!$res) {
            throw new BadRequestHttpException('Error. New user not saved', 10);
        }

        return $this->apiResp->registered($res);
    }//actionSignup


    /**
     * @apiDescription Вход клиентов(Login)
     *
     * @api {post} /v1/auth/login Login
     * @apiName PostLogin
     * @apiGroup Auth
     *
     *
     * @apiParam {String} email Email клиента
     * @apiParam {String} password Пароль клиента
     *
     * @apiSuccess {Int}    id           Id пользователя в базе
     * @apiSuccess {String} username     Имя пользователя
     * @apiSuccess {String} email        Email пользователя
     * @apiSuccess {String} access_token Токен доступа к api
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *        "id": 5,
     *        "username": "Test Email",
     *        "email": "test@test.com",
     *        "access_token": "kMfbANUvzLKihb16RseerhM5zoyLYdJF"
     *     }
     *
     * @apiError BadRequest Если переданы не все данные.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *        "name": "Bad Request",
     *        "message": "Login failed",
     *        "code": 10,
     *        "status": 400,
     *        "type": "yii\\web\\BadRequestHttpException"
     *     }
     */
    public function actionLogin()
    {
        $params = Yii::$app->request->bodyParams;

        $res = $this->authService->Login($params);

        return $this->apiResp->login($res);

    }//actionLogin

}//AuthController