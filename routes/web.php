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

// Route::get('/', function () {
//     return view('welcome');
// });

// User Non-Admin

Route::get('/', 'ingetnih\HomeController@index');
Route::get('/users/login', 'ingetnih\HomeController@loginShow');
Route::post('/users/login', 'ingetnih\HomeController@login');

route::get('/users/register', 'ingetnih\HomeController@registerShow');
route::post('/users/register', 'ingetnih\HomeController@register');

route::get('/users/logout', 'ingetnih\HomeController@logout');

route::get('/users/profile/{user_id}', 'ingetnih\user\UserController@profileShow');

route::get('/acara/{event_id}', 'ingetnih\acara\EventController@getAcaraSpesifik');

route::get('/berita/{berita_id}', 'ingetnih\berita\BeritaController@getBeritaSpesifik');
// User Admin

// EVENT
route::get('/admin/event/', 'admin\CAJadwalController@acaraJadwal');
route::get('/admin/event/add/', 'admin\CAJadwalController@acaraJadwalAddShow');
route::post('/admin/event/create/', 'admin\CAJadwalController@acaraJadwalAddData');
route::get('/admin/event/edit/{event_id}', 'admin\CAJadwalController@acaraJadwalEditShow');
route::put('/admin/event/edit/', 'admin\CAJadwalController@acaraJadwalEditData');

route::get('/search/event','ingetnih\HomeController@searchEventData')->name("search-event");

// AKUN
route::get('/admin/dashboard', 'admin\CAAkunController@index');
route::get('/admin/user/user', 'admin\CAAkunController@userUser');
route::get('/admin/user/user/edit/{event_id}', 'admin\CAAkunController@userEditShow');
route::put('/admin/user/user/', 'admin\CAAkunController@userEditData');

route::get('/users/profile/','ingetnih\user\UserController@profileShow');

route::get('/admin/user/group', 'admin\CAAkunController@userGroup');
route::get('/admin/user/group/{group_id}', 'admin\CAAkunController@userGroupDetail');

//Berita
route::get('/admin/news', 'admin\CABeritaController@berita');

//Jadwal Dosen
route::get('/search/dosen','ingetnih\HomeController@searchDosenShow');
route::post('/search/dosen/data','ingetnih\HomeController@searchDosenData');



Route::get('getCraw', 'CrawBaak@_getData');
Route::get('showCraw', 'CrawBaak@_showData');