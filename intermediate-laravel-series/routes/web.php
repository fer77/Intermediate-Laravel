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

// Route::get('test', 'WelcomeController@test');

Route::get('/', function() {
  // dd(Hash::make('password'));
  // dd(bcrypt('password'));
  // dd(app('hash')->make('password'));
  // dd(app()['hash']->make('password'));
  // dd(app('Illuminate\Hashing\BcryptHasher')->make('password'));
  // dd(app('Illuminate\Contracts\Hashing\Hasher')->make('password'));
});

Route::get('/', function() {
  return view('welcome');
});

// Test out this middleware:
Route::get('login', function() {
  $user = App\User::forceCreate([
    'name' => 'BobBelcher',
    'email' => 'bob@example.com',
    'password' => bcrypt('password')
  ]);

  Auth::login($user);

  return redirect('/');
});

Route::get('test', ['middleware' => 'subscribed', function() {
  return 'Subscription only page';
}]);
