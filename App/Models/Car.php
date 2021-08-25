<?php

namespace App\Models;

use App\Support\Model;

class Car
{
    private $database;
    // Properties referent to database column
    public $model;
    public $brand;
    public $color;

    public function __construct()
    {
        $this->database = new Model('cars');
    }

    public function all()
    {
        return $this->database::all();
    }

    public function where($column, $value)
    {
        return $this->database::select($column, $value);
    }

    public function save()
    {
        $data = array(
            'model'=>$this->model,
            'brand'=>$this->brand,
            'color'=>$this->color
        );

        return $this->database::insert($data);
    }

    public function update($id)
    {
        $data = array(
            'model'=>$this->model,
            'brand'=>$this->brand,
            'color'=>$this->color
        );

        return $this->database::update($data, $id);
    }

    public function remove($id)
    {
        return $this->database::remove($id);
    }
}