<?php
class AskFM {
	public $username;
	public $password;
	
	function getLoginPage() {
		$c = curl_init();
		curl_setopt_array($c, array(
		CURLOPT_URL => "http://ask.fm/session/new",
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => true
		));
		$response = curl_exec($c);
		curl_close($c);
		preg_match_all("/^Set-Cookie:\s*([^;]*)/mi", $response, $cookies);
		$cookie=join(";", $cookies[1]);
		return array($response, $cookie);
	}
	
	function getAuthenticityToken($source)
	{
		preg_match("/name=\"authenticity_token\" type=\"hidden\" value=\"(.*?)\"/", $source, $result);
		return $result[1];
	}
	
	function postLogin($authenticity_token, $cookie)
	{
		$post = "authenticity_token=".rawurlencode($authenticity_token)."&login=".$this->username."&password=".$this->password."&commit=Masuk";
		$c = curl_init();
		curl_setopt_array($c, array(
		CURLOPT_URL => "http://ask.fm/session",
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $post,
		CURLOPT_COOKIE => $cookie
		));
		$response = curl_exec($c);
		curl_close($c);
		preg_match_all("/^Set-Cookie:\s*([^;]*)/mi", $response, $cookies);
		$cookie=join(";", $cookies[1]);
		return $cookie;
	}
	
	function postLike($authenticity_token, $cookie, $username, $id)
	{
		$post = "authenticity_token=".$authenticity_token;
		$c = curl_init();
		curl_setopt_array($c, array(
		CURLOPT_URL => "http://ask.fm/likes/".username."/question/".$id."/add",
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $post,
		CURLOPT_COOKIE => $cookie
		));
		$result = curl_exec($c);
		curl_close($c);
		return $result;
	}
}