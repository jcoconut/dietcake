<?php
function validate_between($check, $min, $max)
{
	$n = mb_strlen($check);
	return $min <= $n && $n <= $max;
}
function alpha_only($string){
	if(preg_match('/[^\da-zA-Z]/',$string)){
		return false;
	}else{
		return true;
	}
}
function is_same($string1,$string2){
	if($string1===$string2){
		return true;
	}else{
		return false;
	}
}
?>