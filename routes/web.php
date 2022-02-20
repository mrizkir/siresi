<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['register'=>'false', 'logout'=>false]);

Route::get('/logout',['uses'=>'App\Http\Controllers\Auth\LoginController@logout','as'=>'logout']);

Route::group(['middleware'=>['disablepreventback', 'web', 'auth']], function() {
  Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

  //Update User Details
  Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
  Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

  Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


  Route::get('/scan', [App\Http\Controllers\Transaksi\ScanResiController::class, 'scan'])->name('scan');
});
