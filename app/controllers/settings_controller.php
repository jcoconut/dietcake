<?php
class SettingsController extends AppController
{
    /**
    * view/change user info
    */
    public function userInfo ()
    {
        if(!is_logged('logged_in')) {
            redirect(url('/'));
        }
        $menu = "settings";
        $user = new User();
        $page = Param::get('page_next', 'userinfo');
        switch ($page) {

            case 'userinfo':
                break;
            case 'info_ok':
            
                $user->fname = Param::get('fname');
                $user->lname = Param::get('lname');
                $user->id = get_session('logged_in', 'id');
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
        if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL){
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