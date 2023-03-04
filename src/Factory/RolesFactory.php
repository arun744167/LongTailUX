<?php

namespace Longtail\UserSubordinate\Factory;

use Longtail\UserSubordinate\Model\Role;

class RolesFactory
{
    public static function create($id, $name, $parentId){
        return new Role($id, $name, $parentId);
    }
}