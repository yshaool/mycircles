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
//Route::POST('/communities/{community}/join', 'CommunityController@joinFromEmailLink');


/*
POST      | communitymember                        | communitymember.store   | App\Http\Controllers\CommunitymemberController@store                   | web          |
|        | GET|HEAD  | communitymember                        | communitymember.index   | App\Http\Controllers\CommunitymemberController@index                   | web          |
|        | GET|HEAD  | communitymember/create                 | communitymember.create  | App\Http\Controllers\CommunitymemberController@create                  | web          |
|        | DELETE    | communitymember/{communitymember}      | communitymember.destroy | App\Http\Controllers\CommunitymemberController@destroy                 | web          |
|        | PUT|PATCH | communitymember/{communitymember}      | communitymember.update  | App\Http\Controllers\CommunitymemberController@update                  | web          |
|        | GET|HEAD  | communitymember/{communitymember}      | communitymember.show    | App\Http\Controllers\CommunitymemberController@show                    | web          |
|        | GET|HEAD  | communitymember/{communitymember}/edit | communitymember.edit    | App\Http\Controllers\CommunitymemberController@edit                    | web          |
*/
