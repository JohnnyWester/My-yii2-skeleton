<?php

namespace app\repositories;

use app\models\SocialAccounts;

class SocialRepository extends DefaultIRepository
{
    public function __construct(SocialAccounts $model)
    {
        $this->model = $model;

        parent::__construct($model);
    }


    public function addSocial($user_id, $provider_id, $client_id, $username, $email, $img = null)
    {
        $this->model->user_id = $user_id;
        $this->model->provider_id = $provider_id;
        $this->model->client_id = $client_id;
        $this->model->username = $username;
        $this->model->email = $email;
        $this->model->img = $img;
        if ($this->model->save()) {
            return $this->model;
        }
        return false;
    }//addUser

}//SocialRepository