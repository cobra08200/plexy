<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
									AuthorizableContract,
									CanResetPasswordContract
{
	use Authenticatable, Authorizable, CanResetPassword;

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'users';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['name', 'email', 'password'];

	/**
	* The attributes excluded from the model's JSON form.
	*
	* @var array
	*/
	protected $hidden = ['password', 'remember_token'];

	/**
    * Boot the model.
    *
    * @return void
    */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->token = str_random(30);
        });
    }

	/**
	* Set the password attribute.
	*
	* @param string $password
	*/
	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = bcrypt($password);
	}

	/**
	* Confirm the user.
	*
	* @return void
	*/
	public function confirmEmail()
	{
		$roles = array_fetch(Role::all()->toArray(), 'name');

		$this->verified = true;
		$this->token = null;
		$this->roles()->attach($this->getIdInArray($roles, 'user'));

		$this->save();
	}

	/**
	* Get the messages a user has
	*/
	public function messages()
	{
		return $this->hasMany('App\Message');
	}

	/**
	* Get the messages a user has
	*/
	public function issues()
	{
		return $this->hasMany('App\Issues');
	}

	/**
	* Get the roles a user has
	*/
	public function roles()
	{
		return $this->belongsToMany('App\Role', 'user_roles');
	}

	/**
	* Find out if user is a user, based on if has any roles
	*
	* @return boolean
	*/
	public function isUser()
	{
		$roles = $this->roles->toArray();
		return !empty($roles);
	}

	/**
	* Find out if user has a specific role
	*
	* $return boolean
	*/
	public function hasRole($check)
	{
		return in_array($check, array_fetch($this->roles->toArray(), 'name'));
	}

	/**
	* Get key in array with corresponding value
	*
	* @return int
	*/
	private function getIdInArray($array, $term)
	{
		foreach ($array as $key => $value) {
			if ($value == $term) {
				return $key + 1;
			}
		}

	// throw new UnexpectedValueException;
	}
	/**
	* Add roles to user to make them a role
	*/
	public function makeRole($title)
	{
		$assigned_roles = array();

		$roles = array_fetch(Role::all()->toArray(), 'name');

		switch ($title) {
			case 'super_admin':
			$assigned_roles[] = $this->getIdInArray($roles, 'super_admin');
			case 'admin':
			$assigned_roles[] = $this->getIdInArray($roles, 'admin');
			case 'user':
			$assigned_roles[] = $this->getIdInArray($roles, 'user');
			break;
	//  default:
	//  throw new \Exception("The user status entered does not exist");
		}

		$this->roles()->attach($assigned_roles);
	}

}
