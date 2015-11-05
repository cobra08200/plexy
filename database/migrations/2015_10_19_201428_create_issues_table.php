<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            //user who requested
            $table->integer('user_id')->unsigned()->index();
            //unique tmdb id
            $table->string('tmdb');
            $table->enum('status', array('open', 'pending', 'closed'))->default('open');
            $table->enum('topic', array('miscellaneous', 'movies', 'music', 'tv'));
            $table->enum('type', array('issue', 'request'));
            //title
            $table->text('content');
            $table->string('poster_url');
            $table->string('backdrop_url');
            $table->string('vote_average');
            // $table->string('plex_url');
            //issue portion
            $table->text('report_option');
            $table->text('issue_description');
            //if it is a tv show, get season/episode
            $table->string('tv_season_number')->nullable(); //season number
            $table->string('tv_episode_number')->nullable(); //episode number
            $table->string('album_track_number')->nullable(); //episode number
            // $table->string('tv_episode_name')->nullable(); //episode name
            // $table->string('tv_episode_overview')->nullable(); //episode overview
            // $table->string('tv_episode_still_path')->nullable(); //episode still path
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('issues');
    }
}
