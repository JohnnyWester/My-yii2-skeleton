<?php

namespace app\helpers\check;


use app\repositories\IRepository;

interface ICheckInputParams
{
    public function check(array $params);
}//CheckInputParams