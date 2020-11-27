<?php

use App\Category;
use App\Post;
use App\Role;
use App\Tag;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(CategorySeeder::class);
         $this->call(TagSeeder::class);
         $this->call(PostSeeder::class);
         $this->call(PostCategoryTagsSeeder::class);
    }
}
