<?php

namespace Longtail\UserSubordinate;

use Longtail\UserSubordinate\Factory\RolesFactory;
use Longtail\UserSubordinate\Factory\UserFactory;
use Longtail\UserSubordinate\Factory\UserRoleFactory;
use Longtail\UserSubordinate\Services\UserService;


// User Manager class create user,
class UserServices
{

protected array $roleData = [];

protected array $usersData = [];

protected array $roles = [];
protected array $users = [];
public array $userRoleGroup = [];

public function __construct($userData, $rolesData){
    $this->usersData = $userData;
    $this->roleData = $rolesData;
}

// create array of user objects
public function createRoles() : void {
    foreach ($this->roleData as $data){
        $role = json_decode($data, true);
        $this->roles[$role['Id']] = RolesFactory::createRole($role['Id'], $role['Name'], $role['Parent'] );
    }
}

// Create array of roles objects
public function createUsers() : void {
    foreach ($this->usersData as $data){
        $user = json_decode($data, true);
        $this->users[$user['Id']] = UserFactory::createUser($user['Id'], $user['Name'], $user['Role'] );
    }
}

//Create array of user role group objects assumed to pivot object
public function userRoleGrouping() : void {
    $this->userRoleGroup = UserRoleFactory::createUserRole($this->users, $this->roles);
}

// Recursively look up tp find Subordinates, initially
public function Subordinate($userId, $subordinates = null): array {
    $subUsers = [];

    if ($subordinates === null){ // for initial call get role id from saved user objects
        $roleId = $this->users[$userId]->roleId;
    } else {
        $roleId = $subordinates->roleId; // on recursive subordinate next role id
    }

     foreach ($this->userRoleGroup as $userRole){ // scan for userRoleGroup to get subordinates
       if ($userRole->parentId === $roleId){ //add user if matched to parent roleid to child's parent id
               $users = $this->users[$userRole->userId];
               $userIds = $userRole->userId;
               $subUsers [] = $users;
               $subUsers = array_merge($subUsers, $this->subordinate($userIds, $users));
       }
     }

     return $subUsers;
}

public function getSubordinates($userId){
    return json_encode($this->Subordinate($userId));
}

}