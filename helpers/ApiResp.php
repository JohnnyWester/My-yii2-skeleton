<?php

namespace app\helpers;

use app\models\PackageImage;
use app\models\PackageResponse;
use app\models\User;
use app\repositories\PackageImgRepository;
use app\repositories\PackageResponseRepository;
use app\repositories\UserRepository;
use app\transformers\BalanceTransformer;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ApiResp
{
    const SUCCESS = 'success';
    const FAILED  = 'failed';

    public function registered(User $user)
    {
        $response = [
            "id"           => $user->id,
            "username"           => $user->username,
            "email"           => $user->email,
            "access_token" => $user->access_token,
        ];

        return $response;
    }//register


    public function login(User $user)
    {
        $response = [
            "id"           => $user->id,
            "username"           => $user->username,
            "email"           => $user->email,
            "access_token" => $user->access_token,
        ];

        return $response;
    }//login




    public function editProfile($res)
    {
        $response = self::FAILED;
        if ($res) {
            $response = [
                "id"           => $res->id,
                "type_id"      => (int)$res->type_id,
                "access_token" => $res->access_token,
                "username"     => $res->username,
                "email"        => $res->email,
                "tel"          => $res->tel ?: '',
                "img"          => $res->img ?: '',
                "city"         => $res->city ?: '',
                "login_type"   => $res->login_type,

            ];
        }

        return $response;
    }//editUserType



    public function responseTruFalse($res)
    {
        $resp = $res;

        return ['success' => $resp ? true : false];
    }//responseTruFalse

}//ApiResp