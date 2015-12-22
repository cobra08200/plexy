<?php
Route::group(['middleware' => ['httpsProtocol']], function()
{
  get('home', function() {
      return redirect()->route('home');
  });

  Route::group(['middleware' => ['blocked']], function()
  {
      get('setup', 'SetupController@firstRun');
  });

  // First Run - Setup Environment Variables
  Route::group(['middleware' => ['first.run']], function()
  {
      // get('plex/server/info', ['as' => 'plex.server.info', 'uses' => 'PlexController@plexServerInfo']);
      // get('plex/server/sessions', ['as' => 'plex.server.sessions', 'uses' => 'PlexController@plexTranscodeSessions']);
      // get('plex/server/sessions/delete/{transcodeSessionKey}', ['as' => 'plex.server.session.delete', 'uses' => 'PlexController@plexDeleteTranscodeSession']);

      // Authentication routes...
      get('login', ['as' => 'login', 'uses' => 'SessionsController@login']);
      post('login', ['as' => 'login.post', 'uses' => 'SessionsController@postLogin']);
      get('logout', ['as' => 'logout', 'uses' => 'SessionsController@logout']);

      // Registration routes...
      get('register', ['as' => 'register', 'uses' => 'RegistrationController@register']);
      post('register', ['as' => 'register.post', 'uses' => 'RegistrationController@postRegister']);
      get('register/confirm/{token}', ['as' => 'register.confirm', 'uses' => 'RegistrationController@confirmEmail']);

      // Password reset link request routes...
      get('password/email', ['as' => 'password.email', 'uses' => 'Auth\PasswordController@getEmail']);
      post('password/email', ['as' => 'password.email.post', 'uses' => 'Auth\PasswordController@postEmail']);

      // Password reset routes...
      get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@getReset']);
      post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\PasswordController@postReset']);

      // Routes That Require Authentication
      Route::group(['middleware' => ['auth']], function()
      {
          // Homepage
          get('/', ['as' => 'home', 'uses' => 'IssueController@getIndex']);

          // Add Issue/Request
          post('search/submit', ['as' => 'search.submit', 'uses' => 'IssueController@searchSubmit']);

          // Search Movies, TV Shows, and Music
          // Reports
          // get('search/report', ['as' => 'report.search.select2', 'middleware' => 'ajax', 'uses' => 'SearchController@search']);
          // Requests
          get('search/request', ['as' => 'request.search', 'middleware' => 'ajax', 'uses' => 'SearchController@search']);

          // // Search Movies
          // // Typeahead
          // get('search/movie/{query}', ['as' => 'search.movie', 'middleware' => 'ajax', 'uses' => 'SearchController@movie']);
          // // Select2
          // get('search/movie', ['as' => 'search.movie.select2', 'middleware' => 'ajax', 'uses' => 'SearchController@movie']);
          //
          // // Search TV Shows
          // any('search/tv/{query}', ['as' => 'search.tv', 'uses' => 'SearchController@tv']);
          //
          // // Return Specfic TV Show Series Info
          // any('search/tv/series/{id}', ['as' => 'search.tv.series', 'uses' => 'SearchController@tvSeries']);
          //
          // // Return Epsisodes Of a single season of a TV Show
          // any('search/tv/series/{id}/season/{season}', ['as' => 'search.tv.series.season.episodes', 'uses' => 'SearchController@tvSeasonEpisodes']);
          //
          // // Search Music Albums
          // any('search/music/album/{query}', ['as' => 'search.music.album', 'uses' => 'SearchController@musicAlbum']);
          //
          // // Get Album Tracklist
          // any('search/music/album/tracklist/{query}', ['as' => 'search.music.album.tracks', 'uses' => 'SearchController@musicAlbumTracks']);
          //
          // // TV Issue
          // any('api/tv/advanced', ['as' => 'tv.issue.advanced', 'uses' => 'IssueController@issue_tv']);

          // Add Message to Issue
          post('message/add/', ['as' => 'message.add', 'uses' => 'MessageController@messageAdd']);

          // Update Issue Description
          post('issues/update/{id}/message/{messageId}', ['as' => 'update.message', 'uses' => 'MessageController@updateMessage']);

          // Return Issue/Request View
          get('issue/{id}', ['as' => 'issue.id', 'uses' => 'IssueController@getIssueView']);

          // Update Issue Status
          post('issues/update/{id}', ['as' => 'update.issue', 'uses' => 'IssueController@updateIssueStatus']);

          // Update Issue Description
          post('issues/update/description/{id}', ['as' => 'update.issue_description', 'uses' => 'IssueController@updateIssueDescription']);

          // Delete Issue/Request
          delete('issues/delete/{id}', ['as' => 'delete.issue', 'uses' => 'IssueController@destroyIssue']);

          // Plex Routes
          // // Return Plex Authorization Header
          // get('plex/authorize', ['as' => 'plex.authorize', 'uses' => 'PlexController@plexAuthorize']);
          // // Return Plex Friends
          // get('plex/friends', ['as' => 'plex.friends', 'uses' => 'PlexController@plexFriends']);
          // // Plex Server Info
          // get('plex/server/info', ['as' => 'plex.server.info', 'uses' => 'PlexController@plexServerInfo']);
          // // Plex Server Sessions
          // get('plex/server/sessions', ['as' => 'plex.server.sessions', 'uses' => 'PlexController@plexServerSessions']);
          // Plex Server Search
          get('plex/server/search', ['as' => 'plex.server.search', 'middleware' => 'ajax', 'uses' => 'PlexController@plexServerSearch']);
          // Plex Thumb Preview
          get('plex/thumbs/{ratingKey}.{thumbExtension}', ['as' => 'plex.thumb.preview', 'uses' => 'PlexController@previewPlexThumb']);
          // Force update Plex Thumb Image on Server
          get('update/plex/thumbs/{ratingKey}.{thumbExtension}', ['as' => 'update.plex.thumb.preview', 'uses' => 'PlexController@updatePlexThumbnail']);
          // Plex TV Show Episodes
          get('plex/tv/{ratingKey}/episodes', ['as' => 'plex.tv.episodes', 'uses' => 'PlexController@plexTVShowEpisodes']);
          // Plex TV Show Season Specific Episodes
          post('plex/tv/{ratingKey}/season/{seasonNumber}/episodes', ['as' => 'plex.tv.season.episodes', 'middleware' => 'ajax', 'uses' => 'PlexController@plexTVShowSeasonEpisodes']);
          // Plex Album Details + Tracks
          get('plex/album/{ratingKey}', ['as' => 'plex.album.tracks', 'uses' => 'PlexController@plexAlbumTracks']);
      });
  });

  Route::group(['as' => 'LaravelInstaller::', 'namespace' => 'Installer'], function()
  {
      Route::group(['prefix' => 'install'], function()
      {
          Route::group(['middleware' => 'canInstall'], function()
          {
              get('/', ['as' => 'welcome', 'uses' => 'WelcomeController@welcome']);
              get('environment', ['as' => 'environment', 'uses' => 'EnvironmentController@environment']);
              post('environment/save', ['as' => 'environmentSave', 'uses' => 'EnvironmentController@save']);
              get('requirements', ['as' => 'requirements', 'uses' => 'RequirementsController@requirements']);
              get('permissions', ['as' => 'permissions', 'uses' => 'PermissionsController@permissions']);
              get('database', ['as' => 'database', 'uses' => 'DatabaseController@database']);
              get('account', ['as' => 'admin.account', 'uses' => 'AccountController@adminCheck']);
              post('account/save', ['as' => 'admin.account.save', 'uses' => 'AccountController@createAdminAccount']);
          });

          get('final', ['as' => 'final', 'uses' => 'FinalController@finish']);
      });

      Route::group(['prefix' => 'upgrade', 'middleware' => 'canUpgrade'], function()
      {
          get('/', ['as' => 'upgrade', 'uses' => 'UpgradeController@welcome']);
          get('process', ['as' => 'process', 'uses' => 'UpgradeController@process']);
      });
  });
});
