<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

/*Route::get('/home', 'HomeController@index')->name('home');*/



// ****************************Start Admin Route*********************
Route::group(['as' => 'admin.','prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('tag', 'TagController');
    Route::resource('category', 'CategoryController');
    Route::resource('posts', 'PostController');

    Route::get('pending/posts', 'PostController@pending')->name('posts.pending');
    Route::put('posts/{post}/approve', 'PostController@approval')->name('posts.approve');


    // subscriber route
    Route::get('/subscriber', 'SubscriberController@index')->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}', 'SubscriberController@destroy')->name('subscriber.destroy');

      // SettingsController route
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/profile-update/{id}', 'SettingsController@profileUpdate')->name('profile.update');
    Route::post('/password-update/{id}', 'SettingsController@passwordUpdate')->name('password.update');


    // FavoriteController route
    Route::get('/favorite', 'FavoriteController@index')->name('favorite.index');


    //  CommentController route
    Route::get('/comments', 'CommentController@index')->name('comment.index');
    Route::delete('/comments/{id}', 'CommentController@destroy')->name('comment.destroy');



    // Authors Controller
    Route::get('/authors', 'AuthorsController@index')->name('author.index');
    Route::delete('/author/{id}', 'AuthorsController@destroy')->name('author.destroy');



});

// ****************************end Admin Route*********************




// ***************************Author Route******************************
Route::group(['as' => 'author.','prefix' => 'author', 'namespace' => 'Author', 'middleware' => ['auth', 'author']], function (){

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('post', 'PostController');


    // SettingsController route
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/profile-update/{id}', 'SettingsController@profileUpdate')->name('profile.update');
    Route::post('/password-update/{id}', 'SettingsController@passwordUpdate')->name('password.update');


    // FavoriteController route
    Route::get('/favorite', 'FavoriteController@index')->name('favorite.index');


    //  CommentController route
    Route::get('/comments', 'CommentController@index')->name('comment.index');
    Route::delete('/comments/{id}', 'CommentController@destroy')->name('comment.destroy');


});



// ***************************Frontend Route******************************

//  subscriber Route
Route::post('subscriber', 'Frontend\SubscriberController@store')->name('subscriber.store');
Route::get('/', 'Frontend\HomeController@index')->name('home');


// PostController
Route::get('post/{slug}', 'Frontend\PostController@singlePost')->name('post.details');
Route::get('posts', 'Frontend\PostController@index')->name('posts.index');
Route::get('category/{slug}', 'Frontend\PostController@postByCategoory')->name('category.posts');
Route::get('tag/{slug}', 'Frontend\PostController@postByTag')->name('tag.posts');


// AuthorController
Route::get('profile/{slug}', 'Frontend\AuthorController@profile')->name('profile.post');


// Search controole
Route::get('search', 'Frontend\SearchController@search')->name('search.posts');



Route::group(['middleware'=>['auth']], function (){

    Route::post('favorite/{post}/add', 'Frontend\FavoriteController@add')->name('post.favorite');
    Route::post('comment/{post}', 'Frontend\CommentController@store')->name('comment.store');

});


View::composer('frontend/parsials/footer', function ($view){ // it will use only footer without any route controller
   $categories = \App\Category::all();
   $view->with('categories', $categories);
});
















