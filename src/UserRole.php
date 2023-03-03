<?php

namespace Longtail\UserSubordinate;

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