<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/crud', function () {
    return view('crud');
});

Route::get('/all', [CrudController::class, 'index']);
Route::post('/create', [CrudController::class, 'store']);
Route::post('/modified', [CrudController::class, 'update']);
Route::post('/remove/{id}', [CrudController::class, 'destroy']);
