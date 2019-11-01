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



// ****************************Admin Route*********************
Route::group(['as' => 'admin.','prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('tag', 'TagController');
    Route::resource('category', 'CategoryController');
    Route::resource('post', 'PostController');


    Route::get('pending/post', 'PostController@pending')->name('post.pending');
    Route::put('post/{id}/approve', 'PostController@approval')->name('post.approve');


    // subscriber route
    Route::get('/subscriber', 'SubscriberController@index')->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}', 'SubscriberController@destroy')->name('subscriber.destroy');

      // SettingsController route
    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/profile-update/{id}', 'SettingsController@profileUpdate')->name('profile.update');
    Route::post('/password-update/{id}', 'SettingsController@passwordUpdate')->name('password.update');


    // FavoriteController route
    Route::get('/favorite', 'FavoriteController@index')->name('favorite.index');




});


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


});



// ***************************Frontend Route******************************
Route::post('subscriber', 'Frontend\SubscriberController@store')->name('subscriber.store');
Route::get('/', 'Frontend\HomeController@index')->name('home');


// PostController
Route::get('post/{slug}', 'Frontend\PostController@index')->name('post.details');


Route::group(['middleware'=>['auth']], function (){

    Route::post('favorite/{post}/add', 'Frontend\FavoriteController@add')->name('post.favorite');

});

















