<?php

function redirect($url) 
{
    header("Location: ".$url);
}

//safe outout
function safe_output($string)
{
    if (!$string) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

function rand_string( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);
}

function time_difference($date1, $date2)
{
    $date1 = date_create($date1);
    $date2 = date_create($date2);
    $diff = (array)date_diff($date1 , $date2 ) ; 
    $string = "a few moments"; 

    if($diff['y'] > 1) {
        $string = "{$diff['y']} years";
        return $string;
    } else if($diff['y'] > 0) {
        $string = "{$diff['y']} year"; 
        return $string;
    }

    if($diff['m'] > 1) {
        $string = "{$diff['m']} months";
        return $string;
    } else if($diff['m'] > 0) {
        $string = "{$diff['m']} month"; 
        return $string;
    } 
  
    if($diff['d'] > 1) {
        $string = "{$diff['d']} days";
        return $string;
    } else if($diff['d'] > 0) {
        $string = "{$diff['d']} day"; 
        return $string;
    }

    if($diff['h'] > 1) {
        $string = "{$diff['h']} hours";
        return $string;
    } else if($diff['h'] > 0) {
        $string = "{$diff['h']} hour"; 
        return $string;
    }

    if($diff['i'] > 1) {
        $string = "{$diff['i']} minutes";
        return $string;
    } else if($diff['i'] > 0) {
        $string = "{$diff['i']} minute"; 
        return $string;
    }
    return $string;
}