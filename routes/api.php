<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// route test check API
Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'message' => 'API hotringo-ses berjalan',
        'data'    => [
            'service' => 'contact-api',
        ],
        'errors'  => null,
    ]);
});

// route untuk form kontak (POST)
Route::post('/contact', [ContactController::class, 'submitApi'])
    ->name('api.contact.submit');
