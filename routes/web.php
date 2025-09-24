<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheckMiddleware;

Route::middleware(['auth:admin'])->group(function () {

    // Admin Home
    Route::get('/admin/home', function () {
        return view('Admin.home');
    })->name('admin.home');


    // Add Sub Admin
    Route::get('/admin/AddSubAdmin', function () {
        return view('Admin.add_event');
    })->name('admin.AddSubAdmin');

    Route::get('/admin/profile', 'Admin\AdminController@profile')->name('admin.profile');
    Route::post('/admin/profile', 'Admin\AdminController@ProfileUpdate')->name('admin.profile.update');

    Route::get('admin/logout', 'Admin\AdminController@logout')->name('admin.logout');

    // Event Routes
    Route::get('admin/manageEvent', 'Admin\EventController@index')->name('admin.manageEvent');
    Route::get('admin/addEvent', 'Admin\EventController@create')->name('admin.addEvent');
    Route::post('admin/storeEvent', 'Admin\EventController@store')->name('admin.storeEvent');
    // Route::get('admin/ShowEvent/{id}', 'Admin\EventController@show')->name('admin.ShowEvent');
    // Route::get('admin/EditEvent/{id}', 'Admin\EventController@edit')->name('admin.EditEvent');
    // Route::post('admin/UpdateEvent/{id}', 'Admin\EventController@update')->name('admin.UpdateEvent');
    // Route::delete('admin/DeleteEvent/{id}', 'Admin\EventController@destroy')->name('admin.DeleteEvent');

    // SubAdmin Routes
    Route::get('admin/manageSubAdmin', 'Admin\SubAdminController@index')->name('admin.manageSubAdmin');
    Route::get('admin/addSubAdmin', 'Admin\SubAdminController@create')->name('admin.addSubAdmin');
    Route::post('admin/storeSubAdmin', 'Admin\SubAdminController@store')->name('admin.storeSubAdmin');
    // Route::get('admin/ShowSubAdmin/{id}', 'Admin\SubAdminController@show')->name('admin.ShowSubAdmin');
    // Route::get('admin/EditSubAdmin/{id}', 'Admin\SubAdminController@edit')->name('admin.EditSubAdmin');
    // Route::post('admin/UpdateSubAdmin/{id}', 'Admin\SubAdminController@update')->name('admin.UpdateSubAdmin');
    // Route::delete('admin/DeleteSubAdmin/{id}', 'Admin\SubAdminController@destroy')->name('admin.DeleteSubAdmin');


});

Route::middleware([AdminCheckMiddleware::class])->group(function () {

    // Show login form 
    Route::get('/admin/login', function () {
        return view('Admin.login');
    })->name('admin.login');

    // Handle login form submit 
    Route::post('/admin/login', 'Admin\AdminController@login')->name('admin.login.submit');
});


// User Roure
Route::get('/user/home', function () {
    return view('User.home');
});

Route::get('/user/event-details', function () {
    return view('User.event-details');
});

Route::get('/user/booking', function () {
    return view('User.booking');
});

Route::get('/user/login', function () {
    return view('User.login');
})->name('user.login');

Route::get('user/register', function () {
    return view('User.register');
})->name('user.register');
