<?php

namespace App\Support\Helpers;

class Table
{
    private $fields = array();

    public function setFields($fillables)
    {
        foreach($fillables as $key => $value) {
            $this->fields[$key] = $value;
        }
    }

    public function getFields()
    {
        return $this->fields;
    }
}