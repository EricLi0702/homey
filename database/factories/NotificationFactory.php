<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Notification;
use Faker\Generator as Faker;

$factory->define(Notification::class, function (Faker $faker) {
    return [
        'roleId'=>1,
        'userId'=>1,
        'aptId'=>1,
        'title'=> $faker->regexify('[A-Za-z0-9]{20}'),
        'type'=>1,
        'content'=>$faker->regexify('[A-Za-z0-9]{70}'),
    ];
});
