<?php

class Request extends Eloquent {

	protected $table = 'requests';

	protected $fillable = ['user_id', 'tmdb', 'status',
						   'topic', 'poster_url', 'backdrop_url'];

}