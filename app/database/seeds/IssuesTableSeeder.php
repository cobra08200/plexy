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
                'content'    => $this->content,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'user_id'    => $user_id,
                // 'topic'      => 'music',
                'content'    => $this->content,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'user_id'    => $user_id,
                // 'topic'      => 'tv',
                'content'    => $this->content,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ))
        );
    }

}
