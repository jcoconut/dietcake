<?php
class SessionController extends AppController
{
    const NORMAL = 0;
    const ADMIN = 1;
    public function userLogin()
    {
        
        $user = new User();
        $user->username = Param::get('username');
        $user->password = Param::get('password');
        $logged_user = $user->validateLogin();
        
        if ($logged_user['type'] == self::NORMAL) {
            set_session('logged_in',$logged_user);
            redirect(url('thread/threads'));
        } elseif($logged_user['type'] == self::ADMIN) {
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

    // /**
    // * register user
    // */
    // public function registerUser()
    // {
    //     $user = new User();
    //     $page = Param::get('page_next', 'registeruser');
    //     switch ($page) {

    //         case 'registeruser':

    //             break;

    //         case 'register_ok': 
    //             $user->fname = Param::get('fname');
    //             $user->lname = Param::get('lname');
    //             $user->username = Param::get('username');
    //             $user->email = Param::get('email');
    //             $user->password = Param::get('password');
    //             $user->confirm_password = Param::get('confirm_password');
    //             try {
    //                 if(!$user->register()){
    //                     $page = 'registeruser';
    //                 }
                   
    //             } catch (ValidationException $e) {
    //                 $page = 'registeruser';
    //             }
    //             break;
    //         default:
    //             throw new NotFoundException("{$page} is not found");
    //             break;
    //     }
    //     $this->set(get_defined_vars());
    //     $this->render($page);
    // }

    public function index()
    {
        if(is_logged('logged_in') && get_session('logged_in','type')==self::NORMAL) {
            redirect(url('thread/index'));
        } elseif (is_logged('logged_in') && get_session('logged_in','type')==self::ADMIN) {
            redirect(url('admin/index'));
        }
    }

    public function testing(){
        
    }
}