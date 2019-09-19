<?php


use Illuminate\Support\Facades\Route;

Route::get('/', 'WelcomeController@index');

Auth::routes();



Route::middleware(['auth'])->group(function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('categories','CategoriesController');
    Route::resource('posts','PostsController');
    Route::resource('tags','TagsController');
    Route::get('trashed-posts','PostsController@trashed')->name('trashed-posts.index');
    Route::put('restore-post/{post}','PostsController@restore')->name('restore-post');
});

Route::middleware(['auth', 'admin'])->group(function(){
    Route::get('users','UsersController@index')->name('users.index');
    Route::get('users/profile','UsersController@edit')->name('users.edit-profile');
    Route::put('users/profile', 'UsersController@update')->name('users.update-profile');
    Route::put('users/{user}/makeAdmin','UsersController@makeAdmin' )->name('users.make-admin');
});
