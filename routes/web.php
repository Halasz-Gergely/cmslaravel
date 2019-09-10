<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('categories','CategoriesController');
Route::resource('posts','PostsController');
Route::get('trashed-posts','PostsController@trashed')->name('trashed-posts.index');
Route::put('restore-post/{post}','PostsController@restore')->name('restore-post');
