<?php
function set_session($sess_name,$sess_var)
{
    return $_SESSION[$sess_name] = $sess_var;
}

function is_logged($sess_name)
{
    return isset($_SESSION[$sess_name]);
}

function get_session($sess_name , $sess_var)
{
    if(is_logged($sess_name)){
        return $_SESSION[$sess_name][$sess_var];   
    }
    
}

function redirect_not_admin(){
    if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL) {
        redirect(url('/'));
    }
}

function redirect_if_admin(){
    if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN) {
        redirect(url('/'));
    }
}

function flash_message($name = '', $message = '', $class = 'alert', $tag = 'p')
{
    if( !empty( $name ) ) {
       
        if( !empty( $message ) && empty( $_SESSION[$name] ) ) {
            if( !empty( $_SESSION[$name] ) ) {
                unset( $_SESSION[$name] );
            }
            if( !empty( $_SESSION[$name.'_class'] ) ) {
                unset( $_SESSION[$name.'_class'] );
            }
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        } elseif( !empty( $_SESSION[$name] ) && empty( $message ) ) {
            $class = !empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
            echo '<'.$tag.' class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</'.$tag.'>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}
?>