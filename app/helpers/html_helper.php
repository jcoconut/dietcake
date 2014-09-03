<?php

function redirect ($url) 
{
    header("Location: ".$url);
}

//echo htmlspecialchars also(security)
function echo_htmlschars ($string)
{
    if (!$string) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}
