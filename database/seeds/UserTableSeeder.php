<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create(array(
            'name'      => 'admin',
            'email'     => 'admin@admin.org',
            'password'  => 'admin',
            'verified'  => true,
        ));
        $admin->makeRole('admin');

        $user = User::create(array(
            'name'      => 'user',
            'email'     => 'user@user.org',
            'password'  => 'user',
            'verified'  => true,
        ));
        $user->makeRole('user');
    }
}
