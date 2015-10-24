<?php

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Routes That Require Authentication
Route::group(['middleware' => ['auth']], function()
{
    // Homepage
    Route::get('/', ['as' => 'home', 'uses' => 'IssueController@getIndex']);

    // Add issue
    Route::any('search/submit', ['as' => 'search.submit', 'uses' => 'IssueController@searchSubmit']);

    // Search Movies, TV Shows, and Music
    Route::get('search', ['as' => 'search.select2', 'uses' => 'SearchController@search']);

    // Search Movies
    // Typeahead
    Route::get('search/movie/{query}', ['as' => 'search.movie', 'uses' => 'SearchController@movie']);
    // Select2
    Route::get('search/movie', ['as' => 'search.movie.select2', 'uses' => 'SearchController@movie']);

    // Seach TV Shows
    Route::any('search/tv/{query}', ['as' => 'search.tv', 'uses' => 'SearchController@tv']);

    // Specfic tv show season
    Route::any('search/tv/series/{id}', ['as' => 'search.tv.series', 'uses' => 'SearchController@tvSeries']);

    // Epsisodes of a season of a series
    Route::any('search/tv/series/{id}/season/{season}', ['as' => 'search.tv.series.season.episodes', 'uses' => 'SearchController@tvSeasonEpisodes']);

    // Search Music Albums
    Route::any('search/music/album/{query}', ['as' => 'search.music.album', 'uses' => 'SearchController@musicAlbum']);

    // TV issue
    Route::any('api/tv/advanced', ['as' => 'tv.issue.advanced', 'uses' => 'IssueController@issue_tv']);

    // Add message to issue
    Route::post('message/add/', ['as' => 'message.add', 'uses' => 'MessageController@messageAdd']);

    Route::get('issue/{id}', ['as' => 'issue.id', 'uses' => 'IssueController@getIssueView']);

    // update issue status
    Route::post('issues/update/{id}', ['as' => 'update.issue', 'uses' => 'IssueController@updateIssueStatus']);

    // delete issue/request
    Route::delete('issues/delete/{id}', ['as' => 'delete.issue', 'uses' => 'IssueController@destroyIssue']);

});
