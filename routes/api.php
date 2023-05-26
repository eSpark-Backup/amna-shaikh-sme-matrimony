<?php

use Illuminate\Http\Request;
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

Route::group(['namespace' => 'Api'], function ()
{
	Route::post('auth/register', 'AuthController@register');
	Route::post('auth/login', 'AuthController@login');
	Route::post('auth/logout', 'AuthController@logout');
	Route::get('auth/profile', 'AuthController@profile');
	Route::post('auth/update-profile', 'AuthController@updateProfile');
	Route::post('auth/delete-account', 'AuthController@deleteAccount');

	//social login
	Route::post('auth/social-login', 'AuthController@socialLogin');

	Route::get('auth/account-settings', 'AuthController@accountSettings');
	Route::post('auth/update-account-settings', 'AuthController@updateAccountSettings');

	Route::get('auth/verify-account/{id}', 'AuthController@verifyAccount');
	Route::post('auth/resend-verification-email', 'AuthController@resendVerificationEmail');

	Route::post('auth/password/send-reset-link', 'PasswordResetController@sendResetLink');
	Route::get('auth/password/validate-reset-token/{pin}', 'PasswordResetController@validateResetToken');
	Route::post('auth/password/reset', 'PasswordResetController@reset');
	//new one for mobile verification..
	Route::post('auth/verify-mobile', 'AuthController@verifyMobile');
	Route::post('auth/check-mobile-availability', 'AuthController@checkMobileAvailability');
	Route::post('add-image', 'AuthController@store');

	Route::post('auth/update-password', 'AuthController@updatePassword');

	Route::delete('user-image/delete', 'AuthController@destroy');

	Route::get('user-image/private', 'AuthController@privateImage');
	Route::get('user-image/set-profile-image', 'AuthController@setProfileImage');
	Route::get('profile/set-approval-request', 'AuthController@setProfilePending');
	//member listing
	Route::get('members', 'MemberController@index');
	Route::get('members/detail', 'MemberController@detail');

	Route::post('members/send-interest-request', 'MemberController@interestRequest');
	Route::post('members/update-interest-request', 'MemberController@interestRequestUpdate');
	Route::post('members/cancel-interest-request', 'MemberController@interestRequestCancel');
	
	Route::post('members/add-feed-back', 'FeedBackController@addFeedBack');

	Route::get('members/list-interest-members', 'MemberController@membersListWithInterest');
	Route::get('members/list-members-received-request', 'MemberController@membersListReceivedRequest');
	Route::get('members/members-searched', 'MemberController@membersSearch');
	//plans list
	Route::get('plans', 'PlansController@index');
	//user nottifications
	Route::get('notifications', 'NotificationController@index');
	Route::post('notifications/update', 'NotificationController@update');

	Route::get('get_countries', 'CountryController@index');
	Route::get('get_states', 'StateController@index');
	Route::get('get_cities', 'CityController@index');
	Route::get('get_onbehalf', 'OnbehalfController@index');
	Route::get('get_religions', 'ProfileAttributeController@religions');
	Route::get('get_castes', 'ProfileAttributeController@castes');
	Route::get('get_languages', 'ProfileAttributeController@languages');
	Route::get('get_family_values', 'ProfileAttributeController@familyValues');
	Route::get('get_family_status', 'ProfileAttributeController@familyStatus');
	Route::get('get_marital_status', 'ProfileAttributeController@maritalStatus');
	Route::get('get_educations', 'ProfileAttributeController@educations');
	Route::get('get_occupations', 'ProfileAttributeController@occupations');
	Route::get('get_specialisations', 'ProfileAttributeController@specialisations');
	Route::get('get_working_with', 'ProfileAttributeController@workingWith');
	Route::get('get_nationality', 'ProfileAttributeController@nationality');
	Route::get('get_social_links', 'ProfileAttributeController@socialLinks');
	//story
	Route::post('add-story', 'StoryController@add_story');
	Route::get('get-stories', 'StoryController@stories');
	//message,
	Route::post('chat/send-message', 'ChatMessageController@sendMessage');
	Route::get('chats', 'ChatMessageController@index');
	Route::get('chat/conversation', 'ChatMessageController@conversation');
	Route::post('chat/change-unread-status', 'ChatMessageController@changeUnreadStatus');

	Route::delete('chat/delete', 'ChatMessageController@destroy');
	Route::get('events', 'EventController@index');
	Route::get('events/detail', 'EventController@detail');
	Route::post('events/apply', 'EventController@apply');

	Route::get('transactions', ['as' => 'transactions', 'uses' => 'MemberController@transactions']);

});
