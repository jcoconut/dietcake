<?php
class SettingsController extends AppController
{
    /**
    * view/change user info
    */
    public function userInfo()
    {
        if(!is_logged('logged_in')) {
            redirect(url('/'));
        }
        $user = new User();
        $page = Param::get('page_next', 'userinfo');
        switch ($page) {

            case 'userinfo':
                break;
            case 'info_ok':
            
                $user->fname = Param::get('fname');
                $user->lname = Param::get('lname');
                $user->username = Param::get('username');
                $user->email = Param::get('email');
                $user->id = get_session('logged_in', 'id');
                $user->current_username = get_session('logged_in', 'username');
                $user->current_email = get_session('logged_in', 'email');
                try {
                    $logged_user = $user->updateUser();
                    if ($logged_user) {
                        set_session('logged_in',$logged_user);
                    } else {
                        $page = 'userinfo';
                    }
                } catch (ValidationException $e) {
                    $page = 'userinfo';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        
        $this->set(get_defined_vars());
        $this->render($page);
    }
    
    /**
    * Password change 
    */
    public function passwordChange()
    {
        if(!is_logged('logged_in')) {
            redirect(url('/'));
        }
        $user = new User();
        $page = Param::get('page_next', 'passwordchange');
        switch ($page) {

            case 'passwordchange':
                break;
            case 'info_ok':
                $user->username = get_session('logged_in','username');
                $user->new_password = Param::get('new_password');
                $user->confirm_password = Param::get('confirm_password');
                $user->password = Param::get('password');
                $user->id = get_session('logged_in','id');
                try {
                    if ($user->passwordChange()) {

                    } else {
                        $page = 'passwordchange';
                    }
                } catch (ValidationException $e) {
                    $page = 'passwordchange';
                }

                break;  
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }
}