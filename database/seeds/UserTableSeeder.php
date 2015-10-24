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

        $user = User::create(array(
            'name' => 'user',
            'email' => 'user@user.org',
            'password' => bcrypt('user'),
            ));
        $user->makeRole('user');

        $admin = User::create(array(
            'name' => 'admin',
            'email' => 'admin@admin.org',
            'password' => bcrypt('admin'),
            ));
        $admin->makeRole('admin');

        $user = User::create(array(
            'name' => 'super_admin',
            'email' => 'super_admin@superadmin.org',
            'password' => bcrypt('super_admin'),
            ));
        $user->makeRole('super_admin');
    }
}
