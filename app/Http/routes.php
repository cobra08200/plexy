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
    Route::get('login', ['as' => 'login', 'uses' => 'SessionsController@login']);
    Route::post('login', ['as' => 'login.post', 'uses' => 'SessionsController@postLogin']);
    Route::get('logout', ['as' => 'logout', 'uses' => 'SessionsController@logout']);

    // Registration routes...
    Route::get('register', ['as' => 'register', 'uses' => 'RegistrationController@register']);
    Route::post('register', ['as' => 'register.post', 'uses' => 'RegistrationController@postRegister']);
    Route::get('register/confirm/{token}', ['as' => 'register.confirm', 'uses' => 'RegistrationController@confirmEmail']);

    // Password reset link request routes...
    Route::get('password/email', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@getEmail']);
    Route::post('password/email', ['as' => 'password.email.post', 'uses' => 'Auth\PasswordController@postEmail']);

    // Password reset routes...
    Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@getReset']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\PasswordController@postReset']);

    // Routes That Require Authentication
    Route::group(['middleware' => ['auth']], function()
    {
        // Homepage
        Route::get('/', ['as' => 'home', 'uses' => 'IssueController@getIndex']);

        // Add Issue/Request
        Route::any('search/submit', ['as' => 'search.submit', 'uses' => 'IssueController@searchSubmit']);

        // Search Movies, TV Shows, and Music
        // Reports
        Route::get('search/report', ['as' => 'report.search.select2', 'middleware' => 'ajax', 'uses' => 'SearchController@search']);
        // Requests
        Route::get('search/request', ['as' => 'request.search.select2', 'middleware' => 'ajax', 'uses' => 'SearchController@search']);

        // // Search Movies
        // // Typeahead
        // Route::get('search/movie/{query}', ['as' => 'search.movie', 'middleware' => 'ajax', 'uses' => 'SearchController@movie']);
        // // Select2
        // Route::get('search/movie', ['as' => 'search.movie.select2', 'middleware' => 'ajax', 'uses' => 'SearchController@movie']);
        //
        // // Search TV Shows
        // Route::any('search/tv/{query}', ['as' => 'search.tv', 'uses' => 'SearchController@tv']);
        //
        // // Return Specfic TV Show Series Info
        // Route::any('search/tv/series/{id}', ['as' => 'search.tv.series', 'uses' => 'SearchController@tvSeries']);
        //
        // // Return Epsisodes Of a single season of a TV Show
        // Route::any('search/tv/series/{id}/season/{season}', ['as' => 'search.tv.series.season.episodes', 'uses' => 'SearchController@tvSeasonEpisodes']);
        //
        // // Search Music Albums
        // Route::any('search/music/album/{query}', ['as' => 'search.music.album', 'uses' => 'SearchController@musicAlbum']);
        //
        // // Get Album Tracklist
        // Route::any('search/music/album/tracklist/{query}', ['as' => 'search.music.album.tracks', 'uses' => 'SearchController@musicAlbumTracks']);
        //
        // // TV Issue
        // Route::any('api/tv/advanced', ['as' => 'tv.issue.advanced', 'uses' => 'IssueController@issue_tv']);

        // Add Message to Issue
        Route::post('message/add/', ['as' => 'message.add', 'uses' => 'MessageController@messageAdd']);

        // Update Issue Description
        Route::post('issues/update/{id}/message/{messageId}', ['as' => 'update.message', 'uses' => 'MessageController@updateMessage']);

        // Return Issue/Request View
        Route::get('issue/{id}', ['as' => 'issue.id', 'uses' => 'IssueController@getIssueView']);

        // Update Issue Status
        Route::post('issues/update/{id}', ['as' => 'update.issue', 'uses' => 'IssueController@updateIssueStatus']);

        // Update Issue Description
        Route::post('issues/update/description/{id}', ['as' => 'update.issue_description', 'uses' => 'IssueController@updateIssueDescription']);

        // Delete Issue/Request
        Route::delete('issues/delete/{id}', ['as' => 'delete.issue', 'uses' => 'IssueController@destroyIssue']);

        // Plex Routes
        // // Return Plex Authorization Header
        // Route::get('plex/authorize', ['as' => 'plex.authorize', 'uses' => 'PlexController@plexAuthorize']);
        // // Return Plex Friends
        // Route::get('plex/friends', ['as' => 'plex.friends', 'uses' => 'PlexController@plexFriends']);
        // // Plex Server Info
        // Route::get('plex/server/info', ['as' => 'plex.server.info', 'uses' => 'PlexController@plexServerInfo']);
        // // Plex Server Sessions
        // Route::get('plex/server/sessions', ['as' => 'plex.server.sessions', 'uses' => 'PlexController@plexServerSessions']);
        // Plex Server Search
        Route::get('plex/server/search', ['as' => 'plex.server.search', 'middleware' => 'ajax', 'uses' => 'PlexController@plexServerSearch']);
        // Plex Thumb Preview
        Route::get('plex/thumbs/{ratingKey}.{thumbExtension}', ['as' => 'plex.thumb.preview', 'uses' => 'PlexController@previewPlexThumb']);
        // Force update Plex Thumb Image on Server
        Route::get('update/plex/thumbs/{ratingKey}.{thumbExtension}', ['as' => 'update.plex.thumb.preview', 'uses' => 'PlexController@updatePlexThumbnail']);
        // Plex TV Show Episodes
        Route::get('plex/tv/{ratingKey}/episodes', ['as' => 'plex.tv.episodes', 'uses' => 'PlexController@plexTVShowEpisodes']);
        // Plex TV Show Season Specific Episodes
        Route::any('plex/tv/{ratingKey}/season/{seasonNumber}/episodes', ['as' => 'plex.tv.season.episodes', 'middleware' => 'ajax', 'uses' => 'PlexController@plexTVShowSeasonEpisodes']);
        // Plex Album Details + Tracks
        Route::get('plex/album/{ratingKey}', ['as' => 'plex.album.tracks', 'uses' => 'PlexController@plexAlbumTracks']);
    });
});
