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

    if($diff['y'] > 1) {
        $string = "{$diff['y']} years";
    } else if($diff['y'] > 0) {
        $string = "{$diff['y']} year"; 
    } else {

        if($diff['m'] > 1) {
            $string = "{$diff['m']} months";
        } else if($diff['m'] > 0) {
            $string = "{$diff['m']} month"; 
        } else {

            if($diff['h'] > 1) {
                $string = "{$diff['h']} hours";
            } else if($diff['h'] > 0) {
                $string = "{$diff['h']} hour"; 
            } else {

                if($diff['i'] > 1) {
                    $string = "{$diff['i']} minutes";
                } else if($diff['i'] > 0) {
                    $string = "{$diff['i']} minute"; 
                } else {

                    $string = "a few moments"; 
                    
                }

               
            }
            
        }

        
    }

    return $string;
}