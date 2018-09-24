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
    return view('welcome');
});

Route::get('/createUser', function () {
    $user = \App\User::create(['name' => 'Tuan', 'email' => 'vantuan@gmail.com', 'password' => bcrypt('123')]);
    return $user;
});

Route::get('user/{id}/createRole', function ($id) {
    $user = \App\User::findOrFail($id);
//    $role = new \App\Role(['name'=>'Subscriber']);
//    return $user->roles()->save($role);

    $roles = \App\Role::where('name', 'Subscriber')->get();
    foreach ($roles as $role) {
        return $user->roles()->save($role);
    }

});


