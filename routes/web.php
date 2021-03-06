<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Auth routes
Auth::routes();

//Social routes
Route::get('auth/{social}', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/{social}/callback', 'Auth\RegisterController@handleProviderCallback');

//Email verification
Route::get('register/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');


//Regex for route parameters
Route::patterns([
    'category'  => '[0-9]+',
    'post'      => '[0-9]+',
    'tag'       => '[0-9]+',
    'comment'   => '[0-9]+',
    'user'      => '[0-9]+'
]);

//Blog pages routes
Route::get('/', 'BlogController@home')->name('home');
Route::get('/about-me', 'BlogController@about')->name('about');
Route::get('/contact-me', 'BlogController@contact')->name('contact');
Route::post('/contact-me', 'BlogController@sendContact')->name('send.contact');
Route::get('/blog/{slug}', 'BlogController@showPost')->name('blog.post');
Route::get('/search', 'BlogController@search')->name('search');
Route::post('/comment/{post}/store', 'CommentController@store')->name('comment.store');
Route::patch('/comment/{comment}/reply', 'CommentController@reply')->name('comment.reply');

//Backend routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard')->middleware('revalidate');
    Route::resource('category', 'CategoryController');
    Route::resource('post', 'PostController');
    Route::patch('post/visibility/update', 'PostController@updateVisibility')->name('post.visible');
    Route::resource('tag', 'TagController', ['only' => ['index', 'edit', 'update', 'destroy']]);
    //user routes
    Route::get('user/profile', 'UserController@showProfile')->name('user.profile');
    Route::patch('user/{user}/update', 'UserController@updateProfile')->name('user.update');
    Route::get('user/password', 'UserController@showPasswordForm')->name('user.password');
    Route::put('user/{user}/password/update', 'UserController@updatePassword')->name('user.password.update');
    Route::get('user/lists', 'UserController@allUsers')->name('user.lists');
    Route::delete('user/{user}/destroy', 'UserController@destroyUser')->name('user.destroy');
    //Comment backend routes
    Route::get('/comment', 'CommentController@index')->name('comment.index');
    Route::delete('/comment/{comment}/destroy', 'CommentController@destroy')->name('comment.destroy');
    Route::patch('/comment/{comment}/ajax/reply', 'CommentController@storeAjaxReply')->name('comment.ajax.reply');
    Route::patch('/comment/confirm', 'CommentController@confirm')->name('comment.confirm')->middleware('ajax');
});

Route::get('home', function() {
    return view('home');
});

