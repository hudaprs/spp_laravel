<?php

use Illuminate\Support\Facades\Route;

/**
* CMS Route List
*/
Route::group([
    'prefix' => 'cms',
    'middleware' => 'auth',
    'namespace' => 'CMS'
], function() {
    // Dashboard
    Route::get('/', 'DashboardController@index')->name('dashboard');

    /**
     * Master Route List
     */
    Route::group([
        'namespace' => 'Master'
    ], function() {
        // Users
        Route::group([
            'namespace' => 'Users'
        ], function() {
            // Profile
            Route::get('users/{user}/profile', 'ProfileController@index')->name('users.profile');
            Route::put('users/{user}/profile', 'ProfileController@updateUserProfile')->name('users.profile-update');
            Route::put('users/{user}/profile/delete-photo', 'ProfileController@deleteUserPhotoProfile')->name('users.delete-photo-profile');
            Route::delete('users/{user}/profile/delete-account', 'ProfileController@deleteUserAccount')->name('users.delete-account');

            // Change Password
            Route::get('users/{user}/profile/change-password', 'ProfileController@editPassword')->name('users.edit-password');
            Route::put('users/{user}/profile/change-password', 'ProfileController@updatePassword')->name('users.update-password');

            // Master Routes
            Route::group([
                'prefix' => 'master'
            ], function() {
                // Users
                Route::get('users/datatables', 'UserController@userDataTables')->name('users.datatables');
                Route::resource('users', 'UserController');
            });
        });

        // Master List
        Route::group([
            'prefix' => 'master'
        ], function() {
            // Roles
            Route::get('roles/datatables', 'RoleController@roleDataTables')->name('roles.datatables');
            Route::get('roles/all', 'RoleController@getRoles')->name('roles.all');
            Route::resource('roles', 'RoleController');

            // Grades
            Route::get('grades/datatables', 'GradeController@gradeDataTables')->name('grades.datatables');
            Route::resource('grades', 'GradeController');

            // Spp
            Route::get('spp/datatables', 'SppController@sppDataTables')->name('spp.datatables');
            Route::resource('spp', 'SppController');
        });
    });
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
