<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Client-Side Routes (Sona Template)
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('home'));
Route::get('/about', fn() => view('about'));
Route::get('/contact', fn() => view('contact'));

Route::get('/rooms', fn() => view('rooms.index'));
Route::get('/rooms/1', fn() => view('rooms.show'));

Route::get('/blog', fn() => view('blog.index'));
Route::get('/blog/1', fn() => view('blog.show'));

Route::get('/bookings/checkout', fn() => view('bookings.checkout'));
Route::get('/bookings/success', fn() => view('bookings.success'));

Route::get('/profile/history', fn() => view('profile.history'));

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', fn() => view('auth.login'));
Route::get('/register', fn() => view('auth.register'));

/*
|--------------------------------------------------------------------------
| Admin Routes (InApp Template)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    Route::get('', fn() => view('admin.dashboard'));
    Route::get('/', fn() => view('admin.dashboard'));
    Route::get('/dashboard', fn() => view('admin.dashboard'));
    Route::get('/rooms', fn() => view('admin.rooms.index'));
    Route::get('/rooms/create', fn() => view('admin.rooms.create'));
    Route::get('/categories', fn() => view('admin.categories.index'));
    Route::get('/bookings', fn() => view('admin.bookings.index'));
    Route::get('/reviews', fn() => view('admin.reviews.index'));
    Route::get('/users', fn() => view('admin.users.index'));
});