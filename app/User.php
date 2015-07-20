<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

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
	protected $fillable = ['msisdn', 'code', 'remember_token'];

	function createOrUpdate($data) {
		$model = $this->whereMsisdn($data['msisdn'])->first();

		// if this record is new then create a new one
		if ($model == null) {
			return $this->create($data);
		}

		// if we reach here it means this msisdn exists,
		// Update it's detals
		$model->fill($data);

		return $model->save();
	}

	public function isValidCode($data) {
		$user = $this->where($data)->first();

		return $user != null;
	}

}
