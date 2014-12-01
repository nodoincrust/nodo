<?php
	
 require_once('recaptcha-php/recaptchalib.php');
	  $privatekey = "6LfQePcSAAAAAI9evS3NS2anXvMAZJRkDvkj5RIz";
	  $resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);

	$msg = '';	
	if (!$resp->is_valid) {
		$msg = "fail";
		echo $msg;
		//return false;
	}
	else{
		$msg = "success";
		echo $msg;
		//return true;
	}
		
	
	
?>