<?php

namespace app\modules\api\v1\controllers;

use app\models\User;
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


    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');
        $user = User::findOne($id)->username;
        return ['user' => $user];
    }


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


    public function actionFailed()
    {
        return 'failed';
    }//optionFailed

}//SampleController