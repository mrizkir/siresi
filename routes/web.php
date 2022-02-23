<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes(['register'=>'false', 'logout'=>false]);

Route::get('/logout',['uses'=>'App\Http\Controllers\Auth\LoginController@logout','as'=>'logout']);

Route::group(['middleware'=>['disablepreventback', 'web', 'auth']], function() {
  Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');  

  Route::get('/scan', [App\Http\Controllers\Transaksi\ScanResiController::class, 'scan'])->name('scan');

  //setting - pengguna

  //setting - pengguna - picker
  Route::resource('/setting/userpicker', App\Http\Controllers\Setting\UserPickerController::class, [
    'middleware' => ['role:superadmin'],
    'parameters' => [
      'userpicker'=>'id'
    ],
  ]);

});
