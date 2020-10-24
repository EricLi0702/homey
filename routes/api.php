<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Auth\UserController@current');

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::get('users', 'Auth\UserController@userList');

    Route::get('userRole','UserRoleController@getUserRoleList');
    Route::post('userRole','UserRoleController@addUserRole');
    Route::put('userRole','UserRoleController@updateUserRole');
    Route::delete('userRole','UserRoleController@delUserRole');

    Route::get('apartment','ApartmentController@getAptList');
    Route::post('apartment','ApartmentController@addApt');
    Route::put('apartment','ApartmentController@updateApt');
    Route::delete('apartment','ApartmentController@delApt');

    Route::post('superMng','ApartmentController@addSuperMng');

    Route::get('aptBuilding','BuildingController@getBuildingList');
    Route::post('aptBuilding','BuildingController@addBuilding');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
