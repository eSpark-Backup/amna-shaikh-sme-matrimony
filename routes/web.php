<?php

use Illuminate\Support\Facades\Route;

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
//custom routes

Route::get('admin/login', 'Auth\Admin\LoginController@login')->name('admin.auth.login');

Route::post('admin/login', 'Auth\Admin\LoginController@loginAdmin')->name('admin.auth.loginAdmin');

/*Route::get('general-settings',['as' => 'general-settings', 'uses' => 'GeneralSettingController@index']);*/

Route::any('admin/logout', 'Auth\Admin\LoginController@logout')->name('admin.auth.logout');

Route::get('admin/forgot-password', 'Auth\Admin\ForgotPasswordController@forgotPasswordForm')->name('admin.auth.forgot-password');

Route::post('admin/send-reset-link-email', 'Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.auth.send-reset-link-email');

Route::get('admin/reset-password/{token}', 'Auth\Admin\ForgotPasswordController@resetPasswordForm');
Route::post('admin/reset-password', 'Auth\Admin\ForgotPasswordController@resetPassword')->name('admin.auth.reset-password');

Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:admin','admin.check.status']], function ()
{
	Route::get('/', 'DashboardController@dashboard')->name('dashboard');
    Route::get('/dashboard', 'DashboardController@dashboard')->name('admin.dashboard');
    //manage admin profile
    Route::get('manage-profile', 'AdminController@manageProfile')->name('manage-profile');

    Route::resource('admins', 'AdminController');
    Route::resource('plans', 'PlanController');
    //export members
    Route::post('members/export', 'MemberController@export');

    //members listing
    Route::resource('members', 'MemberController');
    Route::get('members/{id}/view-chat-members', 'MemberController@viewChatMembers');
    Route::resource('email-templates', 'EmailTemplateController');
    Route::resource('onbehalf', 'OnbehalfController');
    Route::resource('countries', 'CountryController');
    Route::resource('states', 'StateController');
    Route::resource('cities', 'CityController');
    Route::resource('castes', 'CasteController');
    Route::resource('religions', 'ReligionController');
    Route::resource('languages', 'LanguageController');
    Route::resource('family-values', 'FamilyValueController');
    Route::resource('family-status', 'FamilyStatusController');
    Route::resource('marital-status', 'MaritalStatusController');
    Route::resource('educations', 'EducationController');
    Route::resource('occupations', 'OccupationController');
    Route::resource('specialisations', 'SpecialisationController');
    Route::resource('working-with', 'WorkingWithController');
    Route::resource('nationality', 'NationalityController');
    Route::resource('stories', 'StoryController');
    Route::get('stories/{id}/view-story', 'StoryController@view_story');
    Route::get('general-settings',['as' => 'general-settings', 'uses' => 'GeneralSettingController@index']);
    Route::post('general-settings/update', 'GeneralSettingController@update');
    Route::get('seo-settings', 'SeoSettingController@index');
    Route::post('seo-settings/update', 'SeoSettingController@update');
    Route::get('feedback', 'FeedBackController@index');
    Route::get('feedback/{id}/view', 'FeedBackController@view');
    Route::get('members/{id}/profile', 'MemberController@profile');
    Route::get('members/{id}/download', 'MemberController@download');
    //events
    Route::resource('events', 'EventController');

    Route::get('events-audience/{id}/get-audiences', 'EventAudienceController@get_audience');
    //for datatable
    Route::get('events-audience/audiences/{id}', 'EventAudienceController@audiences');

    Route::get('events-audience/guests/{id}','EventAudienceController@get_guests');
    Route::post('events-audience/update-guest','EventAudienceController@update_guest');
    Route::post('events-audience/request-approved','EventAudienceController@request_approved');

    Route::delete('events-audience/delete-guest/{id}','EventAudienceController@delete_guest');


    Route::resource('sibling', 'SiblingController');
    /*Route::get('events/audience', 'EventController@audiences_ajax');
    Route::get('events/{id}/audiences', 'EventController@audiences');*/
});

// ******************** //
//     App Routes
// ******************** //

//Route::get('/', 'AppController@index');
Route::get('/', ['as' => 'homes', 'uses' => 'AppController@index']);
Route::get('/home', ['as' => 'home', 'uses' => 'AppController@index']);
Route::get('events', ['as' => 'events', 'uses' => 'AppController@events']);
Route::get('events/{id}', ['as' => 'event-details', 'uses' => 'AppController@eventDetails']);
Route::get('past-events', ['as' => 'past-events', 'uses' => 'AppController@past_events']);

Route::get('plans', ['as' => 'plans', 'uses' => 'AppController@plans']);
Route::get('stories', ['as' => 'stories', 'uses' => 'AppController@stories']);
Route::get('stories/{id}', ['as' => 'story-details', 'uses' => 'AppController@storyDetails']);
Route::get('privacy-policy', ['as' => 'privacy-policy', 'uses' => 'AppController@privacyPolicy']);

Route::get('terms-conditions', ['as' => 'terms-condition', 'uses' => 'AppController@termsCondition']);
Route::get('stripe-autopayment', ['as' => 'stripe-autopayment', 'uses' => 'AppController@stripeAutoRecurringPlan']);
Route::get('not-approved-user', ['as' => 'not-approved-user', 'uses' => 'AppController@notApprovedUser']);

Route::get('/verify-account/{id}', 'AppController@emailVerification');
Route::get('/unsubscribe-payment/{email}', 'AppController@unsubscribe_payment')->name('unsubscribe-payment');
Route::get('contact-us', ['as' => 'contact-us', 'uses' => 'AppController@contactUs']);

Route::post('send-contact-us', 'AppController@contactUsSend')->name('send-contact-us');

///user auth
Route::get('login', 'Auth\User\LoginController@login')->name('login');
//login form handler
Route::post('login', 'Auth\User\LoginController@loginUser')->name('user.auth.loginUser');
Route::get('register', 'Auth\User\LoginController@register')->name('register');
Route::post('register', 'Auth\User\LoginController@registerUser')->name('user.auth.registerUser');

Route::any('logout', 'Auth\User\LoginController@logout')->name('user.auth.logout');

// ******************** //
//     Social media login
// ******************** //

Route::get('auth/google', 'Auth\User\LoginController@redirectToGoogle')->name('user.auth.redirect-togoogle');
Route::get('auth/google/callback', 'Auth\User\LoginController@handleGoogleCallback')->name('user.auth.handle_googlecallback');

Route::get('auth/facebook', 'Auth\User\LoginController@redirectToFb')->name('user.auth.redirect-fb');
Route::get('auth/facebook/callback', 'Auth\User\LoginController@handleFbCallback')->name('user.auth.handle_fbcallback');


// ******************** //
//     App forgot password
// ******************** //

Route::get('forgot-password', 'Auth\User\ForgotPasswordController@forgotPasswordForm')->name('auth.forgot-password');

Route::post('send-reset-link-email', 'Auth\User\ForgotPasswordController@sendResetLinkEmail')->name('auth.send-reset-link-email');

Route::get('reset-password/{token}', 'Auth\User\ForgotPasswordController@resetPasswordForm');

Route::post('reset-password', 'Auth\User\ForgotPasswordController@resetPassword')->name('auth.reset-password');


// ******************** //
//    Mobile Verify
// ******************** //

Route::get('/firebase-phone-authentication', 'Auth\User\LoginController@firebasePhoneAuthentication')->middleware('auth:user');

Route::post('verify-mobile-code', 'Auth\User\LoginController@verifyMobileCode')->name('verify-mobile-code')->middleware('auth:user');


// ******************** //
//     User Routes
// ******************** //


Route::group(['namespace' => 'User', 'as' => 'user.', 'prefix' => 'user', 'middleware' => ['auth:user','user.check.status']], function ()
{
    //Route::get('/', 'UserController@members')->name('members');
    Route::get('members', ['as' => 'members', 'uses' => 'UserController@members']);


    Route::get('members/{id}', ['as' => 'member-details', 'uses' => 'UserController@memberDetails']);

    Route::post('send-interest-request', 'UserController@interestRequest' );
    Route::post('report-user', 'UserController@reportUser')->name('report-user');

    Route::get('interests', 'UserController@interest')->name('interests');

    Route::post('show-interest', 'UserController@showInterest');
    Route::post('update-interest-request', 'UserController@interestRequestUpdate');
    Route::get('profile', 'UserController@profile')->name('profile');
    //display profile form
    Route::get('edit-profile', 'UserController@editProfile')->name('edit-profile');
    Route::get('picture-privacy', 'UserController@picture_privacy')->name('picture-privacy');
    Route::post('/{user}/photo/change', 'UserController@change_photo')->name('users_change_photo');
    Route::post('/photo/add', 'UserController@add_photo')->name('users_add_photo');
    //form ll be saved into database..
    Route::post('profile-update', 'UserController@profileUpdate')->name('profile-update');
    Route::post('privacy-update', 'UserController@privacyUpdate')->name('privacy-update');
    //submit for approval
    Route::post('profile-submit-for-approval', 'UserController@profileApproval')->name('profile-submit-for-approval');
    Route::post('image-action', 'UserController@imageAction')->name('image-action');
    //chat listing...
    Route::post('chat/send-message', 'UserController@sendMessage')->name('send-message');
    Route::get('chats', 'UserController@chatListing')->name('chat-listing');
    Route::get('/{user}/chat', 'UserController@userChat')->name('user-chat');
    Route::get('/events/apply/{id}', 'UserController@eventApply')->name('apply_on_event');

    Route::post('/events/stripe', 'UserController@stripePost')->name('stripe');
    Route::get('/thank-you/{msg}', 'UserController@thank_you')->name('thank-you');
    Route::get('/thankyou/{msg}', 'UserController@thankyou')->name('thankyou');
    Route::get('/settings', 'UserController@settings')->name('settings');
    Route::get('/settings/change-password', 'UserController@changePassword')->name('change-password');
    Route::get('/settings/feedback', 'UserController@feedback')->name('feedback');
    Route::get('/settings/close-account', 'UserController@closeAccount')->name('close-account');
    Route::post('settings/update-password', 'UserController@updatePassword')->name('settings.update-password');
    Route::post('settings/post-feedback', 'UserController@postFeedback')->name('settings.post-feedback');
    Route::post('settings/successstory', 'UserController@postSuccessStory')->name('settings.post-success-story');
    Route::post('settings/delete-account', 'UserController@deleteAccount')->name('settings.post-delete-account');

    //Notification section
    Route::get('/notifications', 'UserController@my_notifications')->name('my_notifications');
    Route::post('/notifications/clearAllNotification', 'UserController@clearAllNotification')->name('clearAllNotification');
    // Route::post('/notifications/readAllNotification', 'UserController@readAllNotification')->name('readAllNotification');

    Route::get('/plans/buy/{id}', 'UserController@buyPlan')->name('buy_plan');
    Route::post('/plans/buy-plan', 'UserController@stripePostPlan')->name('buy-stripe');

    Route::post('/add-stripe-card', 'UserController@addMemberStripeCustomerField')->name('add-stripe-card');
    Route::post('settings/delete-payment_method', 'UserController@deletePaymentMethod')->name('settings.post-delete-payment_method');
    Route::get('transactions', ['as' => 'transactions', 'uses' => 'UserController@transactions']);
});


Route::get('test',function (){
    return view('emails.template_new');
});





