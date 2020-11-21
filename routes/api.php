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
    Route::get('users', 'Auth\UserController@userList');
    Route::get('adminusers', 'Auth\UserController@adminUserList');
    Route::post('users','Auth\UserController@addUser');
    Route::delete('users','Auth\UserController@delUser');
    Route::put('users','Auth\UserController@updateUser');

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
    Route::post('settings/avatar', 'Settings\ProfileController@updateAvatar');


    Route::get('userRole','UserRoleController@getUserRoleList');
    Route::post('userRole','UserRoleController@addUserRole');
    Route::put('userRole','UserRoleController@updateUserRole');
    Route::delete('userRole','UserRoleController@delUserRole');

    Route::get('apartment','ApartmentController@getAptList');
    Route::post('apartment','ApartmentController@addApt');
    Route::put('apartment','ApartmentController@updateApt');
    Route::delete('apartment','ApartmentController@delApt');
    Route::put('apartment/auto','ApartmentController@updateAutoMode');
    
    Route::post('notification/create', 'NotificationController@store');
    Route::get('notification/draft', 'NotificationController@getDraft');
    Route::get('notification', 'NotificationController@index');
    Route::delete('notification', 'NotificationController@delete');
    Route::get('notification/current', 'NotificationController@getCurrent');
    Route::post('notification/view', 'NotificationController@addView');
    Route::put('notification', 'NotificationController@update');
    Route::put('notification/down', 'NotificationController@downgrade');
    Route::put('notification/up', 'NotificationController@upgrade');
    Route::get('notification/downgrade', 'NotificationController@indexDowngrade');
    Route::get('notification/first', 'NotificationController@getFirstItemID');
    Route::get('notification/last', 'NotificationController@getLastItemID');
    Route::get('notification/previous', 'NotificationController@getPreviousItemID');
    Route::get('notification/next', 'NotificationController@getNextItemID');
    
    Route::post('facility/create', 'FacilityController@store');
    Route::get('facility', 'FacilityController@index');
    Route::delete('facility', 'FacilityController@delete');
    
    Route::post('reservation/create', 'ReservationFacilityController@store');
    Route::get('reservation', 'ReservationFacilityController@index');
    Route::delete('reservation', 'ReservationFacilityController@delReservation');
    Route::put('reservation/allow', 'ReservationFacilityController@allowReservation');
    Route::put('reservation/deny', 'ReservationFacilityController@denyReservation');
    
    Route::post('repair/create', 'RepairController@store');
    Route::get('repair', 'RepairController@index');
    Route::get('repair/current', 'RepairController@getCurrent');
    Route::post('repair/response', 'RepairController@response');
    Route::delete('repair','RepairController@deleteRepair');
    Route::post('repair/finish','RepairController@finish');
    Route::get('repair/first', 'RepairController@getFirstItemID');
    Route::get('repair/last', 'RepairController@getLastItemID');
    Route::get('repair/previous', 'RepairController@getPreviousItemID');
    Route::get('repair/next', 'RepairController@getNextItemID');
    Route::get('repair/json', 'RepairController@getRepairType');
    Route::put('repair/json', 'RepairController@postRepairType');
    

    Route::post('community/create', 'CommunityController@store');
    Route::get('community', 'CommunityController@index');
    Route::get('community/current', 'CommunityController@getCurrent');
    Route::put('community/remove', 'CommunityController@remove');
    Route::put('community/update', 'CommunityController@update');
    Route::post('community/view', 'CommunityController@addView');
    Route::get('community/first', 'CommunityController@getFirstItemID');
    Route::get('community/last', 'CommunityController@getLastItemID');
    Route::get('community/previous', 'CommunityController@getPreviousItemID');
    Route::get('community/next', 'CommunityController@getNextItemID');
    Route::post('community/comment', 'CommentOfCommunityController@leaveComment');
    Route::get('community/comment', 'CommentOfCommunityController@getComment');
    Route::put('community/comment', 'CommentOfCommunityController@removeComment');
    Route::post('community/reply', 'CommentOfCommunityController@replyToComment');
    


    Route::post('suggestion/create', 'SuggestionController@store');
    Route::get('suggestion', 'SuggestionController@index');
    Route::get('suggestion/current', 'SuggestionController@getCurrent');
    Route::put('suggestion/remove', 'SuggestionController@remove');
    Route::put('suggestion/update', 'SuggestionController@update');
    Route::get('suggestion/first', 'SuggestionController@getFirstItemID');
    Route::get('suggestion/last', 'SuggestionController@getLastItemID');
    Route::get('suggestion/previous', 'SuggestionController@getPreviousItemID');
    Route::get('suggestion/next', 'SuggestionController@getNextItemID');
    
    Route::post('suggestion/comment', 'CommentOfSuggestionController@leaveComment');
    Route::get('suggestion/comment', 'CommentOfSuggestionController@getComment');
    Route::put('suggestion/comment', 'CommentOfSuggestionController@removeComment');
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
    Route::delete('aptBuilding','BuildingController@delBuilding');
    Route::put('aptBuilding','BuildingController@updateBuilding');
    
    //PushNotification
    Route::post('newPush','Auth\UserController@newPush');
    Route::post('removePushNotification','Auth\UserController@removePushNotification');
    Route::post('removePushSuggestion','Auth\UserController@removePushSuggestion');
    Route::post('removePushCommunity','Auth\UserController@removePushCommunity');
    
    Route::get('newPush','Auth\UserController@getNewPush');

    //get top 5 categories
    Route::get('top5Notification','NotificationController@getTop5Notification');
    Route::get('top5Community','CommunityController@getTop5Coummunity');
    Route::get('top5Suggestion','SuggestionController@getTop5Suggestion');
    Route::get('top5Repair','RepairController@getTop5Repair');

    Route::get('notificationCnt','NotificationController@getNotificationCnt');
    Route::get('communityCnt','CommunityController@getCommunityCnt');
    Route::get('suggestionCnt','SuggestionController@getSuggestionCnt');
    Route::get('repairCnt','RepairController@getRepairCnt');
    Route::get('reservatoinCnt','ReservationFacilityController@getReservationCnt');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('verify', 'Auth\RegisterController@verify');
    Route::post('verifycode', 'Auth\RegisterController@verifycode');
    Route::post('setpassword', 'Auth\RegisterController@setpassword');

    Route::post('password/email', 'Auth\RegisterController@sendResetCodeToEmail');
    Route::post('password/verifycode', 'Auth\RegisterController@verifycodeResetPass');
    Route::post('password/setpassword', 'Auth\RegisterController@setpasswordResetPass');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
