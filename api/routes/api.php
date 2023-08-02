<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CertificateController;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'store']);
// Route::get('users', [UserController::class, 'index']);
Route::get('user/{id}', [UserController::class, 'show']);




Route::group([
    'middleware' => 'auth.jwt',
    'prefix' => 'auth'
], function ($router) {
    Route::get('users', [UserController::class, 'index']);

    //lesson
    Route::get('lessons', [LessonController::class, 'index']);
    Route::post('lesson/create', [LessonController::class, 'store']);
    Route::post('lesson/update/{id}', [LessonController::class, 'update']);
    Route::post('lesson/remove/{id}', [LessonController::class, 'destroy']);

    // Route::post('generate-cert', [CertificateController::class, 'index']);

    Route::get('certificates', [CertificateController::class, 'showAll']);
    Route::get('certificate/{id}', [CertificateController::class, 'show']);
});

Route::get('generate-cert/{uid}/{lid}', [CertificateController::class, 'index']);