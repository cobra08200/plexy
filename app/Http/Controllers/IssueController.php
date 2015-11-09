<?php

namespace App\Http\Controllers;

use Auth;
use View;
use Session;
use App\Issue;
use App\User;
use App\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class IssueController extends Controller {

   /*
	* This is the main function of the application. It interprets the submission and determines the logical workflow.
	*
	* URL: search/submit
	*/
	public function searchSubmit(Request $request)
	{
		// dd($request->all());

		// This determines which submission round the request/issue is going through.
		$round = $request->input('round');

		// checker to see if they actually used a suggestion
		$rules = array(
			'tmdb'	=> 'required'
		);

		$validator = Validator::make($request->all(), $rules);

		if($validator->fails())
		{
			// redirect our user back to the form with the errors from the validator
			return Redirect::back()
				->with('warning', "Woops.  You did something wrong.  Let's see if you can figure it out.");
		}

		if($request->input('type') == 'issue')
		{
			$report_checker = Issue::where('type', '=', 'issue')
			->where('tmdb', '=', $request->input('tmdb'))
			->where('status', '!=', 'closed')
			->where('user_id', '=', Auth::id())
			->count();

			// redirect our user back to the form with the errors from the report_checker
			// they already reported this
			// if ($report_checker > 0)
			// {
			// 	return Redirect::back()
			// 		->with('info', "You already have this report active, go check the status.");
			// }
		}

		// skip unique check if type is issue, I allow multiple issues per unique tmdb object, but only one per user
		if ($request->input('type') == 'request')
		{
			$unique_rules = array(
				'tmdb'	=> 'unique:issues'  // check tmdb to see if anyone else in plexy has requested it
			);
			$unique = Validator::make($request->all(), $unique_rules);
		}

		if (isset($unique) && $unique->fails())
		{
			$requester_checker_anyone = Issue::where('type', '=', 'request')
			->where('tmdb', '=', $request->input('tmdb'))
			->where('user_id', '!=', Auth::id())
			->count();

			$requester_checker_current_user = Issue::where('type', '=', 'request')
			->where('tmdb', '=', $request->input('tmdb'))
			->where('user_id', '=', Auth::id())
			->count();

			// redirect our user back to the form with the errors from the validator
			// current user already requested this
			if ($requester_checker_current_user > 0) {
				return Redirect::back()
				->with('info', "You already requested this.");
			}

			// someone else requested this
			if ($requester_checker_anyone > 0) {
				return Redirect::back()
					->with('info', "Someone else already requested this, I'm working on it.");
			}
		}

		$report_to_request_checker = Issue::where('type', '=', 'issue')
		->where('tmdb', '=', $request->input('tmdb'))
		->where('status', '!=', 'closed')
		->where('user_id', '=', Auth::id())
		->count();

		// if ($report_to_request_checker > 0)
		// {
		// return Redirect::back()
		// 	->with('info', "You already decided to report this, find and update it with what you wish to report.");
		// }

		// create new issue
		$issue = new Issue;
		$issue->user_id = Auth::id();
		// music album does not require year in title
		if(strtolower($request->input('topic')) == 'music' || $round == 'advanced')
		{
			$issue->content = $request->input('title');
		}
		else
		{
			$issue->content = $request->input('title') . ' (' . $request->input('year') .')';
		}
		$issue->tmdb = $request->input('tmdb');
		$issue->poster_url = $request->input('poster');
		$issue->backdrop_url = $request->input('backdrop');
		$issue->topic = $request->input('topic');
		$issue->vote_average = $request->input('vote_average');
		$issue->type = strtolower($request->input('type'));

		if(isset($round) && $round == 'advanced')
		{
			if($issue->type == 'issue')
			{
				$rules = array(
					'issue_description'	=> 'required'
				);

				$validator = Validator::make($request->all(), $rules);

				if($validator->fails())
				{
					if($issue->topic == 'tv') {
						return $this->issue_tv($issue)
							->with('warning', "Woops.  You need to describe the issue first.");
					}
					if($issue->topic == 'music') {
						return $this->issue_music($issue)
							->with('warning', "Woops.  You need to describe the issue first.");
					}
					if($issue->topic == 'movies') {
						return $this->issue_movie($issue)
							->with('warning', "Woops.  You need to describe the issue first.");
					}
				}

				$issue->report_option = $request->input('report_option');
				$issue->issue_description = $request->input('issue_description');
				// if tv show
				if($issue->topic == 'tv')
				{
					// add extra details to reported issue
					$issue->tv_season_number = $request->input('season');
					if ($issue->report_option != 'Missing Episode') {
						$issue->tv_episode_number = $request->input('episode');
					}
					// $issue->tv_episode_overview = $request->input('tv_episode_overview');
					// $issue->tv_episode_still_path = $request->input('still_path');
					// $issue->vote_average = $request->input('vote_average');
				}
				if($issue->topic == 'music')
				{
					// add extra details to reported issue
					if ($issue->report_option != 'Missing Track') {
						$issue->album_track_number = $request->input('track');
					}
				}
			}
		}

		// if($request->ajax())
		// {
			// plexy advanced issue capture
			// issue detector -> need to gather more info from user
			if($issue->type == 'issue' && $round != 'advanced')
			{
				// if tv show
				if($issue->topic == 'tv')
				{
					//return to view with current issue info and get season + episode
					return $this->issue_tv($issue);
				}

				// if movie
				if($issue->topic == 'movies')
				{
					//return to view with current issue info and get season + episode
					return $this->issue_movie($issue);
				}

				// if music
				if($issue->topic == 'music')
				{
					//return to view with current issue info and get season + episode
					return $this->issue_music($issue);
				}

			}
		// }

		$issue->save();

		if (config('app_env') == ('production'))
		{
			// send pusher notification to admin
			curl_setopt_array($ch = curl_init(), array(
				CURLOPT_URL => "https://api.pushover.net/1/messages.json",
				CURLOPT_POSTFIELDS => array(
					"token" => config('services.pushover.token'),
					"user" => config('services.pushover.user'),
					"message" => Auth::user()->username." added ". $issue->content,
				),
				CURLOPT_SAFE_UPLOAD => true,
			));
			curl_exec($ch);
			curl_close($ch);

			// send email
			$username 		= Auth::user()->username;
			$email 			= Auth::user()->email;
			$issue_id 		= $issue->id;
			$poster_url 	= $issue->poster_url;
			$title 			= $issue->content;

			$data = array(
				'user' 			=> Auth::user(),
				'username' 		=> $username,
				'email' 		=> $email,
				'issue_id' 		=> $issue_id,
				'poster_url' 	=> $poster_url,
				'title' 		=> $title
			);

			Mail::later(5, 'emails.newrequest', $data, function($message) use ($username, $email, $issue_id, $poster_url, $title)
			{
				$message->from('plexy@ehumps.me', 'Plexy');
				$message->to($email, $username)->subject('Plexy - Ticket #'.$issue_id);
			});
		}
		//return after form submit
		return Redirect::to('/');
	}

	public function issue_tv($issue)
	{
		$ratingKey = $issue->tmdb;

		$series = app('App\Http\Controllers\PlexController')->plexTVShowEpisodes($ratingKey);

		$first_season 	= head($series);
		$last_season 	= last($series);

		$first_season_number 	= $first_season['parentIndex'];
		$last_season_number 	= $last_season['parentIndex'];

		// if ($request->ajax())
		// {
			return View::make('site/pages/advanced_issues', compact('issue', 'series', 'first_season_number', 'last_season_number'));
		// }
	}

	public function issue_movie($issue)
	{
		$id = $issue->tmdb;

		// if ($request->ajax())
		// {
			return View::make('site/pages/advanced_issues', compact('issue'));
		// }
	}

	public function issue_music($issue)
	{
		$ratingKey = $issue->tmdb;

		$album = app('App\Http\Controllers\PlexController')->plexAlbumTracks($ratingKey);

		return View::make('site/pages/advanced_issues', compact('issue', 'album'));
	}

	public function getIssueView($id)
	{

		// if ($request->ajax())
		// {
			$issue = Issue::find($id);

			$thumbExtension = last(explode(".", $issue->poster_url));

			if (Issue::where('id', '=', $id)->exists())
			{
				$issue = Issue::find($id);

				// security to make sure logged in user is admin OR ticket owner
				if (Auth::user()->hasRole('admin') || Auth::id() == $issue->user_id)
				{
					$messages = Message::where('issue_id', '=', $id)->get();

					return View::make('site/pages/issues', compact('issue', 'messages', 'thumbExtension'));
				}
			}
		// }

		return Redirect::to('/');

	}

	public function getIndex()
	{
		$users 	= User::all();
		$user 	= Auth::user();
		$id 	= Auth::id();
		$bodyClass = "dashboard";

		if($user->hasRole('admin')) {
			$movie_requests = Issue::where('type', '=', 'request')->where('topic', '=', 'movies')->where('status', '!=', 'closed')->get();
			$movie_issues 	= Issue::where('type', '=', 'issue')->where('topic', '=', 'movies')->where('status', '!=', 'closed')->get();
			$tv_requests 	= Issue::where('type', '=', 'request')->where('topic', '=', 'tv')->where('status', '!=', 'closed')->get();
			$tv_issues 		= Issue::where('type', '=', 'issue')->where('topic', '=', 'tv')->where('status', '!=', 'closed')->get();
			$music_requests = Issue::where('type', '=', 'request')->where('topic', '=', 'music')->where('status', '!=', 'closed')->get();
			$music_issues 	= Issue::where('type', '=', 'issue')->where('topic', '=', 'music')->where('status', '!=', 'closed')->get();
			$closed	= Issue::where('status', '=', 'closed')->paginate(4);
		} else {
			$movie_requests = Issue::where('user_id', '=', $id)->where('type', '=', 'request')->where('topic', '=', 'movies')->where('status', '!=', 'closed')->get();
			$movie_issues	= Issue::where('user_id', '=', $id)->where('type', '=', 'issue')->where('topic', '=', 'movies')->where('status', '!=', 'closed')->get();
			$tv_requests 	= Issue::where('user_id', '=', $id)->where('type', '=', 'request')->where('topic', '=', 'tv')->where('status', '!=', 'closed')->get();
			$tv_issues		= Issue::where('user_id', '=', $id)->where('type', '=', 'issue')->where('topic', '=', 'tv')->where('status', '!=', 'closed')->get();
			$music_requests = Issue::where('user_id', '=', $id)->where('type', '=', 'request')->where('topic', '=', 'music')->where('status', '!=', 'closed')->get();
			$music_issues	= Issue::where('user_id', '=', $id)->where('type', '=', 'issue')->where('topic', '=', 'music')->where('status', '!=', 'closed')->get();
			$closed	= Issue::where('user_id', '=', $id)->where('status', '=', 'closed')->paginate(4);
		};

		return View::make('site.pages.home', compact('search', 'users', 'user', 'id', 'movie_requests', 'tv_requests', 'movie_issues', 'tv_issues', 'music_requests', 'music_issues', 'closed', 'bodyClass'));
	}

	public function updateIssueStatus($id, Request $request)
	{
		$issue = Issue::find($id);
		$issue->status = $request->input('status');
		$issue->save();

		return Redirect::to('issue/'.$id)
			->with('info', "Successfully updated the issue!");
	}

	public function updateIssueDescription($id, Request $request)
	{
		$issue = Issue::find($id);

		if($request->input('issue_description') === $issue->issue_description)
		{
			return back()
				->with('warning', "If you want to update the description of the issue you need to actually change it!");
		}

		$rules = array(
			'issue_description'	=> 'required'
		);

		$validator = Validator::make($request->all(), $rules);

		if($validator->fails())
		{
			return back()
				->with('warning', "You need to write a description of the issue!");
		}

		$issue->issue_description = $request->input('issue_description');
		$issue->save();

		// send update email eventually here

		return Redirect::to('issue/'.$id)
			->with('info', "Successfully updated the issue description!");
	}

	public function destroyIssue($id)
	{
		$issue = Issue::find($id);
		$issue->delete();

		return Redirect::to('/')
			->with('info', "Successfully deleted the issue!");
	}

}
