<?php

namespace app\repositories;

use app\models\Role;
use app\models\User;

class UserRepository extends DefaultIRepository
{

    public function __construct(User $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }


    /**
     * @param array $params
     * @return User|bool
     */
    public function addUser(array $params)
    {
        $this->model->username = $params['name'] ?: null;
        $this->model->email = $params['email'];
        $this->model->tel = $params['tel'] ?: null;
        $this->model->setPassword($params['password']);
        $this->model->img = $params['img'] ?: null;
        $this->model->role_id = Role::CLIENT;
        $this->model->generateAuthKey();
        $this->model->generateAccessToken();

        $this->model->gender = $params['gender'] ?: null;
        $this->model->height = $params['height'] ?: null;
        $this->model->weight = $params['weight'] ?: null;
        $this->model->target = $params['target'] ?: null;

        if ($this->model->save()) {
            return $this->model;
        }

        return false;
    }//addUser


    public function editUser(User $client, $params)
    {
        $client->username = $params['name'] ?: $client->username;
        $client->email = $params['email'] ?: $client->email;
        $client->tel = $params['tel'] ?: $client->tel;
        if ($params['password']) {
            $client->setPassword($params['password']);
        }
        $client->img = $params['img'] ?: $client->img;

        $client->gender = $params['gender'] ?: $client->gender;
        $client->height = $params['height'] ?: $client->height;
        $client->weight = $params['weight'] ?: $client->weight;
        $client->target = $params['target'] ?: $client->target;

        if ($client->save()) {
            return $client;
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