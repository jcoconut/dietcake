<?php
class SettingsController extends AppController
{
    /**
    * view/change user info
    */
    public function user_info()
    {
        if(!is_logged('logged_in')) {
            redirect(url('/'));
        }
        $user = new User();
        $page = Param::get('page_next', 'user_info');
        switch ($page) {

            case 'user_info':
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
                    $logged_user = $user->update();
                    if ($logged_user) {
                        set_session('logged_in',$logged_user);
                    } else {
                        $page = 'user_info';
                    }
                } catch (ValidationException $e) {
                    $page = 'user_info';
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
    public function password_change()
    {
        if(!is_logged('logged_in')) {
            redirect(url('/'));
        }
        $user = new User();
        $page = Param::get('page_next', 'password_change');
        switch ($page) {

            case 'password_change':
                break;
            case 'info_ok':
                $user->username = get_session('logged_in','username');
                $user->new_password = Param::get('new_password');
                $user->confirm_password = Param::get('confirm_password');
                $user->password = Param::get('password');
                $user->id = get_session('logged_in','id');
                try {
                    if (!$user->passwordChange()) {
                        $page = 'password_change';
                    }
                } catch (ValidationException $e) {
                    $page = 'password_change';
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