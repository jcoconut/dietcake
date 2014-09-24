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
            switch ($type) {
                case NORMAL:
                    redirect(url('user/index'));
                    break;
                case ADMIN:
                    redirect(url('admin/index'));
                    break;
            }
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
        $type = $logged_user['type']; 
        switch ($type) {
            case NORMAL:
                set_session('logged_in',$logged_user);
                redirect(url('user/index'));
                break;
            case ADMIN:
                set_session('logged_in',$logged_user);
                redirect(url('admin/index'));
                break;
            default:
                flash_message('login_failed', 'Login credentials invalid!' ); 
                redirect(url('/'));
                break;
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

}