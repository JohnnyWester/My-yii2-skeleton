<?php

namespace app\helpers;

use Yii;
use yii\helpers\Url;

class ImageHelper
{

    /**
     * @param string $filename
     * @return string Полный URL до файла
     */
    public static function getImgUrl($filename)
    {
        str_replace(['http', 'https',], '', $filename, $count);
        // если файл локальный, проверить его существование

        return $count ? $filename : Url::to('/', true) . Yii::$app->params['UPLOAD_IMG_PATH'] . $filename;
    }


    public static function getDefaultUserPhoto()
    {
        $defaultName = 'default_user.jpg';
        return Url::to(['@web/img/' . $defaultName]);
    }


    public static function addModelImg($model)
    {
        $image = $model->getImage();
        $url = Url::to([$image->getUrl()], true);
        return $url;
    }//addModelImg

    public static function addModelImgNotPlaceholder($model)
    {
        $image = $model->getImage();
        $imgUrl = $image->getUrl();
        $url = Url::to([$imgUrl], true);
        parse_str ($url, $res);
        if ($res['dirtyAlias'] == 'placeHolder.png') {
            $url = '';
        }

        return $url;
    }//addModelImgNotPlaceholder

}//ImageHelper