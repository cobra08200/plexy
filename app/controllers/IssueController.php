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
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		$user = Auth::user();

		$title = Lang::get('admin/blogs/title.blog_management');
		// Get all the issues
		// $issues = $this->issue->orderBy('created_at', 'DESC')->paginate(10);
		$issues = $this->issue;

		// Show the page
		return View::make('site/pages/index', compact('issues', 'title', 'user'));
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


	/**
	 * Show a list of all the blog issues formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getDataAdmin()
	{
		// admin view all
		$issues = DB::table('issues')
		->join('users', 'users.id', '=', 'issues.user_id')
		->select(array('issues.status as status', 'issues.id as id', 'users.username as username', 'issues.topic as topic', 'issues.id as comments', 'issues.created_at'));

		return Datatables::of($issues)

		->edit_column('comments', '{{ DB::table(\'comments\')->where(\'issue_id\', \'=\', $id)->count() }}')

		->add_column('actions', '<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
			<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
			')

		->remove_column('id')

		->make();
	}

	/**
	 * Show a list of all the blog issues formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData()
	{
		// admin view all
		$posts = DB::table('posts')
		->join('users', 'users.id', '=', 'posts.user_id')
		->select(array('posts.id as id', 'users.username', 'posts.user_id as user', 'posts.title', 'posts.id as comments', 'posts.created_at'));

		return Datatables::of($posts)

		->edit_column('comments', '{{ DB::table(\'comments\')->where(\'post_id\', \'=\', $id)->count() }}')

		->add_column('actions', '<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/edit\' ) }}}" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
			<a href="{{{ URL::to(\'admin/blogs/\' . $id . \'/delete\' ) }}}" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
			')

		->remove_column('id')

		->make();
	}
}
