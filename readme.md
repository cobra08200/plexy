#Plexy

Plexy is a issue and request (ticketing system) tracker for Plex.

## Features

* Bootstrap 3.x
* Confide for Authentication and Authorization
* Back-end
	* User and Role management
	* CRUD tickets
* Front-end
	* User login, registration, forgot password
* Packages included:
	* [Confide](https://github.com/zizaco/confide)
	* [Entrust](https://github.com/zizaco/entrust)
	* [Ardent](https://github.com/laravelbook/ardent)
	* [Generators](https://github.com/JeffreyWay/Laravel-4-Generators/blob/master/readme.md)

-----

##Requirements

	Vagrant

##How to install
### Step 1: Start Vagrant
```bash
$ vagrant up
```

### Step 2: Go to localhost:8080

### Step 3: Start Page (Three options for proceeding)

### User login with commenting permission

    username : user
    password : user

## Create a new user
Create a new user at /user/create

### Admin login

    username: admin
    password: admin

-----
### Production Launch

By default debugging is enabled. Before you go to production you should disable debugging in `app/config/app.php`

```
    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => false,
```

## Troubleshooting

## Composer giving you trouble

Try using this with doing the install instead.

```bash
$ sudo composer install
```

## License

This is free software distributed under the terms of the MIT license
