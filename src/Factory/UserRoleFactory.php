<?php

namespace Longtail\UserSubordinate\Factory;

use Longtail\UserSubordinate\UserRole;

class UserRoleFactory
{
    public static function create($users, $roles){
        $userRoleGroup = [];

        foreach ($users as $user){
            $parentId = $roles[$user->roleId]->parentId;
            $userRoleGroup [$user->id] = new UserRole($user->id, $user->roleId, $parentId);
        }

        return $userRoleGroup;
    }

}