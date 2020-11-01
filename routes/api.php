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
    Route::post('settings/avatar', 'Settings\ProfileController@updateAvatar');

    Route::get('users', 'Auth\UserController@userList');
    Route::post('users','Auth\UserController@addUser');

    Route::get('userRole','UserRoleController@getUserRoleList');
    Route::post('userRole','UserRoleController@addUserRole');
    Route::put('userRole','UserRoleController@updateUserRole');
    Route::delete('userRole','UserRoleController@delUserRole');

    Route::get('apartment','ApartmentController@getAptList');
    Route::post('apartment','ApartmentController@addApt');
    Route::put('apartment','ApartmentController@updateApt');
    Route::delete('apartment','ApartmentController@delApt');
    
    Route::post('notification/create', 'NotificationController@store');
    Route::get('notification', 'NotificationController@index');
    Route::delete('notification', 'NotificationController@delete');
    Route::get('notification/current', 'NotificationController@getCurrent');
    Route::post('notification/view', 'NotificationController@addView');
    Route::put('notification', 'NotificationController@update');
    Route::put('notification/down', 'NotificationController@downgrade');
    Route::put('notification/up', 'NotificationController@upgrade');
    Route::get('notification/downgrade', 'NotificationController@indexDowngrade');
    
    Route::post('facility/create', 'FacilityController@store');
    Route::get('facility', 'FacilityController@index');
    
    Route::post('reservation/create', 'ReservationFacilityController@store');
    Route::get('reservation', 'ReservationFacilityController@index');
    
    Route::post('repair/create', 'RepairController@store');
    Route::get('repair', 'RepairController@index');
    Route::get('repair/current', 'RepairController@getCurrent');


    Route::post('suggestion/create', 'SuggestionController@store');
    Route::get('suggestion', 'SuggestionController@index');
    Route::get('suggestion/current', 'SuggestionController@getCurrent');
    Route::post('suggestion/comment', 'CommentOfSuggestionController@leaveComment');
    Route::get('suggestion/comment', 'CommentOfSuggestionController@getComment');
    Route::post('suggestion/view', 'SuggestionController@addView');
    Route::post('suggestion/heart', 'SuggestionController@addHeart');
    Route::post('suggestion/unheart', 'SuggestionController@removeHeart');
    Route::post('suggestion/like', 'SuggestionController@addLike');
    Route::post('suggestion/unlike', 'SuggestionController@removeLike');
    Route::post('suggestion/dislike', 'SuggestionController@addDislike');
    Route::post('suggestion/undislike', 'SuggestionController@removeDislike');

    Route::post('fileUpload/image','UploadController@imageUpload');
    Route::post('fileUpload/other','UploadController@otherUpload');
    Route::post('fileUpload/video','UploadController@videoUpload');
    Route::delete('fileUpload/file','UploadController@deleteFile');
    Route::post('superMng','ApartmentController@addSuperMng');

    Route::get('aptBuilding','BuildingController@getBuildingList');
    Route::post('aptBuilding','BuildingController@addBuilding');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('verify', 'Auth\RegisterController@verify');
    Route::post('verifycode', 'Auth\RegisterController@verifycode');
    Route::post('setpassword', 'Auth\RegisterController@setpassword');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
