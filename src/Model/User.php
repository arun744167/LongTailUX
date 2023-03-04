<?php

namespace Longtail\UserSubordinate\Model;

class User
{
    public $id;
    public $name;
    public $roleId;

    public function __construct($id, $name, $roleId){
       $this->id = $id;
       $this->name = $name;
       $this->roleId = $roleId;
    }

}