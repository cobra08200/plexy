# Plexy

An issue and request ticketing system to supplement [Plex](https://plex.tv/). Tools used in the project include Laravel PHP framework, MySQL, JQuery, and Semantic-UI CSS framework. The project name is not final.

## Demo

You can view a live demo of Plexy [here](https://plexydemo.ehumps.me). This demo is connected to a Plex Server version 0.9.15.1 on Ubuntu 12.04 using a free Plex account.

## Requirements and Installation

* In order to follow the installation steps below you must be using Laravel [Homestead](https://laravel.com/docs/5.1/homestead) which uses [vagrant](https://www.vagrantup.com/) for local development.

---

1. Clone the project.

2. After configuring [homestead](https://laravel.com/docs/5.1/homestead#configuring-homestead), run `vagrant up`.

3. Once the virtual machine is provisioned, run `vagrant ssh`.

4. Change directory to the git repository being shared to the VM. This is going to be unique to how you configured step 2.

5. Install composer dependencies `sudo composer install`.

6. Migrate and seed the database `php artisan migrate --seed`.

⋅⋅* If you enabled the [UserTableSeeder](https://github.com/ehumps/plexy/blob/master/database/seeds/DatabaseSeeder.php) in step 6, two accounts are created by default:

| Username      | Password      |
| :-----------: |:-------------:|
| admin         | admin         |
| user          | user          |

7. Browse to your hosts custom domain created with Homestead or `http://localhost:800/`.

The current config/database.php file expects a MySQL database connection using the following name and credentials.  You may update these to suit your own setup if you choose to not run the vagrant steps above:

| Database      | Username      | Password      |
|:-------------:|:-------------:|:-------------:|
| plexy         | homestead     | secret        |


The config/mail.php file has been set to `'pretend' => false` - so SMTP settings are required.

## License

Plexy is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
