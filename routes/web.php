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

Route::get('/', 'GuestController@home')->name('guest-home');
Route::get('/credits', 'GuestController@credits')->name('guest-credits');
Route::post('/guestLogin', 'GuestController@login')->name('guest-login');
Route::post('/forgotPassword', 'GuestController@forgotPassword')->name('guest-forgotPassword');
Route::post('/requestInvitation', 'GuestController@requestInvitation')->name('guest-requestInvitation');
Route::post('/resetPassword', 'GuestController@resetPassword')->name('guest-resetPassword');
Route::post('/resetPasswordSubmission', 'GuestController@resetPasswordSubmission')->name('guest-resetPasswordSubmission');
Route::get('/cookiePolicy', 'GuestController@cookiePolicy')->name('guest-cookiePolicy');

Route::get('/signUp', 'GuestController@signUp')->name('guest-signUp');
Route::post('/signUpSubmission', 'GuestController@signUpSubmission')->name('guest-signUpSubmission');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/changeSearchKey', 'UserController@changeSearchKey')->name('user-changeSearchKey');
    Route::match(['get', 'post'], '/browseListings', 'UserController@browseListings')->name('user-browseListings');
    Route::post('/saveUsersListing', 'UserController@saveUsersListing')->name('user-saveUsersListing');

    Route::get('/savedListings', 'UserController@savedListings')->name('user-savedListings');
    Route::post('/removeSavedListing', 'UserController@removeSavedListing')->name('user-removeSavedListing');

    Route::get('/myListings', 'UserController@myListings')->name('user-myListings');
    Route::get('/connections', 'UserController@connections')->name('user-connections');
    Route::post('/deleteConnection', 'UserController@deleteConnection')->name('user-deleteConnection');
    Route::post('/denyConnection', 'UserController@denyConnection')->name('user-denyConnection');
    Route::post('/approveConnection', 'UserController@approveConnection')->name('user-approveConnection');
    Route::get('/createListing', 'UserController@createListing')->name('user-createListing');
    Route::post('/deleteListing', 'UserController@deleteListing')->name('user-deleteListing');
    Route::post('/saveListing', 'UserController@saveListing')->name('user-saveListing');
    Route::post('/submitListingForReview', 'UserController@submitListingForReview')->name('user-submitListingForReview');
    Route::get('/editListing/{listingID}', 'UserController@editListing')->name('user-editListing');
    Route::post('/deleteListingImage', 'UserController@deleteListingImage')->name('user-deleteListingImage');
    Route::get('/reviewListing/{listingID}', 'UserController@reviewListing')->name('user-reviewListing');
    Route::post('/postListing', 'UserController@postListing')->name('user-postListing');
    Route::post('/submitListingForApproval', 'UserController@submitListingForApproval')->name('user-submitListingForApproval');
    Route::post('/requestConnection', 'UserController@requestConnection')->name('user-requestConnection');
    Route::post('/cancelConnectionRequest', 'UserController@cancelConnectionRequest')->name('user-cancelConnectionRequest');
        
    Route::group(['middleware' => 'AdminOnly'], function () {
        Route::get('/listingsPendingReview', 'AdminController@listingsPendingReview')->name('admin-listingsPendingReview');
        Route::post('/denyListing', 'AdminController@denyListing')->name('admin-denyListing');
        Route::get('/requests', 'AdminController@requests')->name('admin-requests');
        Route::post('/denyRequest', 'AdminController@denyRequest')->name('admin-denyRequest');
        Route::post('/messageRequestSender', 'AdminController@messageRequestSender')->name('admin-messageRequestSender');
        Route::post('/approveRequest', 'AdminController@approveRequest')->name('admin-approveRequest');
        Route::get('/ndasPendingReview', 'AdminController@ndasPendingReview')->name('admin-ndasPendingReview');
        Route::post('/denyNDA', 'AdminController@denyNDA')->name('admin-denyNDA');
        Route::post('/approveNDA', 'AdminController@approveNDA')->name('admin-approveNDA');
        Route::get('/manageWebsite', 'AdminController@manageWebsite')->name('admin-manageWebsite');
        Route::post('/updateTheme', 'AdminController@updateTheme')->name('admin-updateTheme');
        Route::post('/updateHomepage', 'AdminController@updateHomepage')->name('admin-updateHomepage');
        Route::post('/updateCredits', 'AdminController@updateCredits')->name('admin-updateCredits');
        Route::post('/updateCookie', 'AdminController@updateCookie')->name('admin-updateCookie');
        Route::post('/updateNDA', 'AdminController@updateNDA')->name('admin-updateNDA');
    });
    
    Route::get('/profile', 'UserController@profile')->name('user-profile');
    Route::get('/manageAccount', 'UserController@manageAccount')->name('user-manageAccount');
    Route::post('/submitNDA', 'UserController@submitNDA')->name('user-submitNDA');
    Route::post('/submitChangePassword', 'UserController@submitChangePassword')->name('user-submitChangePassword');
    Route::post('/submitUpdateAccount', 'UserController@submitUpdateAccount')->name('user-submitUpdateAccount');
    Route::get('/logout', 'UserController@logout')->name('user-logout');
});
/*
Route::post('/changeSearchKey', 'UserController@changeSearchKey')->name('user-changeSearchKey')->middleware('UsersOnly');
Route::match(['get', 'post'], '/browseListings', 'UserController@browseListings')->name('user-browseListings')->middleware('UsersOnly');
Route::post('/saveUsersListing', 'UserController@saveUsersListing')->name('user-saveUsersListing')->middleware('UsersOnly');

Route::get('/savedListings', 'UserController@savedListings')->name('user-savedListings')->middleware('UsersOnly');
Route::post('/removeSavedListing', 'UserController@removeSavedListing')->name('user-removeSavedListing')->middleware('UsersOnly');

Route::get('/myListings', 'UserController@myListings')->name('user-myListings')->middleware('UsersOnly');
Route::get('/connections', 'UserController@connections')->name('user-connections')->middleware('UsersOnly');
Route::post('/deleteConnection', 'UserController@deleteConnection')->name('user-deleteConnection')->middleware('UsersOnly');
Route::post('/denyConnection', 'UserController@denyConnection')->name('user-denyConnection')->middleware('UsersOnly');
Route::post('/approveConnection', 'UserController@approveConnection')->name('user-approveConnection')->middleware('UsersOnly');
Route::get('/createListing', 'UserController@createListing')->name('user-createListing')->middleware('UsersOnly');
Route::post('/deleteListing', 'UserController@deleteListing')->name('user-deleteListing')->middleware('UsersOnly');
Route::post('/saveListing', 'UserController@saveListing')->name('user-saveListing')->middleware('UsersOnly');
Route::post('/submitListingForReview', 'UserController@submitListingForReview')->name('user-submitListingForReview')->middleware('UsersOnly');
Route::get('/editListing/{listingID}', 'UserController@editListing')->name('user-editListing')->middleware('UsersOnly');
Route::post('/deleteListingImage', 'UserController@deleteListingImage')->name('user-deleteListingImage')->middleware('UsersOnly');
Route::get('/reviewListing/{listingID}', 'UserController@reviewListing')->name('user-reviewListing')->middleware('UsersOnly');
Route::post('/postListing', 'UserController@postListing')->name('user-postListing')->middleware('UsersOnly');
Route::post('/submitListingForApproval', 'UserController@submitListingForApproval')->name('user-submitListingForApproval')->middleware('UsersOnly');
Route::post('/requestConnection', 'UserController@requestConnection')->name('user-requestConnection')->middleware('UsersOnly');
Route::post('/cancelConnectionRequest', 'UserController@cancelConnectionRequest')->name('user-cancelConnectionRequest')->middleware('UsersOnly');

Route::get('/listingsPendingReview', 'AdminController@listingsPendingReview')->name('admin-listingsPendingReview')->middleware('admin');
Route::post('/denyListing', 'AdminController@denyListing')->name('admin-denyListing')->middleware('admin');
Route::get('/requests', 'AdminController@requests')->name('admin-requests')->middleware('admin');
Route::post('/denyRequest', 'AdminController@denyRequest')->name('admin-denyRequest')->middleware('admin');
Route::post('/messageRequestSender', 'AdminController@messageRequestSender')->name('admin-messageRequestSender')->middleware('admin');
Route::post('/approveRequest', 'AdminController@approveRequest')->name('admin-approveRequest')->middleware('admin');
Route::get('/ndasPendingReview', 'AdminController@ndasPendingReview')->name('admin-ndasPendingReview')->middleware('admin');
Route::post('/denyNDA', 'AdminController@denyNDA')->name('admin-denyNDA')->middleware('admin');
Route::post('/approveNDA', 'AdminController@approveNDA')->name('admin-approveNDA')->middleware('admin');
Route::get('/manageWebsite', 'AdminController@manageWebsite')->name('admin-manageWebsite')->middleware('admin');
Route::post('/updateTheme', 'AdminController@updateTheme')->name('admin-updateTheme')->middleware('admin');
Route::post('/updateHomepage', 'AdminController@updateHomepage')->name('admin-updateHomepage')->middleware('admin');
Route::post('/updateCredits', 'AdminController@updateCredits')->name('admin-updateCredits')->middleware('admin');
Route::post('/updateCookie', 'AdminController@updateCookie')->name('admin-updateCookie')->middleware('admin');
Route::post('/updateNDA', 'AdminController@updateNDA')->name('admin-updateNDA')->middleware('admin');

Route::get('/profile', 'UserController@profile')->name('user-profile')->middleware('UsersOnly');
Route::get('/manageAccount', 'UserController@manageAccount')->name('user-manageAccount')->middleware('UsersOnly');
Route::post('/submitNDA', 'UserController@submitNDA')->name('user-submitNDA')->middleware('UsersOnly');
Route::post('/submitChangePassword', 'UserController@submitChangePassword')->name('user-submitChangePassword')->middleware('UsersOnly');
Route::post('/submitUpdateAccount', 'UserController@submitUpdateAccount')->name('user-submitUpdateAccount')->middleware('UsersOnly');
Route::get('/logout', 'UserController@logout')->name('user-logout')->middleware('UsersOnly');
*/

Auth::routes();
