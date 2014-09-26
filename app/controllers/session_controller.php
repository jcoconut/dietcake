<?php
class SessionController extends AppController
{

    /**
    * default page
    */
    public function index()
    {
        if (is_logged('logged_in')) {
            $type = get_session('logged_in','type');
            if($type == ADMIN) {
                redirect(url('admin/index'));  
            } else {
                redirect(url('user/index')); 
            }
        }
    }

    /**
    * handle login attempt
    */
    public function user_login()
    {
        
        $user = new User();
        $user->username = Param::get('username');
        $user->password = Param::get('password');
        $logged_user = $user->validateLogin();
        $type = $logged_user['type']; 
        switch ($type) {
            case NORMAL:
                set_session('logged_in',$logged_user);
                redirect(url('user/index'));
            case ADMIN:
                set_session('logged_in',$logged_user);
                redirect(url('admin/index'));
            default:
                flash_message('login_failed', 'Login credentials invalid!' ); 
                redirect(url('/'));
        }
    }

    /**
    * logout,remove/destroy session
    */
    public function log_out()
    {
        session_destroy();
        redirect(url('/'));
    }

}