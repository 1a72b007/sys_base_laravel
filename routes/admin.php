<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;

Route::get('/', function () {
    Auth::logout();
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => ['get.menu', 'login.check', 'permission_check']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard.homepage');
    });
    
    Route::resource('users',        'UsersController');
    Route::resource('roles',        'RolesController');
    Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
    Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
    Route::prefix('menu/element')->group(function () { 
        Route::get('/',             'MenuElementController@index')->name('menu.index');
        Route::get('/move-up',      'MenuElementController@moveUp')->name('menu.up');
        Route::get('/move-down',    'MenuElementController@moveDown')->name('menu.down');
        Route::get('/create',       'MenuElementController@create')->name('menu.create');
        Route::post('/store',       'MenuElementController@store')->name('menu.store');
        Route::get('/get-parents',  'MenuElementController@getParents');
        Route::get('/edit',         'MenuElementController@edit')->name('menu.edit');
        Route::post('/update',      'MenuElementController@update')->name('menu.update');
        Route::get('/show',         'MenuElementController@show')->name('menu.show');
        Route::get('/delete',       'MenuElementController@delete')->name('menu.delete');
    });
    Route::prefix('menu/menu')->group(function () { 
        Route::get('/',         'MenuController@index')->name('menu.menu.index');
        Route::get('/create',   'MenuController@create')->name('menu.menu.create');
        Route::post('/store',   'MenuController@store')->name('menu.menu.store');
        Route::get('/edit',     'MenuController@edit')->name('menu.menu.edit');
        Route::post('/update',  'MenuController@update')->name('menu.menu.update');
        Route::get('/delete',   'MenuController@delete')->name('menu.menu.delete');
    });

    // 會員資料
    Route::prefix('profile')->group(function () {
        //基本資料
        Route::get('/', 'UsersController@profile')->name('user.profile');
        Route::patch('/', 'UsersController@profileModify')->name('user.profile_modify');
    
        Route::patch('/change_password', 'UsersController@changePassword')->name('user.change_password');
    });
});