<?php

function redirect ($url) 
{
    header("Location: ".$url);
}

//safe outout
function safe_output ($string)
{
    if (!$string) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}
