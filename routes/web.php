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
// Home
Route::get('/', function() {
  return redirect(route('main'));
});


// Cards
Route::get('main', 'MainController@show')->name('main');
Route::get('main/hot', 'MainController@showHot')->name('hot');
Route::get('user/{id}/edit', 'UserController@getEditForm')->name('edit');
Route::post('user/{id}/edit', 'UserController@processEditForm');
Route::get('user/{id}', 'UserController@show')->name('user');

// Admin
Route::get('admin', 'AdministratorController@show')->name('admin');
Route::post('admin', 'UserController@delete');

// Community
Route::get('community/{id}', 'CommunityController@show')->name('community');
Route::get('community/{id}/edit', 'CommunityController@getEditForm')->name('edit_community');
Route::post('community/{id}/edit', 'CommunityController@processEditForm');
Route::post('community/{id}/follow', 'UserController@follow_community')->name('follow');
Route::post('community/{id}/unfollow', 'UserController@unfollow_community')->name('unfollow');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


// Post
Route::get('post/{id}', 'PostController@show')->name('post');
Route::get('post/{id}/edit', 'PostController@getEditForm')->name('edit_post');
Route::delete('post/{id}', 'PostController@destroy')->name('delete_post');
Route::post('post/{id}/edit', 'PostController@processEditForm');
Route::get('community/{id}/submit', 'PostController@create')->name('submit_post');
Route::post('community/{id}/submit', 'PostController@store');

// Search
Route::get('search', 'SearchController@show')->name('search');