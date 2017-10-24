<?php

namespace app\helpers\check;


use app\models\SocialProviders;
use app\repositories\IRepository;
use yii\web\BadRequestHttpException;

class AuthSocialCheck implements ICheckInputParams
{
    protected $socialRep;

    public function __construct(IRepository $socialRep)
    {
        $this->socialRep = $socialRep;
    }

    public function check(array $params)
    {
        $provider_id = (int)$params['provider_id'];
        if (!$provider_id || !in_array($provider_id, SocialProviders::$providers)) {
            throw new BadRequestHttpException('Invalid data. Provider_id not send or incorrect', 10);
        }

        $client_id = $params['client_id'];
        if (!$client_id) {
            throw new BadRequestHttpException('Invalid data. Client_id not send', 10);
        }

        $username = $params['username'];
        $email = $params['email'] ?: '';
        $img = $params['img'] ?: null;

        return [
            'provider_id' => $provider_id,
            'client_id'   => $client_id,
            'username'    => $username,
            'email'       => $email,
            'img'         => $img,
        ];

    }


}//AuthSocialCheck