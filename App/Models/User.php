<?php

namespace App\Models;

use App\Support\Helpers\Table;
use App\Support\Model;

class User extends Model
{
    private $database;

    public $id = null;
    public $name;
    public $email;

    public function __construct()
    {
        $this->database = new Model('users');
    }

    public function store($flag = null)
    {
        $table = new Table();

        $table->setFields(['id'=>$this->id, 'name'=>$this->name, 'email'=>$this->email]);
        return $this->save($table, $flag);
    }
}