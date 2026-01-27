<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeSlideController;
use App\Http\Controllers\AboutPageController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
})->name('home');


Route::get('/login', [AdminController::class, 'login'])->name('login');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('admin.index');
// })->name('dashboard');


// Route::controller(AdminController::class)->group(function () {

//     Route::get('/admin/logout', 'destroy')->name('admin.logout');
//     Route::get('/admin/profile', 'profile')->name('admin.profile');
//     Route::post('/admin/update', 'update')->name('admin.update');
//     Route::get('/dashboard', 'dashboard')->name('dashboard');

// });

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/update', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/password/change', [AdminController::class, 'passwordChange'])
    ->name('admin.password.change');
    Route::post('/admin/password/update', [AdminController::class, 'updatePassword'])
    ->name('admin.password.update');

});




Route::controller(HomeSlideController::class)->group(function () {

    Route::get('/Home/slide', 'HomeSlideContent')->name('home.slide');
    Route::post('/admin/home-slide/update', 'update')->name('home-slide.update');

});


Route::controller(AboutPageController::class)->group(function () {

    Route::get('/about/page', 'AboutPageContent')->name('about.page');
    Route::post('/about-page/update', 'update')->name('about-page.update');
    Route::get('/about', 'HomeAbout')->name('home.about');
    Route::get('/about-multiple-image-upload-Interface', 'MultimageUploadView')->name('about.multi_image_view');
    Route::post('/admin/about/upload', 'store')->name('about.upload');
    Route::get('/show-about-multiple-images', 'ShowUploadedImages')->name('about.uploaded_multi_images');
    Route::delete('/admin/about/{id}', 'DeleteImage')->name('about.image.delete');
    Route::post('/admin/about/{id}', 'UpdateImage')->name('about.image.update');

});


Route::post('/admin/gallery/{id}', [GalleryController::class, 'update'])
    ->name('gallery.update');






Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
