<?php

namespace App\Models;

use App\Support\Helpers\Table;
use App\Support\Model;

class User extends Model
{
    private $database;

    public $id = null;
    public $username;
    public $usermail;

    public function __construct()
    {
        $this->database = new Model('users');
    }

    public function store($flag = null)
    {
        $table = new Table();

        $table->setFields(['id'=>$this->id, 'username'=>$this->username, 'usermail'=>$this->usermail]);
        return $this->save($table, $flag);
    }
}