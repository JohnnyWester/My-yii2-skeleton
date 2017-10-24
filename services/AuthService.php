<?php

namespace app\services;


use app\helpers\check\AuthEmailCheck;
use app\helpers\check\AuthSocialCheck;
use app\models\User;
use app\repositories\SocialRepository;
use app\repositories\UserRepository;
use yii\web\BadRequestHttpException;

class AuthService
{
    protected $userRep;
    protected $socialRep;

    public function __construct(UserRepository $userRep, SocialRepository $socialRep)
    {
        $this->userRep = $userRep;
        $this->socialRep = $socialRep;
    }


    /**
     * @param $params
     * @return \app\models\User|bool
     * @throws BadRequestHttpException
     */
    public function emailRegister($params)
    {
        $tester = new AuthEmailCheck($this->userRep, $this->socialRep);
        $res = $tester->check($params);

        /** @todo если в соцсетях есть такой email переподключаем на нового юзера */
        if ($social = $this->socialRep->get('*', ['email' => $res['email']])) {
            // старый клиент
            $oldUser = User::findOne($social->user_id);
            $oldUser->email = '';
            $oldUser->save();

            $newUser = $this->userRep->addUser($params);

            $social->user_id = $newUser->id;
            $social->save();

            /** @TODO ВСЕ ОСТАЛЬНЫЕ ДАННЫЕ ПЕРЕКЛЮЧИТЬ НА НОВОГО ЮЗЕРА*/

            /** @удаляем рандомно созданного для соцсети пользователя */
            $oldUser->delete();
        } else {
            $newUser = $this->userRep->addUser($params);

        }

        return $newUser;
    }//emailRegister


    /**
     * @param $params
     * @return \app\models\User|bool
     * @throws BadRequestHttpException
     */
    public function socialRegister($params)
    {
        $tester = new AuthSocialCheck($this->socialRep);
        $res = $tester->check($params);

        /** @TODO проверить client_id и provider_id, если есть - ЭТО ЛОГИН, отдаем новый токен */
        if ($social = $this->socialRep->get('*', ['client_id' => $res['client_id'], 'provider_id' => $res['provider_id']])) {
            // get user
            $client = $this->userRep->get('*', 'id = ' . $social->user_id);

            // generate new token
            $client->generateAccessToken();
            $client->save();

            // return user
            return $client;
        }


        /** @TODO Проверить почту. Если есть, привязываем к юзеру соцсеть */
        if (!$newUser = User::findByEmail($res['email'])) {
            // по email нет  совпадений, регистрируем нового пользователя
            $params['password'] = 'social' . $res['client_id'];
            $newUser = $this->userRep->addUser($params);
        }

        // заполнить social
        if ($newUser) {
            if (!$social = $this->socialRep->addSocial($newUser->id, $res['provider_id'], $res['client_id'], $res['name'], $res['email'], $res['img'])) {
                /** @todo если это новый юзер, а не старый к которому привязываем соцсеть, удаляем его */
                if ($newUser->validatePassword('social' . $res['client_id'])) {
                    $this->userRep->delete('id = ' . $newUser->id);
                }
                throw new BadRequestHttpException('Error. New user not saved', 10);
            }
        }

        return $newUser;
    }//socialRegister


    public function Login($params)
    {
        $email = $params['email'];
        $password = $params['password'];
        if (!$email || !$password) {
            throw new BadRequestHttpException('Invalid data. email and password are required', 10);
        }

        $client = User::findByEmail($email);
        if (!$client || !$client->validatePassword($password)) {
            throw new BadRequestHttpException('Login failed', 10);
        }

        $client->generateAccessToken();
        $client->save();

        return $client;
    }//Login

}//AuthService