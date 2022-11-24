<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\tiket_controller;
use App\Http\Controllers\admincontroller;
use App\Http\Controllers\kategori_Controller;
use App\Http\Controllers\pesanan_controller;
use App\Http\Controllers\user_controller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//ADMIN
Route::post('admin/login',[admincontroller::class,'login']);
Route::post('admin/register',[admincontroller::class,'register']);
Route::middleware(['auth:sanctum','abilities:admin'])->group(function () {
    Route::post('tiket',[tiket_controller::class,'store']);
    Route::put('tiket/{id}',[tiket_controller::class,'update']);
    Route::delete('tiket/{id}',[tiket_controller::class,'destroy']);
    Route::resource('kategori', kategori_controller::class)->except(
        ['create','edit','index','show']
    );
    Route::get('admins',[admincontroller::class,'getAllAdmin']);
    Route::put('admin',[admincontroller::Class,'updateProfile'])->middleware(['auth:sanctum','abilities:admin']);
    Route::delete('admin',[admincontroller::Class,'deleteAccount'])->middleware(['auth:sanctum','abilities:admin']);
    Route::get('admin',[admincontroller::Class,'getAdmin'])->middleware(['auth:sanctum','abilities:admin']);
    Route::post('admin/logout',[admincontroller::Class,'logout'])->middleware(['auth:sanctum','abilities:admin']);
});

//USER
Route::post('user/login',[user_controller::class,'login']);
Route::post('user/register',[user_controller::class,'register']);
Route::middleware(['auth:sanctum','abilities:user'])->group(function() {
    Route::resource('pesanan', pesanan_controller::class)->except(
        ['create','edit']
    );
    Route::get('detail',[detail_pesanan::class,'index']);
    Route::get('user',[user_controller::class,'getAllUser']);
    Route::put('user',[user_controller::class,'updateProfile'])->middleware(['auth:sanctum','abilities']);
    Route::delete('user',[user_controller::class,'deleteAccount'])->middleware(['auth:sanctum','abilities']);
    Route::put('user/details',[user_controller::class,'getAdmin'])->middleware(['auth:sanctum','abilities']);
    Route::post('user/logout',[user_controller::class,'logout'])->middleware(['auth:sanctum','abilities']);
});

//PUBLIC
Route::get('tiket',[tiket_controller::class,'index']);
Route::get('tiket/{id}',[tiket_controller::class,'show']);
Route::get('kategori',[kategori_controller::class,'index']);
Route::get('kategori/{id}',[kategori_controller::class,'show']);

//FITUR
