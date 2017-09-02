<?php

namespace app\modules\api\v1\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class SampleController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behaviors;
    }

    protected function verbs()
    {
        return [
            'index' => ['get'],
            'success' => ['post'],
            'failed' => ['get'],
        ];
    }


    /**
     * @apiDescription all User access
     *
     * This optional description for this api block.
     *
     * @api {get} /v1/sample Test Default Request
     * @apiName GetIndex
     * @apiGroup Default
     *
     * @apiSuccess {String} action Action name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "action":"index"
     *     }
     *
     * @apiError MethodNotAllowed Method Not Allowed.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 405 Method Not Allowed
     *    {
     *      "name": "Method Not Allowed",
     *      "message": "Method Not Allowed. This url can only handle the following request methods: GET.",
     *      "code": 0,
     *      "status": 405,
     *      "type": "yii\\web\\MethodNotAllowedHttpException"
     *    }
     */
    public function actionIndex()
    {
        return ['action' => 'index'];
    }


    /**
     * @apiDescription Success test sample method
     *
     *
     * @api {post} /v1/sample/success Request Success Method
     * @apiName PostSuccess
     * @apiGroup Sample
     *
     * @apiHeader {String} Authorization Users unique access-token.
     * @apiHeaderExample {json} Header-Example:
     * {
     *      "Authorization": "Bearer d1ud5yQnjO3eeg64ZkmYupwGh6fKZJ4W"
     * }
     *
     * @apiParam {Number} id Users unique ID.
     * @apiParam {String} [name="Name"]  Optional Firstname of the User.
     *
     * @apiSuccess {String} action Action name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "id": 5,
     *       "name": "Jon Doe"
     *     }
     *
     * @apiError BadRequest Invalid data.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *        "name": "Bad Request",
     *        "message": "Invalid data. Id must be send",
     *        "code": 10,
     *        "status": 400,
     *        "type": "yii\\web\\BadRequestHttpException"
     *     }
     */
    public function actionSuccess()
    {
        $params = Yii::$app->request->bodyParams;
        $id = (int)$params['id'];
        if (!$id) {
            throw new BadRequestHttpException('Invalid data. Id must be send', 10);
        }

        $name = $params['name'] ?? 'Name';
        $data = [
            'id' => $id,
            'name' => $name,
        ];
        return $data;
    }//optionSuccess


    /**
     * @apiDescription Failed test sample method
     *
     *
     * @api {get} /v1/sample/failed Request Failed Method
     * @apiName GetFailed
     * @apiGroup Sample
     *
     * @apiSuccess {String} action Action name.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "action":"index"
     *     }
     *
     * @apiError MethodNotAllowed Method Not Allowed.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 405 Method Not Allowed
     *    {
     *      "name": "Method Not Allowed",
     *      "message": "Method Not Allowed. This url can only handle the following request methods: GET.",
     *      "code": 0,
     *      "status": 405,
     *      "type": "yii\\web\\MethodNotAllowedHttpException"
     *    }
     */
    public function actionFailed()
    {
        return 'failed';
    }//optionFailed

}//SampleController