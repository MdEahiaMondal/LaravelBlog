<?php

use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Md.Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('rootadmin'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Md.Author',
            'username' => 'author',
            'email' => 'author@gmail.com',
            'password' => bcrypt('rootauthor'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        User::all()->each(function (User $user) {
            $post = factory(Post::class, random_int(5, 30))->make();
            $user->posts()->saveMany($post);
        });

    }
}
