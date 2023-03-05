<?php

namespace Longtail\UserSubordinate;

use Longtail\UserSubordinate\Factory\RolesFactory;
use Longtail\UserSubordinate\Factory\UserFactory;
use Longtail\UserSubordinate\Factory\UserRoleFactory;
use Longtail\UserSubordinate\Services\UserService;


// User Manager class create user, roles and userRole Group lists
class BuildUserHierarchy
{

protected array $roleData = [];
protected array $usersData = [];

protected array $roles = [];
protected array $users = [];
protected array $userRoleGroup = [];

public function __construct($userData, $rolesData){
    $this->usersData = $userData;
    $this->roleData = $rolesData;
}

// create array of user objects
public function createRoles() : void {
    foreach ($this->roleData as $data){
        $role = json_decode($data, true);
        $this->roles[$role['Id']] = RolesFactory::create($role['Id'], $role['Name'], $role['Parent'] );
    }
}

// Create array of roles objects
public function createUsers() : void {
    foreach ($this->usersData as $data){
        $user = json_decode($data, true);
        $this->users[$user['Id']] = UserFactory::create($user['Id'], $user['Name'], $user['Role'] );
    }
}

//Create array of user role group objects assumed to pivot object
public function userRoleGrouping() : void {
    $this->userRoleGroup = UserRoleFactory::create($this->users, $this->roles);
}

// Recursively look up to find Subordinates
public function Subordinate($userId, $subordinates = null): array {
    $subUsers = [];

    if ($subordinates === null){ // for initial call get role id from saved user objects
        $roleId = $this->users[$userId]->roleId;
    } else {
        $roleId = $subordinates->roleId; // on recursive subordinate get next role id
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

//output the subordinates or user hierarchy
public function getSubordinates($userId){
    return json_encode($this->Subordinate($userId));
}

}