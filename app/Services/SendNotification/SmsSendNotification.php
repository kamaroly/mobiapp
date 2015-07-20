<?php namespace App\Services\SendNotification;
use GuzzleHttp\Client;

/**
 * SendSms notification
 */
class SmsSendNotification {

	public $url = 'http://121.241.242.114:8080/bulksms/bulksms?username=skyt-huguka&password=Kigali7&type=0&dlr=Z&destination=@destination&source=MobiApp&message=@message';
	public function send($to, $message) {

		// Add message and  destinataion
		$this->url = str_replace('@message', $message, $this->url);
		$this->url = str_replace('@destination', $to, $this->url);

		$res = (new Client)->get($this->url);

		$response = $res->getBody();

		if (substr($response, 0, 4) === '1701') {
			// message has be delivered
			return true;
		}

		return false;

	}

	function sendRequest($Url) {

		// is cURL installed yet?
		if (!function_exists('curl_init')) {
			die('Sorry cURL is not installed!');
		}

		// OK cool - then let's create a new cURL resource handle
		$ch = curl_init();

		// Now set some options (most are optional)

		// Set URL to download
		curl_setopt($ch, CURLOPT_URL, $Url);

		// User agent
		curl_setopt($ch, CURLOPT_USERAGENT, "TigoApp/1.0");

		// Include header in result? (0 = yes, 1 = no)
		curl_setopt($ch, CURLOPT_HEADER, 0);

		// Should cURL return or print out the data? (true = return, false = print)
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Timeout in seconds
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		// Download the given URL, and return output
		$output = curl_exec($ch);

		// Close the cURL resource, and free system resources
		curl_close($ch);

		return $output;
	}
}