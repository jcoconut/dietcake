<?php
class UserController extends AppController
{
    const NORMAL = 0;
    const ADMIN = 1;
    public function userLogin()
    {
        $user = new User();
        $user->user_username = Param::get('user_username');
        $user->user_password = Param::get('user_password');
        $logged_user = $user->validateLogin();
        
        if ($logged_user['user_type'] == self::NORMAL) {
            set_session('logged_in',$logged_user);
            redirect(url('thread/index'));
        } elseif($logged_user['user_type'] == self::ADMIN) {
            set_session('logged_in',$logged_user);
            redirect(url('admin/index'));
        } else {
            flash_message('login_failed', 'Login credentials invalid!' ); 
            redirect(url('/'));
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

    /**
    * register user
    */
    public function registerUser()
    {
        $user = new User();
        $page = Param::get('page_next', 'registeruser');
        switch ($page) {

            case 'registeruser':

                break;

            case 'register_ok': 
                $user->user_fname = Param::get('user_fname');
                $user->user_lname = Param::get('user_lname');
                $user->user_username = Param::get('user_username');
                $user->user_email = Param::get('user_email');
                $user->user_password = Param::get('user_password');
                $user->user_confirm_password = Param::get('user_confirm_password');
                try {
                    if(!$user->register()){
                        $page = 'registeruser';
                    }
                   
                } catch (ValidationException $e) {
                    $page = 'registeruser';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function index(){
        
    }
}