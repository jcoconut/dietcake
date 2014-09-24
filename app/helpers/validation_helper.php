<?php
// checks if input is in between min or max characters
function is_between ($input, $min, $max)
{
    $n = mb_strlen($input);
    return $min <= $n && $n <= $max;
}

//checks if length = 0 (empty)
function required ($input)
{
    return mb_strlen($input)>0 ;
}

//checks for username,(no space)
function is_alpha_nonspaced ($string)
{
    return (preg_match('/^[A-Za-z]+$/',$string));
}

//checks if string is alpha only
function is_alpha ($string)
{
    return (preg_match('/^[A-Za-z\s]+$/',$string));
}

//checks if strings are same
function is_same ($string1,$string2)
{
    return $string1==$string2;
}

//checks if string is valid email
function is_email ($email)
{
    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
    return preg_match($regex, $email);
  
}

?>