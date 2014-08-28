<?php
function validate_between($check, $min, $max)
{
	$n = mb_strlen($check);
	return $min <= $n && $n <= $max;
}

function alpha_only($string){
	if(preg_match('/^[A-Za-z\s]+$/',$string)){
		return true;
	}else{
		return false;
	}
}

function is_same($string1,$string2){
	if($string1==$string2){
		return true;
	}else{
		return false;
	}
}
function is_email($email){

	//$email = \"somebody@somesite.com\"; // Valid email address 
	// Set up regular expression strings to evaluate the value of email variable against
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	// Run the preg_match() function on regex against the email address
	if (preg_match($regex, $email)) {
	   	return true;
	} else { 
	    return false;
	} 
}


?>