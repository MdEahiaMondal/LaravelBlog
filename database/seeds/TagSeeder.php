<?php

use App\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            ['name' =>'php'],
            ['name' =>'laravel'],
            ['name' =>'javascript'],
            ['name' =>'jquery'],
            ['name' =>'vue'],
            ['name' =>'nuxt'],
            ['name' =>'deno'],
            ['name' =>'node'],
            ['name' =>'react'],
            ['name' =>'angular'],
            ['name' =>'mysql'],
            ['name' =>'bootstrap'],
            ['name' =>'vuetify'],
            ['name' =>'bulma'],
            ['name' =>'css'],
            ['name' =>'html'],
            ['name' =>'learning'],
            ['name' =>'book'],
            ['name' =>'read'],
            ['name' =>'hard work'],
        ];

        foreach ($tags as $tag){
            Tag::create([
                'name' => $tag['name'],
                'slug' => Str::slug($tag['name']),
            ]);
        }
    }
}
