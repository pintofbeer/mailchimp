<?php

namespace pintofbeer\mailchimp;

class MailChimpBase{
	protected static $_key;
	protected static $_endpoint;
	
	protected static function setApiKey($api_key){
		self::$_key = $api_key;
		$parts = explode("-", $api_key);
		self::$_endpoint = sprintf("https://%s.api.mailchimp.com/3.0", end($parts));
	}
	
	protected static function call($path, $params = false, $method = 'GET'){
		$process = curl_init();
		$endpoint = self::$_endpoint."/".$path;
		if($method != 'POST' && !empty($params) && (is_array($params) || is_object($params))){
			curl_setopt($process, CURLOPT_URL, $endpoint.'?'.http_build_query($params));
		}else{
			curl_setopt($process, CURLOPT_URL, $endpoint);
		}
		curl_setopt($process, CURLOPT_USERPWD, uniqid("fmmm") . ":" . self::$_key);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		if($method == 'POST'){
			curl_setopt($process, CURLOPT_POST, 1);
			curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($params));
		}
		curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($process);
		curl_close($process);
		return json_decode($return);
	}
}

?>