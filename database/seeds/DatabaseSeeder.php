<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RoleTableSeeder::class);

        // When enabled, this creates an admin and a user account.
        // $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
