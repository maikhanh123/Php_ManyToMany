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

Route::get('read', function () {
    $users = \App\User::get();

//   dd($users) ;
    foreach ($users as $user) {
        $name = $user->name;
        $roleName = '';
        foreach ($user->roles as $key => $role) {
            if ($key > 0) {
                $roleName .= ' & ' . $role->name;
            } else {
                $roleName .= $role->name;
            }

        }
        echo $name . ' have role is: ' . $roleName . '</br>';
    }
});

Route::get('update/{id}', function ($id) {
     $user = \App\User::findOrFail($id);
//     dd($user->roles);
     foreach ($user->roles as $role) {
//         dd ($role->pivot->role_id);
         if($role->pivot->role_id == 2) {
             $role->pivot->role_id = 1;
             $role->pivot->save();
         }
     }
});

//attach more role for user
Route::get('user/{userId}/attachRole/{roleId}', function ($userId, $roleId) {
    $user = \App\User::findOrFail($userId);

    $user->roles()->attach($roleId);

});

//Detach more role for user
Route::get('user/{userId}/detachRole/{roleId}', function ($userId, $roleId) {
    $user = \App\User::findOrFail($userId);

    $user->roles()->detach($roleId);

});

//sync role for user
Route::get('user/{userId}/syncRole/{roleId}', function ($userId, $roleId) {
    $user = \App\User::findOrFail($userId);

    $user->roles()->sync($roleId);

});




