<?php
class SessionController extends AppController
{

    /**
    * default page
    */
    public function index()
    {
        if(is_logged('logged_in') && get_session('logged_in','type')==NORMAL) {
            redirect(url('user/index'));
        } elseif (is_logged('logged_in') && get_session('logged_in','type')==ADMIN) {
            redirect(url('admin/index'));
        }
    }

    /**
    * handle login attempt
    */
    public function userLogin()
    {
        
        $user = new User();
        $user->username = Param::get('username');
        $user->password = Param::get('password');
        $logged_user = $user->validateLogin();
        
        if ($logged_user['type'] == NORMAL) {
            set_session('logged_in',$logged_user);
            redirect(url('user/index'));
        } elseif($logged_user['type'] == ADMIN) {
            set_session('logged_in',$logged_user);
            redirect(url('admin/index'));
        } else {
            flash_message('login_failed', 'Login credentials invalid!' ); 
            // redirect(url('/'));
        }   
    }

    /**
    * logout,remove/destroy session
    */
    public function logOut()
    {
        session_destroy();
        redirect(url('/'));
    }


    public function testing(){
        
    }
}