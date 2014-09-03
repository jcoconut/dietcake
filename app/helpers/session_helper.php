<?php
function addSession ($sess_name,$sess_var)
{
    return $_SESSION[$sess_name] = $sess_var;
}

function checkSession ($sess_name){
    if(isset($_SESSION[$sess_name])){
        return true;
    }else{
        return false;
    }
}

function get_session ($sess_name , $sess_var)
{
    if(checkSession($sess_name)){
        return $_SESSION[$sess_name][$sess_var];   
    }
    
}

function flashMessage ( $name = '', $message = '', $class = 'alert', $tag = 'p' )
{
    //We can only do something if the name isn't empty
    if( !empty( $name ) )
    {
        //No message, create it
        if( !empty( $message ) && empty( $_SESSION[$name] ) )
        {
            if( !empty( $_SESSION[$name] ) )
            {
                unset( $_SESSION[$name] );
            }
            if( !empty( $_SESSION[$name.'_class'] ) )
            {
                unset( $_SESSION[$name.'_class'] );
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        }
        //Message exists, display it
        elseif( !empty( $_SESSION[$name] ) && empty( $message ) )
        {
            $class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
            echo '<'.$tag.' class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</'.$tag.'>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}
?>