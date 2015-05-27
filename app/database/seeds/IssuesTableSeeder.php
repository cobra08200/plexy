<?php

class IssuesTableSeeder extends Seeder {

    protected $content = 'In mea autem etiam menandri, quot elitr vim ei';

    public function run()
    {
        DB::table('issues')->delete();

        $user_id = User::first()->id;

        DB::table('issues')->insert( array(
            array(
                'user_id'    => $user_id,
                // 'topic'      => 'movies',
                'poster_url' => 'http://placehold.it/200x300',
                'content'    => $this->content,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'user_id'    => $user_id,
                // 'topic'      => 'music',
                'poster_url' => 'http://placehold.it/200x300',
                'content'    => $this->content,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'user_id'    => $user_id,
                // 'topic'      => 'tv',
                'poster_url' => 'http://placehold.it/200x300',
                'content'    => $this->content,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ))
        );
    }

}
