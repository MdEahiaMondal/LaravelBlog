<?php

use App\Category;
use App\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' =>'php', 'image' => 'https://kinsta.com/wp-content/uploads/2018/05/what-is-php-3-1.png'],
            ['name' =>'laravel', 'image' => 'https://www.bunnyshell.com/blog/wp-content/uploads/2020/09/Laravel-featured-image.png'],
            ['name' =>'javascript', 'image' => 'https://res.cloudinary.com/practicaldev/image/fetch/s--ohpJlve1--/c_imagga_scale,f_auto,fl_progressive,h_420,q_auto,w_1000/https://res.cloudinary.com/drquzbncy/image/upload/v1586605549/javascript_banner_sxve2l.jpg'],
            ['name' =>'jquery', 'image' => 'https://miro.medium.com/max/4400/1*NeKYs9ypQ7jkalNxEX3t9Q.png'],
            ['name' =>'vue', 'image' => 'https://miro.medium.com/max/3920/1*oZqGznbYXJfBlvGp5gQlYQ.jpeg'],
            ['name' =>'nuxt', 'image' => 'https://miro.medium.com/max/3004/1*dKYx6tc_nT6hELIz9_pExg.png'],
            ['name' =>'deno', 'image' => 'https://miro.medium.com/max/2560/1*3ZIwMO_BWXwbXq5XuhvzkQ.png'],
            ['name' =>'node', 'image' => 'https://i2.wp.com/blog.logrocket.com/wp-content/uploads/2019/10/nodejs.png?fit=1240%2C700&ssl=1'],
            ['name' =>'react', 'image' => 'https://miro.medium.com/max/3840/1*yjH3SiDaVWtpBX0g_2q68g.png'],
            ['name' =>'angular', 'image' => 'https://bs-uploads.toptal.io/blackfish-uploads/blog/post/seo/og_image_file/og_image/15991/top-18-most-common-angularjs-developer-mistakes-41f9ad303a51db70e4a5204e101e7414.png'],
            ['name' =>'mysql', 'image' => 'https://iserversupport.com/wp-content/uploads/2018/09/Screen-Shot-2018-09-11-at-4.51.20-PM.png'],
            ['name' =>'bootstrap', 'image' => 'https://www.tutorialrepublic.com/lib/images/bootstrap-illustration.png'],
            ['name' =>'vuetify', 'image' => 'https://res.cloudinary.com/practicaldev/image/fetch/s--i4QUYWJr--/c_imagga_scale,f_auto,fl_progressive,h_900,q_auto,w_1600/https://thepracticaldev.s3.amazonaws.com/i/9qypxdkcnrvkzqhxeo59.png'],
            ['name' =>'bulma', 'image' => 'https://media.geeksforgeeks.org/wp-content/cdn-uploads/20200207185625/bul.png'],
        ];

        foreach ($categories as $category){
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
            ]);
        }

        $faker = Faker\Factory::create();
        Category::all()->each(function (Category $category) use ($faker){
            $category->images()->delete(); // first delete old data
            for($i=0; $i <= 2; $i++){
                $category->images()->create([
                    'path' => $faker->imageUrl(),
                    'cat_type' => Arr::random(['slider', 'background']),
                ]);
            }
        });
    }
}
