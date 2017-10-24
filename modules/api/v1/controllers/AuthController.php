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
     * При регистрации через соцсети, provider_id и client_id обязательны.
     * В таблицу user добавляется отдельный пользователь.
     * Если уже существует client_id, происходит логин пользователя.
     *
     * При последующих входах, если совпадает email, пользователь считается одним и тем же
     * и его профили и все данные объединяются.
     *
     * @api {post} /v1/auth/signup Sign Up
     * @apiName PostSignup
     * @apiGroup Auth
     *
     *
     * @apiParam {Int} type Метод регистрации(1 - email, 2 - соцсети)
     * @apiParam {Int} [provider_id] Соцсеть(1 - GOOGLE, 2 - FACEBOOK) если регистрация через соцсеть
     * @apiParam {String} [client_id] Токен клиента в соцсети
     * @apiParam {String} [name] Имя клиента
     * @apiParam {String} password Пароль клиента(НЕОБЯЗАТЕЛЕН при регистрации через соцсети)
     * @apiParam {String} email Email клиента(НЕОБЯЗАТЕЛЕН при регистрации через соцсети)
     * @apiParam {String} [tel] Телефон клиента
     * @apiParam {String} [img] Url фото клиента
     *
     *
     * @apiSuccess {Int} id Id пользователя в базе
     * @apiSuccess {Int} role Роль пользователя (GUEST - 1; CLIENT - 2; TRAINER - 3; DOCTOR - 4; ADMIN - 5; DEVELOPER - 10;)
     * @apiSuccess {String} access_token Токен доступа к api
     * @apiSuccess {String} name Имя клиента
     * @apiSuccess {String} email Email клиента
     * @apiSuccess {String} gender Пол клиента(1 - мужской, 2 - женский)
     * @apiSuccess {Float} height Рост клиента
     * @apiSuccess {Float} weight Вес клиента
     * @apiSuccess {Float} target Вес-цель клиента
     * @apiSuccess {String} img Фото клиента
     * @apiSuccess {String} tel Телефон клиента
     * @apiSuccess {Int} created Дата создания профиля
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *        "id": 16,
     *        "role": 2,
     *        "access_token": "X3NfAiafjRbHDtAGcfHvtweD0HryP5UR",
     *        "name": "Name3",
     *        "email": "test@test.com",
     *        "tel": "+380671112256",
     *        "img": "",
     *        "gender": 1,
     *        "height": 180.5,
     *        "weight": 90.5,
     *        "target": 80,
     *        "created": 1504783967
     *      }
     *
     * @apiError BadRequest Если переданы не все данные.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *        "name": "Bad Request",
     *        "message": "Invalid data",
     *        "code": 10,
     *        "status": 400,
     *        "type": "yii\\web\\BadRequestHttpException"
     *     }
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
     * @apiSuccess {Int} id Id пользователя в базе
     * @apiSuccess {Int} role Роль пользователя (GUEST - 1; CLIENT - 2; TRAINER - 3; DOCTOR - 4; ADMIN - 5; DEVELOPER - 10;)
     * @apiSuccess {String} access_token Токен доступа к api
     * @apiSuccess {String} name Имя клиента
     * @apiSuccess {String} email Email клиента
     * @apiSuccess {String} gender Пол клиента(1 - мужской, 2 - женский)
     * @apiSuccess {Float} height Рост клиента
     * @apiSuccess {Float} weight Вес клиента
     * @apiSuccess {Float} target Вес-цель клиента
     * @apiSuccess {String} img Фото клиента
     * @apiSuccess {String} tel Телефон клиента
     * @apiSuccess {Int} created Дата создания профиля
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *        "id": 16,
     *        "role": 2,
     *        "access_token": "X3NfAiafjRbHDtAGcfHvtweD0HryP5UR",
     *        "name": "Name3",
     *        "email": "test@test.com",
     *        "tel": "+380671112256",
     *        "img": "",
     *        "gender": 1,
     *        "height": 180.5,
     *        "weight": 90.5,
     *        "target": 80,
     *        "created": 1504783967
     *      }
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