# Plexy

An issue and request ticketing system to supplement [Plex](https://plex.tv/). Tools used in the project include Laravel PHP framework, MySQL, JQuery, and Semantic-UI CSS framework. The project name is not final.


## Demo

You can view a live demo of Plexy [here](https://plexydemo.ehumps.me). The demo currently has emailing disabled. This demo is connected to a Plex Server running version 0.9.15.1 on Ubuntu 12.04 using a free Plex account. To learn more about connecting your Plex server to Plexy, see part 2 of the installation guide.


## Requirements and Installation

* In order to follow the installation steps below you must be using Laravel [Homestead](https://laravel.com/docs/5.1/homestead) which uses [vagrant](https://www.vagrantup.com/) for local development.

---

#### Part 1

1. Clone the project.

2. After configuring [homestead](https://laravel.com/docs/5.1/homestead#configuring-homestead), run `vagrant up`.

3. Once the virtual machine is provisioned, run `vagrant ssh`.

4. Change directory to the git repository being shared to the VM. This is going to be unique to how you configured homestead during step 2. For me it is `cd code/plexy/`

5. Install composer dependencies `sudo composer install`.

6. Ensure the homestead virtual machine has a MySQL database named `plexy`.

  * Note: You can enable the [UserTableSeeder](https://github.com/ehumps/plexy/blob/master/database/seeds/DatabaseSeeder.php) in step 6. This will create two accounts that are useful for local development. If enabled, it is recommended to not run the installer in part 2. You can skip the installer by configuring the `.env` file as well as placing a text file named `installed` inside the storage directory with the contents of `1.0`. These are the same accounts active for the demo:

| Username      | Password      |
| :-----------: |:-------------:|
| admin         | admin         |
| user          | user          |


7. Browse to your hosts custom domain created with Homestead, your virtual machine IP address (`192.168.10.10` for me), or `http://localhost:8000/`.

The current config/database.php file expects a MySQL database connection using the following name and credentials.  You may update these to suit your own setup if you choose to not run the vagrant steps above:

| Database      | Username      | Password      |
|:-------------:|:-------------:|:-------------:|
| plexy         | homestead     | secret        |


The config/mail.php file has been set to `'pretend' => false` - so SMTP settings are required. If you are using Mandrill as your email provider, then all you need is an API key and to set you `.env` mail driver to `mandrill` instead of `smtp`.

---

#### Part 2 - First Run Installation Guide

* Warning: Do not seed the UserTableSeeder if you want to successfully complete the installer.  This project currently depends on the user with the id equal to 1 on the user table in the database to be the main administrator.  This is a potential feature fix for a future release.


1. Upon first run, you will be presented with the installer as seen below. The installer will help prepare several dependencies the project utilizes, namely The Movie DB (TMDB), Spotify, and of course Plex.
  ![Step 1](https://plexydemo.ehumps.me/assets/img/1.png)

2. There are several environment variables we must configure before Plexy can function. Two mandatory variables include a [TMDB API](https://www.themoviedb.org/faq/api) key and a URL to your Plex server. If Plexy is running on the same machine as Plex, then http://localhost:32400 would suffice this variable.

  * Optionally, you may configure several other API keys for extra functionality:
    * Email: Mandrill (If you do not include an email API make sure your mail configuration is set to pretend mode or that your environment is set to local instead of production)
    * Music: Spotify
    * Pushover: Mobile Device Push Notifications

  ![Step 2](https://plexydemo.ehumps.me/assets/img/2.png)

3. Once your API keys are saved to the .env file you may continue to the next step.
  ![Step 3](https://plexydemo.ehumps.me/assets/img/3.png)

4. Verify that the presented directory paths have the corresponding file permissions.
  ![Step 4](https://plexydemo.ehumps.me/assets/img/4.png)

5. Plexy will now register itself as a "Device" to your Plex account.  This allows Plexy to access your servers for the issue reporting function of Plexy.
  * In general, every device you register to your account generates a unique API key for use with your Plex server. You can see that Plexy added a new line to your .env file next to Plex Token if all file permissions are correct on your server.
  * Note: This step also creates your admin account using the same credentials as your Plex account at the time of registration.
    * Warning: If you happen to change you Plex credentials at a later time, Plexy will only remember your credentials at the time of account creation on Plexy.

  ![Step 5](https://plexydemo.ehumps.me/assets/img/5.png)

6. If you reach the finished page, then your Plexy admin account is successfully created and ready to go.
  ![Step 6](https://plexydemo.ehumps.me/assets/img/6.png)

7. Clicking finish brings you to the main login page which all users will see from now on.
  ![Step 7](https://plexydemo.ehumps.me/assets/img/7.png)

---

1. This is an example of what Plexy looks like as a device connected to your Plex server.
  ![Step 8](https://plexydemo.ehumps.me/assets/img/8.png)


## Dependencies

This project utilizes several external dependencies as seen in the composer.json file as well as the frameworks and technologies mentioned above:

* [RachidLaasri/LaravelInstaller](https://github.com/RachidLaasri/LaravelInstaller)


## License

Plexy is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
