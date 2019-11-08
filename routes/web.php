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


Route::get('/', 'HomeController@index')->name('index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/appoint', 'AppointmentController@create')->name('appointment.create');
    Route::post('/make/appoint', 'AppointmentController@store')->name('appointment.store');


    Route::group(['prefix' => 'user', ], function () {
        Route::group(['prefix' => 'appointments'], function () {
            Route::get('/', 'UserController@appointments')->name('user.appointment.list');
            Route::get('/{id}', 'UserController@viewAppoint')->name('user.appointment.view');
        });
        Route::group(['prefix' => 'pets'], function () {
            Route::get('/', 'UserController@pets')->name('user.pet.list');
            Route::get('/{id}/record/{rId}', 'UserController@viewPetRecord')->name('user.pet.record.view');
            Route::get('/{id}', 'UserController@viewPets')->name('user.pet.view');
        });
        Route::get('/settings', 'UserController@setting')->name('user.settings');
        Route::post('/settings/changeinfo', 'UserController@changeInfo')->name('user.settings.changeinfo');
        Route::post('/settings/changepassword', 'UserController@changePassword')->name('user.settings.changePassword');
    });
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

    Route::group(['prefix' => 'appointment'], function () {
        Route::get('/', 'AdminController@appointmentList')->name('admin.appointment.list');
        Route::get('/{id}', 'AdminController@appointmentRemind')->name('admin.appointment.remind');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'AdminController@userList')->name('admin.user.list');
        Route::get('/{id}', 'AdminController@userUpdate')->name('admin.user.update');
        Route::post('/{id}', 'AdminController@userUpdatePost')->name('admin.user.update.post');
    });

    Route::group(['prefix' => 'patient'], function () {
        Route::get('/', 'AdminController@patientList')->name('admin.patient.list');

        Route::get('/create', 'AdminController@patientCreate')->name('admin.patient.create');
        Route::post('/create', 'AdminController@patientCreateStore')->name('admin.patient.store');

        Route::get('/update/{id}', 'AdminController@patientUpdate')->name('admin.patient.update');
        Route::post('/update/{id}', 'AdminController@patientUpdatePost')->name('admin.patient.update.post');


        Route::get('/{id}/record/create', 'AdminController@patientRecordCreate')->name('admin.patient.record.create');
        Route::post('/{id}/record/create', 'AdminController@patientRecordCreatePost')->name('admin.patient.record.store');

        Route::get('/{id}/record/{rId}', 'AdminController@patientRecordView')->name('admin.patient.record.view');
        Route::get('/{id}', 'AdminController@patientView')->name('admin.patient.view');
    });
});