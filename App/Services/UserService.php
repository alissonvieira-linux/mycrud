<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function get($id = null)
    {
        if ($id) {
           return $this->user::where('id', $id);
        }

        return $this->user::all();
    }

    public function post($id = null)
    {
        if($id) {
            return $this->put($_POST, $id);
        }

        $this->user->username = $_POST['name'];
        $this->user->usermail = $_POST['email'];
        return $this->user->store();
    }

    public function put($data, $id)
    {
        $this->user->username = $data['name'];
        $this->user->usermail = $data['email'];
        $this->user->id = $id;
        return $this->user->store('update');
    }

    public function delete($id)
    {
        return $this->user::remove($id);
    }
}