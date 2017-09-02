<?php

namespace app\modules\api\v1\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends Controller
{
    /**
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        throw new NotFoundHttpException('The requested resource was not found.');
    }
}
