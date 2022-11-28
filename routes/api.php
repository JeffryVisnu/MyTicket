<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\tiket_controller;
use App\Http\Controllers\admincontroller;
use App\Http\Controllers\kategori_Controller;
use App\Http\Controllers\pesanan_controller;
use App\Http\Controllers\user_controller;
use App\Http\Controllers\pembayaran_controller;

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

    //TIKET
    Route::post('tiket',[tiket_controller::class,'store']);
    Route::put('tiket/{id}',[tiket_controller::class,'update']);
    Route::delete('tiket/{id}',[tiket_controller::class,'destroy']);

    //KATEGORI
    Route::resource('kategori', kategori_controller::class)->except(
        ['create','edit','index','show']
    );

    //PEMBAYARAN
    Route::get('pembayarans',[pembayaran_controller::class,'index']);
    Route::get('pembayaran/{id}',[pembayaran_controller::class,'show']);
    Route::delete('pembayaran/{id}',[pembayaran_controller::class,'destroy']);

    //PESANAN
    Route::get('pesanan/status/1',[pesanan_controller::class,'getStatusSudahBayar']);
    Route::get('pesanan/status/0',[pesanan_controller::class,'getStatusBelumBayar']);

    //ACCOUNT
    Route::get('users',[user_controller::class,'getAllUser']);
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

    //PESANAN
    Route::resource('pesanan', pesanan_controller::class)->except(
        ['create','edit']
    );
    
    //PEMBAYARAN
    Route::post('pembayaran',[pembayaran_controller::class,'store'])->middleware(['auth:sanctum','abilities:user']);
    Route::get('pembayaranByUser', [pembayaran_controller::class, 'getByUser'])->middleware(['auth:sanctum','abilities:user']);

    //ACCOUNT
    Route::put('user',[user_controller::class,'updateProfile'])->middleware(['auth:sanctum','abilities:user']);
    Route::delete('user',[user_controller::class,'deleteAccount'])->middleware(['auth:sanctum','abilities:user']);
    Route::get('user',[user_controller::class,'getAdmin'])->middleware(['auth:sanctum','abilities:user']);
    Route::post('user/logout',[user_controller::class,'logout'])->middleware(['auth:sanctum','abilities:user']);
});

//PUBLIC
Route::get('tiket',[tiket_controller::class,'index']);
Route::get('tiket/{id}',[tiket_controller::class,'show']);
Route::get('kategori',[kategori_controller::class,'index']);
Route::get('kategori/{id}',[kategori_controller::class,'show']);
