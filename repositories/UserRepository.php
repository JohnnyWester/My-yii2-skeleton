<?php

namespace app\repositories;

use app\helpers\Utils;
use app\models\Role;
use app\models\User;
use app\models\Verify;
use Assert\Assertion;
use Yii;
use yii\web\BadRequestHttpException;

class UserRepository extends DefaultIRepository
{

    const SENDER   = 1;
    const TRAVELER = 2;

    public function __construct(User $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }


    /**
     * @param array $params
     * @param null $registerType
     * @return User|bool
     * @throws BadRequestHttpException
     */
    public function addUser(array $params, $registerType = null)
    {
        $this->model->username = $params['username'] ?: null;
        $this->model->email = $params['email'];
        $this->model->tel = $params['tel'] ?: null;
        $this->model->setPassword($params['password']);
        $this->model->img = $params['img'] ?: null;
        $this->model->role_id = Role::USER;
        $this->model->generateAuthKey();
        $this->model->generateAccessToken();

        if (!$this->model->validate()) {

            throw new BadRequestHttpException(Utils::getLastError($this->model->errors), 20);
        }

        if ($this->model->save()) {
            return $this->model;
        }

        return false;
    }//addUser


    /**
     * @param User $model
     * @param $params
     * @return User|bool
     */
    public function editUser(User $model, $params)
    {
        $model->username = $params['name'] ?: $model->username;
        $model->email = $params['email'] ?: $model->email;
        $model->tel = $params['tel'] ?: $model->tel;


        if ($params['old_password'] && $params['new_password']) {
            if (!$model->validatePassword($params['old_password'])) {
                throw new \DomainException('Invalid old password');
            }
            $model->setPassword($params['new_password']);
        }


        $model->img = $params['img'] ?: $model->img;

        if ($model->save()) {
            return $model;
        }

        return false;
    }//addUser


    public function findByEmail($email)
    {
        return User::findByEmail($email);
    }//findByEmail


    public function setPasswordResetToken(User $user, $code)
    {
        $user->password_reset_token = $code;

        return $user->save();
    }//setPasswordResetToken


}//UserRepository