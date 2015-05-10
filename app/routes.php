<?php

/** ------------------------------------------
 *  Route Style Guide
 *  ------------------------------------------
 */
Route::get('/style_guide/', ['as' => 'style', 'uses' => 'IssueController@style']);

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');


/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset');

// User password reset
Route::post('user/reset/{token}', 'UserController@postReset');

//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit');

//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');


// PROTECTED
Route::group(array('before' => 'auth'), function()
{
	Route::get('/', array('before' => 'detectLang','uses' => 'IssueController@getIndex'));

	// Add issue
	Route::post('api/search/', ['as' => 'movies.search', 'uses' => 'IssueController@postApi']);

	// Add message to issue
	Route::post('message/add/', ['as' => 'message.add', 'uses' => 'MessageController@messageAdd']);

	// Route::get('issue/{id}', 'IssueController@getIssueView');
	Route::get('issue/{id}', ['as' => 'issue.id', 'uses' => 'IssueController@getIssueView']);

	// update issue status
	Route::post('issues/update/{id}', ['as' => 'update.issue', 'uses' => 'IssueController@updateIssueStatus']);

	// delete issue/request
	Route::delete('issues/delete/{id}', ['as' => 'delete.issue', 'uses' => 'IssueController@destroyIssue']);
});

// Garbage Can

			// /** ------------------------------------------
			//  *  Admin Routes
			//  *  ------------------------------------------
			//  */
			// Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
			// {
			//
			// 	# Comment Management
			// 	Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
			// 	Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
			// 	Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
			// 	Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
			// 	Route::controller('comments', 'AdminCommentsController');
			//
			// 	# Blog Management
			// 	Route::get('blogs/{post}/show', 'AdminBlogsController@getShow');
			// 	Route::get('blogs/{post}/edit', 'AdminBlogsController@getEdit');
			// 	Route::post('blogs/{post}/edit', 'AdminBlogsController@postEdit');
			// 	Route::get('blogs/{post}/delete', 'AdminBlogsController@getDelete');
			// 	Route::post('blogs/{post}/delete', 'AdminBlogsController@postDelete');
			// 	Route::controller('blogs', 'AdminBlogsController');
			//
			// 	# User Management
			// 	Route::get('users/{user}/show', 'AdminUsersController@getShow');
			// 	Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
			// 	Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
			// 	Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
			// 	Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
			// 	Route::controller('users', 'AdminUsersController');
			//
			// 	# User Role Management
			// 	Route::get('roles/{role}/show', 'AdminRolesController@getShow');
			// 	Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
			// 	Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
			// 	Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
			// 	Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
			// 	Route::controller('roles', 'AdminRolesController');
			//
			// 	# Admin Dashboard
			// 	Route::controller('/', 'AdminDashboardController');
			// });

// AUTH FILTER
Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('user/login');
});
