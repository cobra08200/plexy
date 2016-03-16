# Plexy

An issue and request ticketing system to supplement [Plex](https://plex.tv/). Tools used in the project include Laravel PHP framework, MySQL, JQuery, and Semantic-UI CSS framework.

The main features of Plexy are to report current issues with content on a Plex server, and to request new content to be added to a Plex server. Reporting content will access your Plex server so users can pull live information on your server they have discovered to contain errors, such as unplayable content or mismatched metadata. Requesting content will access The Movie DB (TMDB) and Spotify to pull movie, TV, and music information for users to request.

User registration is linked to your [Plex friends](https://app.plex.tv/web/app#!/settings/users/friends) list. If they are your Plex friend, they will be able to register and login to Plexy. If someone is already registered on Plexy and you later remove them as a friend on Plex, they will be denied access to Plexy.

Plexy does not automate downloading any content. The current version of Plexy is strictly a ticketing system where users can report and request content. An administrator can send updates via email back to the user on the status of their report or request. Users can communicate with the administrator and only see communication on tickets that they created. Users can see all current requests and reports from other users too, however they can not see the communication thread between the ticket owner and the administrator at this time.


## Demo

You can view a live demo of Plexy [here](https://plexydemo.ehumps.me). The demo currently has emailing disabled. This demo is connected to a Plex Server running version 0.9.15.1 on Ubuntu 12.04 using a free Plex account. On the Plex server is dummy content to demonstrate how Plexy handles reporting. The dumby content is blank .mp4 files using [Plex naming convention](https://support.plex.tv/hc/en-us/categories/200028098-Media-Preparation).  The content available to test reporting with is the TV show [Unbreakable Kimmy Schmidt](https://www.themoviedb.org/tv/61671-unbreakable-kimmy-schmidt), and the movies [Alien](https://www.themoviedb.org/movie/348-alien) as well as [Tommy Boy](https://www.themoviedb.org/movie/11381-tommy-boy). To learn more about linking your Plex server to Plexy, see part 2 of the installation guide.


## Requirements and Installation

* In order to follow the installation steps below, you must first be using Laravel [Homestead](https://laravel.com/docs/5.1/homestead) which uses [vagrant](https://www.vagrantup.com/) for local development.

---

#### Part 1

1. Clone the project.

2. After configuring [homestead](https://laravel.com/docs/5.1/homestead#configuring-homestead), run `vagrant up`.

3. Once the virtual machine is provisioned, run `vagrant ssh`.

4. Change directory to the git repository being shared to the VM. This is going to be unique to how you configured homestead during step 2. For me the command is `cd code/plexy/`.

5. Install composer dependencies `sudo composer install --no-scripts`.

6. Ensure your homestead virtual machine has a MySQL database named `plexy`.

  * The current config/database.php file expects a MySQL database connection using the following name and credentials seen below. You may update these to suit your own setup if you choose to not run the vagrant steps above:

  | Database      | Username      | Password      |
| :-------------: |:-------------:|:-------------:|
|  plexy          | homestead     | secret        |

  * Note: You can enable the [UserTableSeeder](https://github.com/ehumps/plexy/blob/master/database/seeds/DatabaseSeeder.php) in step 6. This will create two accounts that are useful for local development. If enabled, it is recommended to not run the installer in part 2. You can skip the installer by configuring the `.env` file as well as placing a text file named `installed` inside the storage directory with the contents of `1.0`. The accounts that are created will be the same accounts active for the demo:

  | Username      | Password      |
|   :-----------: | :-----------: |
|   admin         | admin         |
|   user          | user          |


7. Browse to either your custom domain created with Homestead, your virtual machine IP address (`192.168.10.10` for me), or `http://localhost:8000/` if your virtual machine is forwarding to this port.


 * The config/mail.php file has been set to `'pretend' => false`, so SMTP settings are required. If you are using [Mandrill](https://mandrillapp.com/) as your email provider, then all you need is an API key and to set you `.env` mail driver to `mandrill` instead of `smtp`.

---

#### Part 2 - First Run Installation Guide

* Warning: Do not seed the UserTableSeeder if you want to successfully complete the installer. This project currently depends on the user with the id equal to 1 on the user table in the database to be the main administrator. This is a potential feature fix for a future release.


1. Upon first run you will be presented with the installer as seen below. The installer will help prepare several dependencies the project utilizes, namely making sure you have provided API keys to TMDB, Spotify, and of course Plex.
  ![Step 1](https://plexydemo.ehumps.me/assets/img/1.png)

2. There are several environment variables we must configure before Plexy can function. Two mandatory variables include a [TMDB API](https://www.themoviedb.org/faq/api) key and the URL to your Plex server. If Plexy is running on the same machine as Plex, then typically `http://localhost:32400` would suffice this variable.

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

1. This is an example of what Plexy looks like as a device connected to your Plex server. Do not remove this device or you will need to acquire a different token and replace it in your `.env` file.
  ![Step 8](https://plexydemo.ehumps.me/assets/img/8.png)


## Dependencies

This project utilizes several external dependencies as seen in the composer.json file as well as the frameworks and technologies mentioned above:

* [RachidLaasri/LaravelInstaller](https://github.com/RachidLaasri/LaravelInstaller)


## License

Plexy is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).  Feel free to contribute by any means to this project, all thoughts are welcome.
