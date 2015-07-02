<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Carbon\Carbon;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, PresentableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $primaryKey = 'user_id';
    public $timestamps = true;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
    protected $appends = [];
    protected $fillable = ['role_id', 'username','email','password', 'key'];
	protected $guarded = [];
	protected $dates = ['subscription_expiry'];

    protected $presenter = "UserPresenter";

	// Relations
	//public function role() {
	//	return $this->belongsTo('Role');
	//}

	public function profile() {
		return $this->hasOne('Profile');
	}

	public function objects() {
		return $this->hasMany('Object');
	}

	public function publishedObjects() {
		return $this->hasMany('Object')->where('status','Published');
	}

	public function favorites() {
		return $this->hasMany('Favorite');
	}

	// Helpers
	public function isValidForSignUp($input) {
		$rules = array(
			'username' => 'required|unique:users,username|min:3|varchar:small',
			'email' => 'required|unique:users,email|email|varchar:small',
			'password' => 'required|confirmed|min:6'
		);

		$validator = Validator::make($input, $rules);
		return $validator->passes() ? true : $validator->errors();
	}

	public function isValidForLogin() {
		$rules = array(
			'email' => 'required',
			'password' => 'required',
            'rememberMe' => 'boolean'
		);

		return Auth::attempt(array('email' => Input::get('email', null), 'password' => Input::get('password', null)), Input::get('rememberMe', false));
	}

	public function isValidKey($email, $key) {
		$user = User::where('email', urldecode($email))->where('key', $key)->first();
		if (!empty($user)) {
			$user->role_id = UserRole::Member;
			return $user->save();			
		} else {
			return false;
		}
	}

	public function setPasswordAttribute($value) {
		$this->attributes['password'] = Hash::make($value);
	}

    // Attribute accessors
	public function getDaysUntilSubscriptionExpiresAttribute() {
		return Carbon::now()->diffInDays($this->subscription_expiry);
	}
}
