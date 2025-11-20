<?php
use Illuminate\Support\Facades\Route;

Route::post('/accept-cookies', function () {
    return response()->json(['success'=>true])
        ->cookie(config('police.cookie_name'), '1', config('police.cookie_lifetime'));
});
