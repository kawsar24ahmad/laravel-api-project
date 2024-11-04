<?php

use App\Http\Controllers\Api\v1\AuthController as AuthV1;
use App\Http\Controllers\Api\v1\UrlController as UrlV1;


use App\Http\Controllers\Api\v2\AuthController as AuthV2;
use App\Http\Controllers\Api\v2\UrlController as UrlV2;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



function defineApiRoutes($prefix, $authController,$urlController ){
    Route::prefix($prefix)->group(function () use ($authController, $urlController, $prefix) {
        /**
         * Authentication routes
         */

        Route::post("signup", [$authController,"signup"])->name("api.{$prefix}.auth.signup");
        Route::post("login", [$authController,"login"])->name("api.{$prefix}.auth.login");

        Route::middleware('auth:sanctum')->group(function () use ($authController, $urlController, $prefix) {
            Route::post("logout", [$authController,"logout"])->name("api.{$prefix}.auth.logout");

            /**
             * url related routes
             */
            Route::post("urls/shorten", [$urlController,"storeShortUrl"])->name("api.{$prefix}.urls.shorten");

            Route::post("urls/expand", [$urlController,"showLongUrl"])->name("api.{$prefix}.urls.expand");

            Route::get("urls", [$urlController,"index"])->name("api.{$prefix}.urls.index");
        });
    });
}

defineApiRoutes("v1", AuthV1::class, UrlV1::class);
defineApiRoutes("v2", AuthV2::class, UrlV2::class);


