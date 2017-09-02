<?php

namespace app\modules\admin\controllers;


class TestController extends AdminController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}//TestController