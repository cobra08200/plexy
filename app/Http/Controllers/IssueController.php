<?php

namespace App\Http\Controllers;

use Auth;
use View;
use Session;
use App\Issue;
use App\User;
use App\Message;
use App\Mailers\AppMailer;
use App\Mailers\AppPushover;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class IssueController extends Controller {

   /*
	* This is the main function of the application. It interprets the submission and determines the logical workflow.
	*
	* URL: search/submit
	*/
	public function searchSubmit(Request $request, AppMailer $mailer)
	{
		// dd($request->all());

		// Gathers submission round the request/issue is going through, be it first or advanced.
		$round = $request->input('round');

		// Various validation boolean variables are built here that are used throughout the submission analysis.
		// Verifies a search was chosen before submission.
		$tmdbMissing = Validator::make($request->all(), [
			'tmdb' => 'required'
		]);

		// Gathers uniqueness of submitted item.
		$tmdbPostedAndUnique = Validator::make($request->all(), [
			'tmdb' => 'required|unique:issues,tmdb'
		]);

		// Gathers uniqueness of submitted item against current authenticated user.
		$tmdbPostedAndUniqueToAuthenticatedUser = Validator::make($request->all(), [
			'tmdb' => 'unique:issues,tmdb,NULL,NULL,user_id,' . Auth::id() . ''
		]);

		// Gathers uniqueness of TV season number submitted item.
		$tvSeasonUnique = Validator::make($request->all(), [
			'season' => 'sometimes|unique:issues,tv_season_number'
		]);

		// Gathers uniqueness of TV episode number submitted item.
		$tvEpisodeUnique = Validator::make($request->all(), [
			'episode' => 'sometimes|unique:issues,tv_episode_number'
		]);

		// Gathers uniqueness of music album track number submitted item.
		$musicAlbumTrackUnique = Validator::make($request->all(), [
			'track' => 'sometimes|unique:issues,album_track_number'
		]);

		//  Verifies an issue description was included before submission.
		$issueDescriptionRequired = Validator::make($request->all(), [
			'issue_description' => 'required'
		]);

		if ($tmdbMissing->fails())
		{
			return redirect()->back()
				->with('warning', "Woops.  You need to search for something first.");
		}

		// This section blocks multiple identical episode/track/movie requests in general.
		if ($request->input('type') == 'request')
		{
			if ($tmdbPostedAndUniqueToAuthenticatedUser->fails())
			{
				return redirect()->back()
					->with('warning', "Woops.  You already requested this.")
					->withInput();
			}

			elseif ($tmdbPostedAndUnique->fails())
			{
				return redirect()->back()
					->with('warning', "Woops.  Someone else already requested this.")
					->withInput();
			}
		}

		// This section blocks multiple identical episode/track/movie reports from the same person.
		if ($request->input('type') == 'issue')
		{
			if ($request->input('topic') == 'tv')
			{
				if ($tvSeasonUnique->fails() && $tvEpisodeUnique->fails() && $tmdbPostedAndUniqueToAuthenticatedUser->fails())
				{
					return redirect('/')
						->with('warning', "Woops.  You already reported this exact same episode.")
						->withInput();
				}
			}
			if ($request->input('topic') == 'music')
			{
				if ($musicAlbumTrackUnique->fails() && $tmdbPostedAndUniqueToAuthenticatedUser-fails())
				{
					return redirect()->back()
						->with('warning', "Woops.  You already reported this exact same track.")
						->withInput();
				}
			}
			if ($request->input('topic') == 'movie')
			{
				// This section is incomplete.
			}
		}

		// Begin creating the object.
		$issue = new Issue;
		$issue->user_id = Auth::id();
		// Music album does not require year in title, nor does an object passing through for a second time.
		if (strtolower($request->input('topic')) == 'music' || $round == 'advanced')
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

		// If an object is passing through for the advanced round, it append the additional details.
		if (isset($round) && $round == 'advanced')
		{
			if ($issue->type == 'issue')
			{
				if ($issueDescriptionRequired->fails())
				{
					if ($issue->topic == 'tv') {
						return $this->issue_tv($issue)
							->with('warning', "Woops.  You need to describe the issue first.");
					}
					if ($issue->topic == 'music') {
						return $this->issue_music($issue)
							->with('warning', "Woops.  You need to describe the issue first.");
					}
					if ($issue->topic == 'movies') {
						return $this->issue_movie($issue)
							->with('warning', "Woops.  You need to describe the issue first.");
					}
				}
				else
				{
					$issue->report_option = $request->input('report_option');
					$issue->issue_description = $request->input('issue_description');
					if ($issue->topic == 'tv')
					{
						$issue->tv_season_number = $request->input('season');

						if ($issue->report_option != 'Missing Episode') {
							$issue->tv_episode_number = $request->input('episode');
						}
						// $issue->tv_episode_overview = $request->input('tv_episode_overview');
						// $issue->tv_episode_still_path = $request->input('still_path');
						// $issue->vote_average = $request->input('vote_average');
					}
					if ($issue->topic == 'music')
					{
						if ($issue->report_option != 'Missing Track') {
							$issue->album_track_number = $request->input('track');
						}
					}
				}
			}
		}

		// if ($request->ajax())
		// {
			// First round report detection
			if ($issue->type == 'issue' && $round != 'advanced')
			{
				if ($issue->topic == 'tv')
				{
					return $this->issue_tv($issue);
				}
				if ($issue->topic == 'movies')
				{
					return $this->issue_movie($issue);
				}
				if ($issue->topic == 'music')
				{
					return $this->issue_music($issue);
				}
			}
		// }

		$issue->save();

		if (env('APP_ENV') == 'production')
		{
			$user = Auth::user();

			// send pusher notification to admin
			if (!empty(env('PUSHOVER_TOKEN')))
			{
				$push = new \App\Mailers\Pushover();
				$push->setToken(config('services.pushover.token'));
				$push->setUser(config('services.pushover.user'));

				$push->setTitle('Plexy');
				if ($issue->type == 'issue') {
					$push->setMessage($user->name . " reported " . $issue->content);
				} elseif ($issue->type == 'request') {
					$push->setMessage($user->name . " requested " . $issue->content);
				}
				$push->setUrl(route('issue.id', ['id' => $issue->id]));
				$push->setUrlTitle($issue->content);

				$go = $push->send();
			}

			// send email
			$mailer->sendNewRequestEmailTo($user, $issue);

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

	public function getIssueView($id, Request $request)
	{
		if ($request->ajax())
		{
			$issue = Issue::find($id);

			if (Issue::where('id', '=', $id)->exists())
			{
				$issue = Issue::find($id);

				$messages = Message::where('issue_id', '=', $id)->get();

				$thumbExtension = last(explode(".", $issue->poster_url));

				return View::make('site/pages/issues', compact('issue', 'messages', 'thumbExtension'));
			}
		}

		return Redirect::to('/');

	}

	public function getIndex(Request $request)
	{
		$tickets = Issue::where('status', '!=', 'closed')->get();

		$closedTickets	= Issue::where('status', '=', 'closed')->simplePaginate(4);

		return View::make('site.pages.home', compact('tickets', 'closedTickets'));
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

		if ($request->input('issue_description') === $issue->issue_description)
		{
			return back()
				->with('warning', "If you want to update the description of the issue you need to actually change it!");
		}

		$rules = array(
			'issue_description'	=> 'required'
		);

		$validator = Validator::make($request->all(), $rules);

		if ($validator->fails())
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
