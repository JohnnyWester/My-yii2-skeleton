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
            0 => Yii::t('app', 'No'),
        ];
    }


    /**
     *
     * @return string
     */
    public static function renderYesNo($val)
    {
        if ($val === null) {
            $val = 0;
        }
        $label = self::getActiveOptions()[$val];
        if ($val) {
            return Html::tag('span', $label, [
                'class' => 'label label-success status-btn',
                'title' => Yii::t('app', 'Change'),
            ]
            );
        }

        return Html::tag('span', $label, [
            'class' => 'label label-danger status-btn',
            'title' => Yii::t('app', 'Change'),
        ]
        );
    }


    /**
     * @param $cntNumber int
     * @return int
     */
    public static function randomCode($cntNumber)
    {
        $cntNumber = (int)$cntNumber;
        $start = pow(10, $cntNumber - 1);
        $end = (int)str_pad(9, $cntNumber, 9);

        return mt_rand($start, $end);
    }//randomCode


    /**
     * @param array $errors
     * @return string
     */
    public static function getLastError(array $errors)
    {
        $message = '';
        foreach ($errors as $k => $v) {
            $message = $v[0];
            break;
        }

        return $message;
    }//getLastError


    public static function removeEmptyFromArray(array $array)
    {
        return array_filter($array, function ($item) {
            return !empty($item);
        }
        );

    }//removeEmptyFromArray


    public static function removeDenyFields(array $arr, array $denyFields)
    {
        return array_diff_key($arr, array_flip($denyFields));
    }//removeDenyFields


}//Utils