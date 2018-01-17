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
//frontend
Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');

//home
Route::get('/', 'Frontend\HomeController@index')->name('home');
Route::get('bigmatch', 'Frontend\HomeController@bigmatch');
Route::get('home/table', 'Frontend\HomeController@table');
Route::post('home/table/detail', 'Frontend\HomeController@detail');


//news
Route::get('news', 'Frontend\NewsController@index')->name('news');
Route::post('news', 'Frontend\NewsController@find')->name('news.find');
Route::get('news/{id}', 'Frontend\NewsController@show')->name('news.show');
Route::put('news/{id}', 'Frontend\NewsController@visitor');

//highlight
Route::get('highlight', 'Frontend\HighlightController@index')->name('highlight');
Route::post('highlight', 'Frontend\HighlightController@find')->name('highlight.find');
Route::get('highlight/{id}', 'Frontend\HighlightController@show')->name('highlight.show');
Route::put('highlight/{id}', 'Frontend\HighlightController@visitor');

//table
Route::get('table', 'Frontend\TableController@index')->name('table');
Route::get('table/score/{country}', 'Frontend\TableController@table');
Route::post('table/details', 'Frontend\TableController@details');


//Backend
Route::auth();

//home
Route::get('admin/', 'HomeController@index')->name('admin.home');

//bigmatch
Route::middleware('roles')->group(function () {
  Route::get('admin/match', [
    'uses' => 'Backend\MatchController@index',
    'roles' => ['match']
  ])->name('admin.match.index');

  Route::get('admin/match/create', [
    'uses' => 'Backend\MatchController@create',
    'roles' => ['match']
  ])->name('admin.match.create');

  Route::put('admin/match/{id}', [
    'uses' => 'Backend\MatchController@active',
    'roles' => ['match']
  ]);

  Route::delete('admin/match/delete/{id}', [
    'uses' => 'Backend\MatchController@delete',
    'roles' => ['match']
  ]);

  Route::post('admin/match', [
    'uses' => 'Backend\MatchController@store',
    'roles' => ['match']
  ])->name('admin.match.store');
});

//livescore
Route::middleware('roles')->group(function () {
  Route::get('admin/livescore', [
    'uses' => 'Backend\LiveScoreController@index',
    'roles' => ['table']
  ])->name('admin.livescore.index');

  Route::get('admin/livescore/{date}', [
    'uses' => 'Backend\LiveScoreController@livescore',
    'roles' => ['table']
  ]);

  Route::post('admin/livescore', [
    'uses' => 'Backend\LiveScoreController@store',
    'roles' => ['table']
  ]);
});

//zone
Route::middleware('roles')->group(function () {
    Route::get('admin/zone', [
      'uses' => 'Backend\ZoneController@index',
      'roles' => ['category']
    ])->name('admin.zone.index');

    Route::post('admin/zone', [
      'uses' => 'Backend\ZoneController@store',
      'roles' => ['category']
    ]);

    Route::put('admin/zone/{id}', [
      'uses' => 'Backend\ZoneController@update',
      'roles' => ['category']
    ]);

    Route::delete('admin/zone/{id}', [
      'uses' => 'Backend\ZoneController@destroy',
      'roles' => ['category']
    ]);
});

//news
Route::middleware('roles')->group(function () {
    Route::get('admin/news', [
      'uses' => 'Backend\NewsController@index',
      'roles' => ['news']
    ])->name('admin.news.index');

    Route::get('admin/news/create', [
      'uses' => 'Backend\NewsController@create',
      'roles' => ['news'],
      'type' => 'news'
    ])->middleware('checkTimePost')->name('admin.news.create');

    Route::post('admin/news', [
      'uses' => 'Backend\NewsController@store',
      'roles' => ['news']
    ])->name('admin.news.store');

    Route::get( 'admin/news/{id}/edit', [
      'uses' => 'Backend\NewsController@edit',
      'roles' => ['news']
    ])->name('admin.news.edit');

    Route::put('admin/news/{id}', [
      'uses' => 'Backend\NewsController@update',
      'roles' => ['news']
    ])->name('admin.news.update');

    Route::get('admin/news/{filename}', [
      'uses' => 'Backend\NewsController@getNewsImage',
      'roles' => ['news']
    ])->name('admin.news.image');

    Route::delete('admin/news/{id}', [
      'uses' => 'Backend\NewsController@destroy',
      'roles' => ['news']
    ])->name('admin.news.destroy');
});

//highlight
Route::middleware('roles')->group(function () {

  Route::get('admin/highlight', [
    'uses' => 'Backend\HighlightController@index',
    'roles' => ['highlight']
  ])->name('admin.highlight.home');

  Route::get('admin/highlight/form', [
    'uses' => 'Backend\HighlightController@form',
    'roles' => ['highlight'],
    'type' => 'highlight'
  ])->middleware('checkTimePost')->name('admin.highlight.form');

  Route::post('admin/highlight', [
    'uses' => 'Backend\HighlightController@store',
    'roles' => ['highlight']
  ])->name('admin.highlight.store');

  Route::delete('admin/highlight/{id}', [
    'uses' => 'Backend\HighlightController@destroy',
    'roles' => ['highlight']
  ])->name('admin.highlight.destroy');

});


// ----------------------------read-image-----------------------------------
// -------------------cover----------------------
Route::get('cover/{filename}', 'Backend\ImageReadController@cover')->name('image');
// ------------------------------------------
