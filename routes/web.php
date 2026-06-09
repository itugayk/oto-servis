<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/hizmetler', [PublicController::class, 'services'])->name('services.index');
Route::get('/hizmetler/{service:slug}', [PublicController::class, 'serviceShow'])->name('services.show');

Route::get('/randevu', [PublicController::class, 'appointment'])->name('appointment');

Route::get('/markalar', [PublicController::class, 'brands'])->name('brands.index');
Route::get('/galeri', [PublicController::class, 'gallery'])->name('gallery.index');

Route::get('/blog', [PublicController::class, 'blog'])->name('blog.index');
Route::get('/blog/{post:slug}', [PublicController::class, 'blogShow'])->name('blog.show');

Route::get('/iletisim', [PublicController::class, 'contact'])->name('contact');
