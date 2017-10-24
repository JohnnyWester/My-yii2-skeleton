<?php

namespace app\helpers\check;


use app\repositories\IRepository;
use yii\web\BadRequestHttpException;

class AuthEmailCheck implements ICheckInputParams
{
    protected $userRep;
    protected $socialRep;

    public function __construct(IRepository $userRep, IRepository $socialRep)
    {
        $this->userRep = $userRep;
        $this->socialRep = $socialRep;
    }

    public function check(array $params)
    {
        $email = $params['email'];
        if (!$email) {
            throw new BadRequestHttpException('Invalid data. Email not send', 10);
        }
        /** @todo если в соцсетях есть такой email, будем присоединять соцсеть к новому пользователю */
        if ($this->userRep->isExist("email = '$email'") && !$this->socialRep->isExist("email = '$email'")) {
            throw new BadRequestHttpException('Invalid data. Email already exist', 10);
        }
        $pass = $params['password'];
        if (!$pass) {
            throw new BadRequestHttpException('Invalid data. Password not send', 10);
        }
        $name = $params['name'];
        $img = $params['img'];
        $tel = $params['tel'];

        return ['email' => $email, 'tel' => $tel, 'name' => $name, 'password' => $pass, 'img' => $img];

    }
}//AuthEmail