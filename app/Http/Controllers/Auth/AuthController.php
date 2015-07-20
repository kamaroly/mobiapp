<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Services\SendNotification\SmsSendNotification;
use App\User;
use Hash;

class AuthController extends Controller {
	protected $sendNotification;
	function __construct(SmsSendNotification $sendNotification, User $user) {
		$this->sendNotification = $sendNotification;

		$this->user = $user;
	}
	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function registerMsisdn($msisdn) {
		// Generate the token
		$rememberToken = $msisdn . Hash::make($msisdn);

		// Prepare data and insert in the model
		$data = [
			'msisdn' => $msisdn,
			'code' => rand(10000, 99999),
			'remember_token' => $rememberToken,
		];

		$this->user->createOrUpdate($data);

		// Send verification code
		$this->sendSms($data);
		// Return generated token
		return $rememberToken;
	}

	/**
	 * Code verification
	 */
	public function verifyCode($msisdn, $code) {

		// Prepare data
		$data = [
			'msisdn' => $msisdn,
			'code' => $code,
		];

		return (string) $this->user->isValidCode($data);
	}

	private function sendSms($data) {

		$message = 'Your code is:' . $data['code'] . ' to verify your MobiApp  account.';

		while (!$this->sendNotification->send($data['msisdn'], $message)) {
			$this->sendNotification->send($data['msisdn'], $message);
		}

		return true;
	}
}
