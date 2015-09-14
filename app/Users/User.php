<?php namespace Nimbus\Users;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

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
	protected $fillable = ['name', 'email', 'password', 'verified', 'verification_code'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


    public function logins()
    {
        return $this->hasMany('Nimbus\Users\Login');
    }

    public function droplets()
    {
        return $this->hasMany('Nimbus\Droplets\Droplet');
    }

    public function storages()
    {
        return $this->hasMany('Nimbus\Storages\Storage');
    }


    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public static function register($name, $email, $password, $verified = false)
    {
        $verification_code = str_random(32);

        return new static(compact('name', 'email', 'password', 'verified', 'verification_code'));
    }

    public function storage($key = null)
    {
        if($this->storages()->count())
        {
            $storage = $this->storages()->latest()->first();

            if(empty($key)) return $storage;

            return $storage->$key;
        }

        return false;
    }

}
