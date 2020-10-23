<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserRole;
use Faker\Generator as Faker;

$factory->define(UserRole::class, function (Faker $faker) {
    return [
        //
        'roleName'=>'SystemAdmin',
        'permission'=>'{"menuList":[{"resourceName":"Home","read":true,"write":false,"update":false,"delete":false,"name":"home"},{"resourceName":"Notification","read":true,"write":false,"update":false,"delete":false,"name":"notification"},{"resourceName":"Community","read":true,"write":false,"update":false,"delete":false,"name":"community"},{"resourceName":"Facility","read":true,"write":false,"update":false,"delete":false,"name":"facility"},{"resourceName":"Suggestion","read":true,"write":false,"update":false,"delete":false,"name":"suggestion"},{"resourceName":"Repair","read":true,"write":false,"update":false,"delete":false,"name":"repair"},{"resourceName":"Users","read":true,"write":false,"update":false,"delete":false,"name":"users"},{"resourceName":"UserRole","read":true,"write":false,"update":false,"delete":false,"name":"userRole"},{"resourceName":"Permission","read":true,"write":false,"update":false,"delete":false,"name":"permission"}]}'
    ];
});
