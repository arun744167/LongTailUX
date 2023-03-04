<?php

use PHPUnit\Framework\TestCase;

class UserRoleTest extends TestCase
{
    /**
     * @dataProvider userRoleDataProvider
     */
    public function testSubOrdinates($roleData, $userData){

        $buildUserRole = new Longtail\UserSubordinate\UserHierarchy($userData, $roleData);

        $buildUserRole->createUsers();
        $buildUserRole->createRoles();
        $buildUserRole->userRoleGrouping();

        $expectedResult1 = [
            [
                'id' => 2,
                'name' => 'Emily Employee',
                'roleId' => 4,
            ],
            [
                'id' => 5,
                'name' => 'Steve Trainer',
                'roleId' => 5,
            ],

        ];

        foreach ($expectedResult1 as $value){
            $this->assertContainsEquals($value, json_decode($buildUserRole->getSubordinates(1), true));
        }

        $expectedResult2 = [
            [
                'id' => 2,
                'name' => 'Emily Employee',
                'roleId' => 4,
            ],
            [
                'id' => 3,
                'name' => 'Sam Supervisor',
                'roleId' => 3,
            ],
            [
                'id' => 4,
                'name' => 'Mary Manager',
                'roleId' => 2,
            ],
            [
                'id' => 5,
                'name' => 'Steve Trainer',
                'roleId' => 5,
            ],
        ];

        foreach ($expectedResult2 as $value){
            $this->assertContainsEquals($value, json_decode($buildUserRole->getSubordinates(1), true));
        }


    }

    public function userRoleDataProvider(){
        return [
                   [
                       [  // role data
                        '{"Id":1,"Name":"System Administrator","Parent":0}',
                        '{"Id":2,"Name":"Location Manager","Parent":1}',
                        '{"Id":3,"Name":"Supervisor","Parent":2}',
                        '{"Id":4,"Name":"Employee","Parent":3}',
                        '{"Id":5,"Name":"Trainer", "Parent":3}'
                        ],
                        [ // user data
                        '{"Id":1,"Name":"Adam Admin","Role":1}',
                        '{"Id":2,"Name":"Emily Employee","Role":4}',
                        '{"Id":3,"Name":"Sam Supervisor","Role":3}',
                        '{"Id":4,"Name":"Mary Manager","Role":2}',
                        '{"Id":5,"Name":"Steve Trainer","Role":5}'
                        ]

                   ]
        ];
    }

}