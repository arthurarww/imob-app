<?php

use App\Http\Middleware\AuthOrganization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(AuthOrganization::class)->group(function () {
    Route::get('/organization', function (Request $request) {
        dd($request->all());
    });
});
