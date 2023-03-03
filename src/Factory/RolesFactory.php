<?php

namespace Longtail\UserSubordinate\Factory;

use Longtail\UserSubordinate\Role;

class RolesFactory
{
    public static function createRole($id, $name, $parentId){
        return new Role($id, $name, $parentId);
    }
}