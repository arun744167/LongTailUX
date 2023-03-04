<?php

namespace Longtail\UserSubordinate;

// create a user and roles pivot object to find subordinate of the current user
class UserRole
{
    public $userId;
    public $roleId;
    public $parentId;

    public function __construct($userId, $roleId, $parentId){
        $this->userId = $userId;
        $this->roleId = $roleId;
        $this->parentId = $parentId;
    }

}