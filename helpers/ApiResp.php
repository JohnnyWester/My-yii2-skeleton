<?php

namespace app\helpers;

use app\models\Dishes;
use app\models\FoodsType;
use app\models\User;
use app\models\UserComplexStatus;
use app\modules\api\v1\models\Client;
use Yii;
use yii\helpers\Url;

class ApiResp
{
    public function registered(User $user)
    {
        $response = [
            "id"           => $user->id,
            "role"         => $user->role_id,
            "access_token" => $user->access_token,
            "name"         => $user->username,
            "email"        => $user->email,
            "tel"          => $user->tel ?: '',
            "img"          => $user->img ?: '',
            "gender"       => $user->gender ?: 0,
            "height"       => $user->height ?: 0,
            "weight"       => $user->weight ?: 0,
            "target"       => $user->target ?: 0,
            "created"      => $user->created_at ?: '',
        ];

        return $response;
    }//register


    public function login(User $user)
    {
        $response = [
            "id"           => $user->id,
            "role"         => $user->role_id,
            "access_token" => $user->access_token,
            "name"         => $user->username,
            "email"        => $user->email,
            "tel"          => $user->tel ?: '',
            "img"          => $user->img ?: '',
            "gender"       => $user->gender ?: 0,
            "height"       => $user->height ?: 0,
            "weight"       => $user->weight ?: 0,
            "target"       => $user->target ?: 0,
            "created"      => $user->created_at ?: '',
        ];

        return $response;
    }//login


    public function clientProfile(Client $client)
    {
        $response = [
            "id"      => Yii::$app->user->id,
            "role"    => $client->role_id,
            "name"    => $client->username,
            "email"   => $client->email,
            "gender"  => $client->gender ?: 0,
            "height"  => $client->height ?: 0,
            "weight"  => $client->weight ?: 0,
            "target"  => $client->target ?: 0,
            "img"     => $client->img ?: '',
            "tel"     => $client->tel ?: '',
            "created" => $client->created_at,
        ];

        return $response;
    }//clientProfile


    public function clientsWeight($weights)
    {
        return $weights;
    }//clientsWeight


    public function dishes($dishes, $one = false)
    {
        $resp = [
            [
                "category_id"   => 1,
                "category_name" => t("Breakfast"),
                "img"           => ImageHelper::addModelImgNotPlaceholder(FoodsType::findOne(1)),
                "dishes"        => [],
            ],
            [
                "category_id"   => 2,
                "category_name" => t("Dinner"),
                "img"           => ImageHelper::addModelImgNotPlaceholder(FoodsType::findOne(2)),
                "dishes"        => [],
            ],
            [
                "category_id"   => 3,
                "category_name" => t("Supper"),
                "img"           => ImageHelper::addModelImgNotPlaceholder(FoodsType::findOne(3)),
                "dishes"        => [],
            ],
            [
                "category_id"   => 4,
                "category_name" => t("Snack"),
                "img"           => ImageHelper::addModelImgNotPlaceholder(FoodsType::findOne(4)),
                "dishes"        => [],
            ],

        ];

        foreach ($dishes as $dish) {
            $model = Dishes::findOne($dish['id']);

            $data = [
                'id'       => $dish['id'],
                'category' => t($dish['category']),
                'title'    => $dish['title'],
                'text'     => $dish['text'] ?: '',
                'calories' => $dish['calories'],
                'proteins' => $dish['proteins'],
                'fats'     => $dish['fats'],
                'carbohyd' => $dish['carbohyd'],
                'img'      => ImageHelper::addModelImgNotPlaceholder($model),
            ];

            //$resp[$dish['cat_id']]['dishes'] = $data;
            array_push($resp[$dish['cat_id'] - 1]['dishes'], $data);

        }

        if ($one) {
            return array_filter($resp, function ($v, $k) {
                return count($v) > 0;
            }, ARRAY_FILTER_USE_BOTH
            );
        }

        return $resp;

    }


    public function oneDish($dish)
    {
        $model = Dishes::findOne($dish['id']);
        $dish['category'] = t($dish['category']);
        $dish['img'] = ImageHelper::addModelImgNotPlaceholder($model);

        return $dish;
    }


    public function allComplexes($complexes, array $clientBought)
    {
        $resp = [];
        foreach ($complexes as $complex) {
            $com = [
                "id"   => $complex->id,
                "name" => $complex->name,
                "kind" => $complex->kind,
            ];

            /** @todo Первый комплекс бесплатный */
            if (in_array($complex['id'], $clientBought) || $complex['id'] == 1) {
                $com['bought'] = UserComplexStatus::BOUGHT;
            } else {
                $com['bought'] = UserComplexStatus::NOT_BOUGHT;
            }

            $resp[] = $com;
        }

        return $resp;
    }//allComplexes


    public function oneComplex($trainings)
    {
        $resp = [];
        foreach ($trainings as $training) {
            $tr = [
                "training_id"     => $training['id'],
                "exercises_count" => $training['exercises'],
                "total_time"      => $training['total_time'],
                "completed"       => $training['completed'],
            ];

            $resp[] = $tr;
        }

        return $resp;

    }//oneComplex


    public function oneTraining($exercises)
    {
        $resp = $exercises;

        return $resp;
    }//oneTraining


    public function oneTrainingForAdmin($exercises)
    {
        $resp = [];
        $i = 1;
        foreach ($exercises as $exercise) {
            $ex['id'] = $i;
            $ex['ex_id'] = $exercise['ex_tab_id'];
            $ex['name'] = 'Упражнение ' . $i;
            $ex['ex_name'] = $exercise['exercise_name'];
            $ex['options'] = [];
            $j = 1;
            foreach ($exercise['options'] as $option) {
                $op['id'] = $j;
                $op['op_id'] = $option['option_id'];
                $op['op_name'] = $option['option_name'];
                $op['name'] = "Опция " . $j;
                $op['units'] = $option['option_units'];
                $op['val'] = $option['option_value'];

                $j++;
                $ex['options'][] = $op;
            }

            $resp[] = $ex;
            $i++;
        }


        return $resp;
    }//oneTrainingForAdmin


    public function oneExercise($exercise)
    {
        $resp = $exercise;

        return $resp;
    }//oneTraining


    public function allStaff(array $staff)
    {
        $resp = [];
        foreach ($staff as $user) {
            $profile = [
                "id"     => $user->id,
                "name"   => $user->username,
                "email"  => $user->email ?: '',
                "tel"    => $user->tel ?: '',
                "img"    => $user->img ?: '',
                "role"   => $user->role_id,
                "gender" => $user->gender ?: 0,
            ];
            $resp[] = $profile;
        }


        return $resp;
    }//allStaff


    public function generateRecoveryCode($res)
    {
        $resp = $res;

        return ['success' => $resp];
    }//generateRecoveryCode


    public function checkConfirmCode($res)
    {
        $resp = $res;

        return ['access_token' => $resp];
    }//generateRecoveryCode

}//ApiResp