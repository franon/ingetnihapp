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

// ! Need Auth
Route::group(['middleware' => 'auth:api'], function() {
    
    // ? ===================================START OF ACCOUNT==========================================================
    route::get('/get/allusersP', 'Api\UserController@getAllUserP');
    route::get('/get/users/{user_id}', 'Api\UserController@getUser');
    route::put('/users/{user_id}', 'Api\UserController@editData');
    Route::post('/users/details', 'Api\UserController@details');
    Route::delete('/users/logout', 'Api\UserController@logout');
    Route::delete('/users/remove/{user_id}', 'Api\UserController@removeUser');
    // ? ===================================END OF ACCOUNT============================================================
    
    // ? ===================================START OF GROUP============================================================
    route::post('/group/add', 'Api\GroupController@addNewGroup');
    route::get('/get/group/allgroup', 'Api\GroupController@getAllGroup');
    route::get('/get/group/{group_id}', 'Api\GroupController@getGroupSpesific');
    route::delete('/group/remove/{group_id}', 'Api\GroupController@destroyGroup');
    route::get('/show/group/pribadi', 'Api\GroupController@getMyGroup');
    
    Route::post('group/adduser', 'Api\UserController@addUserToGroup');
    // ? ===================================END OF GROUP===============================================================

    // ? ===================================START OF JABATAN===========================================================
    Route::post('jabatan/adduser', 'Api\UserController@addUserToJabatan');
    // ? ===================================END OF JABATAN=============================================================

    // ? ===================================START OF EVENT=============================================================
    // Route::get('get/event/{event_id}', 'Api\EventController@getEventspesific'); // showing event
    Route::post('event/add', 'Api\EventController@store'); // add event
    Route::put('event/{event_id}', 'Api\EventController@updateEvent'); //update event
    Route::delete('event/{event_id}', 'Api\EventController@removeEvent'); // delete event
    Route::get('get/event/filter/by/{filter_type}', 'Api\EventController@filterEvent');
    
    Route::get('testing', 'Api\EventController@storeGroupEvent');
    // ? ===================================END OF EVENT================================================================

    // ? ===================================START OF NOTIFICATION=======================================================
    // * Notification
    route::put('notifikasi/notified','Api\NotifikasiController@notifiedBroadcast');

    route::get('get/notifikasi/', 'Api\NotifikasiController@getNotifikasiUserPribadi');
    // ? ===================================END OF NOTIFICATION=========================================================
    
    // ? ===================================START OF SOUNDING OR BROADCAST==============================================
    // * Sounding or Broadcast
    // ? ===================================END OF SOUNDING OR BROADCAST================================================
    
    // ? ===================================START OF REMINDER===========================================================
    // * Reminder
    Route::post('reminder', 'Api\EventReminderController@store');
    // ? ===================================END OF REMINDER=============================================================
    
    
});

// ! Dont Need Auth
// ? ===================================START OF EVENT===================================================================
Route::get('/event/all', 'Api\EventController@getAllEvent');
route::get('/event/datatables', 'Api\EventController@acaraJadwal');
Route::get('/get/event/{event_id}', 'Api\EventController@getEventspesific'); // showing event
Route::get('search/event', 'Api\EventController@searchEvent');
route::get('/get/event/group/{group_id}', 'Api\GroupController@getGroupEvent');
Route::get('get/event/{type}/{user_id}', 'Api\EventController@getEventBy');
// ? ===================================END OF EVENT=====================================================================
// ? ===================================START OF ACCOUNT=================================================================
route::get('/get/allusers', 'Api\UserController@getAllUser');
Route::post('/users/login', 'Api\UserController@login');
Route::post('/users/register', 'Api\UserController@register');
route::get('/users/datatables', 'Api\UserController@getAllUserDT');
Route::get('/search/dosen', 'Api\UserController@searchUser');
Route::get('/search/dosen/all', 'Api\UserController@searchUser');
// ? ===================================END OF ACCOUNT===================================================================
// ? ===================================START OF BERITA==================================================================
route::get('/berita/datatables', 'Api\BeritaController@getAllBeritaDT');
Route::get('/get/berita/allberita', 'Api\BeritaController@showAllBerita'); 
Route::get('/get/berita/{berita_id}', 'Api\BeritaController@showSpesifikBerita'); 
// ? ===================================END OF BERITA====================================================================
// ? ===================================START OF GROUP====================================================================
Route::get('/group/store/event', 'Api\EventController@getEventUser');
route::get('/get/group/related/{group_id}', 'Api\GroupController@getGroupDataEventUser');
// ? ===================================END OF GROUP======================================================================
// ? ===================================START OF NOTIFICATION=============================================================
    // * Classic Notif
route::get('get/wildcard/notifikasi/', 'Api\NotifikasiController@getNotifikasiUserTertentu');
route::post('inject/notif/terpaksa', 'Api\NotifikasiController@insertInject');

    // * Push Notif
route::get('/testing/push', 'Api\pushNotifAndroidController@testing');
// ? ===================================END OF NOTIFICATION===============================================================
// ? ===================================START OF CRAWLING AND PARSING=====================================================
// Route::get('craw/baak', 'CrawBaak@crawNow');
Route::get('craw/baak', 'CrawBaak_recursive@crawl');
Route::get('craw/baak/insert', 'CrawBaak@insertIntoDatabase');

route::get('/testing/parsing', 'ParsingFile@parsingFile');
route::get('/testing/insert/parsing', 'ParsingFile@insertIntoDatabase');
// ? ===================================END OF CRAWLING AND PARSING=======================================================

// ! ===================================START OF TESTING==================================================================
Route::get('recursive/baak/{link}', 'CrawBaak@crawl');
Route::get('handle/testing', 'Api\EventController@__handle');
// ! ===================================START OF TESTING==================================================================
