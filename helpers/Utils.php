<?php

namespace app\helpers;

use Yii;
use yii\helpers\Html;

class Utils
{
    public static function trimArray($arr)
    {
        foreach ($arr as &$item) {
            $item = trim($item);
        }
        return $arr;
    }//trimArray

    /**
     *
     * @return array
     */
    public static function getActiveOptions()
    {
        return [
            1 => Yii::t('app', 'Yes'),
            0 => Yii::t('app','No'),
        ];
    }


    /**
     *
     * @return string
     */
    public static function renderYesNo($val) {
        if ($val === null) {
            $val = 0;
        }
        $label = self::getActiveOptions()[$val];
        if ($val) {
            return Html::tag('span', $label, ['class' => 'label label-success status-btn', 'title' => Yii::t('app', 'Change')]);
        }
        return Html::tag('span', $label, ['class' => 'label label-danger status-btn', 'title' => Yii::t('app', 'Change')]);
    }


}//Utils