<?php

namespace app\repositories;


use yii\db\ActiveRecord;

abstract class DefaultIRepository implements IRepository
{
    protected $model;

    public function __construct(ActiveRecord $model)
    {
        $this->model = $model;
    }//__construct


    public function get($select = '*', $where = false)
    {
        $activeQuery = $this->model->find();

        $activeQuery->select($select);

        if ($where) {
            $activeQuery->where($where);
        }

        return $activeQuery->limit(1)->one();
    }//get


    public function getAsArray($select = '*', $where = false)
    {
        $activeQuery = $this->model->find();

        $activeQuery->select($select);

        if ($where) {
            $activeQuery->where($where);
        }

        return $activeQuery->limit(1)->asArray()->one();
    }//getAsArray


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
    }//getAll


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
    }//getAllAsArray


    public function getOne($id)
    {
        return $this->model->findOne($id);
    }//getOne


    public function getColumn($select = '*', $where = false)
    {
        $activeQuery = $this->model->find();

        $activeQuery->select($select);

        if ($where) {
            $activeQuery->where($where);
        }

        return $activeQuery->limit(1)->column();
    }//getColumn


    public function count($where = false)
    {
        $activeQuery = $this->model->find();

        if ($where) {
            $activeQuery->where($where);
        }

        return (int)$activeQuery->count();
    }//count


    public function save($model)
    {
        return $model->save();
    }//save


    public function update($model)
    {
        // TODO: Implement update() method.
    }//update


    public function delete($where)
    {
        $value = $this->get('*', $where);
        if (!empty($value)) {
            return $value->delete();
        }
    }//delete


    public function deleteAll($where)
    {
        $values = $this->getAll('*', $where);
        if (!empty($values)) {
            foreach ($values as $item) {
                $item->delete();
            }
        }
    }//deleteAll


    public function isExist($where)
    {
          return $this->count($where);
    }//isExist

}//DefaultRepository