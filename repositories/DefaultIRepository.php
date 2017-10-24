<?php

namespace app\repositories;


abstract class DefaultIRepository implements IRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function get($select = '*', $where = false)
    {
        $activeQuery = $this->model->find();

        $activeQuery->select($select);

        if ($where) {
            $activeQuery->where($where);
        }

        return $activeQuery->limit(1)->one();
    }

    public function getAsArray($select = '*', $where = false)
    {
        $activeQuery = $this->model->find();

        $activeQuery->select($select);

        if ($where) {
            $activeQuery->where($where);
        }

        return $activeQuery->limit(1)->asArray()->one();
    }

    public function getAll($select = '*', $where = false, $limit = false)
    {
        $activeQuery = $this->model->find();

        $activeQuery->select($select);

        if ($where) {
            $activeQuery->where($where);
        }

        if ($limit) {
            $activeQuery->limit($limit);
        }

        return $activeQuery->all();
    }

    public function getAllAsArray($select = '*', $where = false, $limit = false)
    {
        $activeQuery = $this->model->find();

        $activeQuery->select($select);

        if ($where) {
            $activeQuery->where($where);
        }

        if ($limit) {
            $activeQuery->limit($limit);
        }

        return $activeQuery->asArray()->all();
    }

    public function getOne($id)
    {
        return $this->model->findOne($id);
    }

    public function getColumn($select = '*', $where = false)
    {
        $activeQuery = $this->model->find();

        $activeQuery->select($select);

        if ($where) {
            $activeQuery->where($where);
        }

        return $activeQuery->limit(1)->column();
    }

    public function count($where = false)
    {
        $activeQuery = $this->model->find();

        if ($where) {
            $activeQuery->where($where);
        }

        return $activeQuery->count();
    }

    public function save($model)
    {
        return $model->save();
    }

    public function update($model)
    {
        // TODO: Implement update() method.
    }

    public function delete($where)
    {
        $value = $this->get('*', $where);
        if (!empty($value)) {
            $value->delete();
        }
    }

    public function isExist($where)
    {
          return $this->count($where);
    }

}//DefaultRepository