<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tokens/create', function () {
    $user = User::find(1);
    $token = $user->createToken('firstToken');

    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
});

Route::apiResource('products', ProductController::class)->only(['index', 'show']);

