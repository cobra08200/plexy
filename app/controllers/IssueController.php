<?php

class IssueController extends BaseController {

	/**
	 * Issue Model
	 * @var Issue
	 */
	protected $issue;

	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Inject the models.
	 * @param Issue $issue
	 * @param User $user
	 */
	public function __construct(Issue $issue, User $user)
	{
		parent::__construct();

		$this->issue = $issue;
		$this->user = $user;
	}


	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($slug)
	{
		// Get this blog post data
		$post = $this->post->where('slug', '=', $slug)->first();

		// Check if the blog post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that
			// a page or a blog post didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}

		// Get this post comments
		$comments = $post->comments()->orderBy('created_at', 'ASC')->get();

		// Get current user and check permission
		$user = $this->user->currentUser();
		$canComment = false;
		if(!empty($user)) {
			$canComment = $user->can('post_comment');
		}

		// Show the page
		return View::make('site/blog/view_post', compact('post', 'comments', 'canComment'));
	}

	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView($slug)
	{

		$user = $this->user->currentUser();
		$canComment = $user->can('post_comment');
		if ( ! $canComment)
		{
			return Redirect::to($slug . '#comments')->with('error', 'You need to be logged in to post comments!');
		}

		// Get this blog post data
		$post = $this->post->where('slug', '=', $slug)->first();

		// Declare the rules for the form validation
		$rules = array(
			'comment' => 'required|min:3'
			);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			// Save the comment
			$comment = new Comment;
			$comment->user_id = Auth::user()->id;
			$comment->content = Input::get('comment');

			// Was the comment saved with success?
			if($post->comments()->save($comment))
			{
				// Redirect to this blog post page
				return Redirect::to($slug . '#comments')->with('success', 'Your comment was added with success.');
			}

			// Redirect to this blog post page
			return Redirect::to($slug . '#comments')->with('error', 'There was a problem adding your comment, please try again.');
		}

		// Redirect to this blog post page
		return Redirect::to($slug)->withInput()->withErrors($validator);
	}

	public function postApi()
	{

		// dd(Input::all());

		// validator
		$rules = array(
			'year'		=> 'required'  // checker to see if they actually used a suggestion
		);

		$unique = array(
			'tmdb'		=> 'unique:issues'  // check tmdb to see if anyone else in plexy has requested it
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			// get the error messages from the validator
			$messages = $validator->messages();

			// redirect our user back to the form with the errors from the validator
			return Redirect::back()
			->withErrors($validator);
		}
		else
		{
			// get imgur ready to accept themoviedb img

			// return array(
			// 	'imgur_apikey'   => '7b310c90e258519cefd34f5a4e88d0ba589a9914', // Imgur API key
			// 	'imgur_format'   => 'json', // json OR xml
			// 	'imgur_xml_type' => 'object', // array OR object
			// );

			// create new issue
			$issue = new Issue;
			$issue->user_id = Auth::id();
			$issue->content = Input::get('title') . ' (' . Input::get('year') .')';
			$issue->poster_url = Input::get('poster');
			$issue->backdrop_url = Input::get('backdrop');
			$issue->topic = Input::get('topic');
			$issue->tmdb = Input::get('tmdb');

			$issue->save();

			// send email
			$username = 	Auth::user()->username;
			$email = 		Auth::user()->email;
			$issue_id =		$issue->id;
			$poster_url =	$issue->poster_url;
			$title =	$issue->content;

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
				$message->from('requests@ehumps.me', 'Plexy');
				$message->to($email, $username)->subject('Plexy - Request #'.$issue_id);
			});

			//return to after form submit
			return Redirect::back();
		}
	}

	public function getIssueView($id)
	{
		// Auth::loginUsingId(2);
		$issue = Issue::findOrFail($id);

		return View::make('site/pages/issues', compact('issue'));
	}

	public function getIndex()
	{

		$search_url = Request::getQueryString();
		parse_str($search_url, $search);

		$users 		= User::all();
		$user 		= Auth::user();
		$id 		= Auth::id();

		if($user->hasRole('admin'))
		{
			$issues  	= Issue::paginate(12);
		}
		else
		{
			$issues 	= Issue::where('user_id', '=', $id)->where('status', '=', 'open')->paginate(10);
		};
		// if($user->hasRole('admin') && Input::get('status'))
		// {
		// 	$issues 	= Issue::where('status', Request::only('status'))->paginate(10);
		// }
		// if($user->hasRole('admin') && Input::get('topic'))
		// {
		// 	$issues 	= Issue::where('topic', Request::only('topic'))->paginate(10);
		// }
		// if($user->hasRole('admin') && Input::get('status') && Input::get('topic'))
		// {
		// 	$issues 	= Issue::where('status', Request::only('status'))->where('topic', Request::only('topic'))->paginate(10);
		// }

		return View::make('site.pages.home', compact('search', 'users', 'user', 'id', 'issues'));
	}

}
