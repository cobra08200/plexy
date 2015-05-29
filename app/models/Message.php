<?php

class Message extends Eloquent {

	/**
	 * Get the message's body.
	 *
	 * @return string
	 */
	public function body()
	{
		return $this->body;
	}

	/**
	 * Get the message's author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	/**
	 * Get the message's issue's.
	 *
	 * @return Issue
	 */
	public function issue()
	{
		return $this->belongsTo('Issue');
	}


	/**
	 * Get the post's author.
	 *
	 * @return User
	 */
	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

	/**
	 * Get the date the post was created.
	 *
	 * @param \Carbon|null $date
	 * @return string
	 */
	public function date($date=null)
	{
		if(is_null($date)) {
			$date = $this->created_at;
		}

		return String::date($date);
	}

	/**
	 * Returns the date of the blog post creation,
	 * on a good and more readable format :)
	 *
	 * @return string
	 */
	public function created_at()
	{
		return $this->date($this->created_at);
	}

	/**
	 * Returns the date of the blog post last update,
	 * on a good and more readable format :)
	 *
	 * @return string
	 */
	public function updated_at()
	{
		return $this->date($this->updated_at);
	}
}
