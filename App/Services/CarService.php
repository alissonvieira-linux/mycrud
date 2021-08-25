<?php

namespace App\Services;

use App\Models\Car;

class CarService
{
    public function get($id = null)
    {
        $car = new Car();

        if ($id) {
            return $car->where('id', $id);
        }

        return $car->all();
    }

    public function post($id = null)
    {
        if ($id) {
            return $this->put($_POST, $id);
        }

        $car = new Car();
        $car->model = $_POST['model'];
        $car->brand = $_POST['brand'];
        $car->color = $_POST['color'];

        return $car->save();
    }

    public function put($data, $id)
    {
        $car = new Car();
        $car->model = $data['model'];
        $car->brand = $data['brand'];
        $car->color = $data['color'];

        return $car->update($id);
    }

    public function delete($id)
    {
        $car = new Car();
        return $car->remove($id);
    }
}