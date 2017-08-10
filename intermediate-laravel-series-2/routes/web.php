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

// Route::get('reports', 'ReportsController@index');

// use App\User;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('login', function() {
//   User::truncate();
  
//   $user = User::create([
//     'name'=>'BobBelcher',
//     'email'=>"bob@example.com",
//     'password'=>bcrypt('password'),
//     'plan'=>'yearly'
//   ]);

//   Auth::login($user);

//   return redirect('/');
// });

// Route::get('test', ['middleware' => 'subscribed:yearly', function() {
//   return 'You can only view this page if you are logged in and subscribed to the yearly plan';
// }]);
