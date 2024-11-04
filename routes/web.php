<?php

use App\Http\Controllers\Api\v1\UrlController as UrlV1;
use App\Http\Controllers\Api\v2\UrlController as UrlV2;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 *  the route for version 1
 */
Route::get('/v1/{shortUrl}', [UrlV1::class, 'redirectShortUrl']);

/**
 * the route for version 2
 */
Route::get('/v2/{shortUrl}', [UrlV2::class, 'redirectShortUrl']);
