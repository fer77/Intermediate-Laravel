<?php

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
  // dd(app('Illuminate\Config\Repository')['database']['default']);
  // dd(app('Illuminate\Contracts\Config\Repository')['database']['default']);
  // dd(app('config')['database']['default']);
  // dd(app()['config']['database']['default']);
  // dd(Config::get('database.default'));
  // dd(app('Illuminate\Contracts\Config\Repository'));
});

Route::get('test', 'WelcomeController@test');
