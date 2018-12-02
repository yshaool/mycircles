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

Route::get('/', 'StaticController@index');
Route::get('/about', 'StaticController@about');
Route::get('/contact', 'StaticController@contact');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController')->except(['create', 'store']);
Route::resource('communities', 'CommunityController');
Route::resource('communitymember', 'CommunityMemberController');
Route::get('/joincircle', 'CommunityController@showjoin');
Route::POST('/join', 'CommunityController@join');
Route::get('/communities/{community}/showinvite', 'CommunityController@showInvite');
Route::POST('/communities/{community}/sendinvite', 'CommunityController@inviteMembers');
Route::get('/joinfromemail', 'CommunityController@joinFromEmailLink');
Route::get('/communities/{community}/downloadmembers', 'CommunityController@downloadMembers');
Route::get('/communities/{community}/verifydelete', 'CommunityController@showVerifyDelete');

Route::get('/communities/{community}/addmembersfromfile', 'CommunityController@showAddMembersFromFileForm');
Route::POST('/communities/{community}/parsemembersfromfile', 'CommunityController@parseMembersFileDisplayColSelection');
Route::POST('/communities/{community}/addmembersfromfile', 'CommunityController@addMemberFromFile');

Route::get('/users/{user}/editusername', 'UserController@editUsername');
Route::put('/users/{user}/updateusername', 'UserController@updateUsername');
Route::get('/users/{user}/editpassword', 'UserController@editPassword');
Route::put('/users/{user}/updatepassword', 'UserController@updatePassword');

//https://itsolutionstuff.com/post/laravel-56-import-export-to-excel-and-csv-exampleexample.html
//laravel excel export https://www.youtube.com/watch?v=2FH72e6OjeQ

