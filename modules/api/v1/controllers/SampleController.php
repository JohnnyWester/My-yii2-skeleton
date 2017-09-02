<?php

namespace app\modules\api\v1\controllers;


use yii\rest\Controller;

class SampleController extends Controller
{
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
        return 'index';
    }

    public function actionSuccess()
    {
        return 'success';
    }//optionSuccess

    public function actionFailed()
    {
        return 'failed';
    }//optionFailed

}//SampleController