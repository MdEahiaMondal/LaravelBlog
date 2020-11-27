<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Post::class, function (Faker $faker) {
    $title =  $faker->sentence;
    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'image' => $faker->imageUrl(1600, 1066),
        'body' => $faker->paragraph,
        'view_count' =>random_int(0,100),
        'status' => random_int(0,1),
        'is_approved' => random_int(0,1),
    ];
});
