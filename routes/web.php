<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth_routes.php';

/*
|--------------------------------------------------------------------------
| Customer-Facing Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/customer_routes.php';

/*
|--------------------------------------------------------------------------
| Admin Routes (protected: must be authenticated + have admin role)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        require __DIR__ . '/admin_routes.php';
    });

/*
|--------------------------------------------------------------------------
| Static View Routes (Customer)
|--------------------------------------------------------------------------
*/

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/blog', 'blog.index')->name('blog.index');
Route::view('/blog/{id}', 'blog.show')->name('blog.show');
