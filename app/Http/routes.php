<?php
Route::get('/home', function() {
    return redirect()->route('home');
});

Route::group(['middleware' => ['blocked']], function()
{
    Route::get('setup', 'SetupController@firstRun');
});

// First Run - Setup Environment Variables
Route::group(['middleware' => ['first.run']], function()
{
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

        // Add Issue/Request
        Route::any('search/submit', ['as' => 'search.submit', 'uses' => 'IssueController@searchSubmit']);

        // Search Movies, TV Shows, and Music
        // Reports
        Route::get('search/report', ['as' => 'report.search.select2', 'uses' => 'SearchController@search']);
        // Requests
        Route::get('search/request', ['as' => 'request.search.select2', 'uses' => 'SearchController@search']);

        // Search Movies
        // Typeahead
        Route::get('search/movie/{query}', ['as' => 'search.movie', 'uses' => 'SearchController@movie']);
        // Select2
        Route::get('search/movie', ['as' => 'search.movie.select2', 'uses' => 'SearchController@movie']);

        // Search TV Shows
        Route::any('search/tv/{query}', ['as' => 'search.tv', 'uses' => 'SearchController@tv']);

        // Return Specfic TV Show Series Info
        Route::any('search/tv/series/{id}', ['as' => 'search.tv.series', 'uses' => 'SearchController@tvSeries']);

        // Return Epsisodes Of a single season of a TV Show
        Route::any('search/tv/series/{id}/season/{season}', ['as' => 'search.tv.series.season.episodes', 'uses' => 'SearchController@tvSeasonEpisodes']);

        // Search Music Albums
        Route::any('search/music/album/{query}', ['as' => 'search.music.album', 'uses' => 'SearchController@musicAlbum']);

        // Get Album Tracklist
        Route::any('search/music/album/tracklist/{query}', ['as' => 'search.music.album.tracks', 'uses' => 'SearchController@musicAlbumTracks']);

        // TV Issue
        Route::any('api/tv/advanced', ['as' => 'tv.issue.advanced', 'uses' => 'IssueController@issue_tv']);

        // Add Message to Issue
        Route::post('message/add/', ['as' => 'message.add', 'uses' => 'MessageController@messageAdd']);

        // Return Issue/Request View
        Route::get('issue/{id}', ['as' => 'issue.id', 'uses' => 'IssueController@getIssueView']);

        // Update Issue Status
        Route::post('issues/update/{id}', ['as' => 'update.issue', 'uses' => 'IssueController@updateIssueStatus']);

        // Delete Issue/Request
        Route::delete('issues/delete/{id}', ['as' => 'delete.issue', 'uses' => 'IssueController@destroyIssue']);

        // Plex Routes
        // Return Plex Authorization Header
        Route::get('plex/authorize', ['as' => 'plex.authorize', 'uses' => 'PlexController@plexAuthorize']);
        // Return Plex Friends
        Route::get('plex/friends', ['as' => 'plex.friends', 'uses' => 'PlexController@plexFriends']);
        // Plex Server Info
        Route::get('plex/server/info', ['as' => 'plex.server.info', 'uses' => 'PlexController@plexServerInfo']);
        // Plex Server Sessions
        Route::get('plex/server/sessions', ['as' => 'plex.server.sessions', 'uses' => 'PlexController@plexServerSessions']);
        // Plex Server Search
        Route::get('plex/server/search', ['as' => 'plex.server.search', 'uses' => 'PlexController@plexServerSearch']);
    });
});
