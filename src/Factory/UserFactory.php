<?php

namespace Longtail\UserSubordinate\Factory;

use Longtail\UserSubordinate\User;

class UserFactory
{
    public static function createUser($id, $name, $roleId){
        return new User($id, $name, $roleId);
    }
}