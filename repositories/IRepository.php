<?php

namespace app\repositories;


interface IRepository
{
    public function get($select, $where);

    public function getOne($id);

    public function getAll($select, $where);

    public function save($model);

    public function update($model);

    public function delete($id);
}