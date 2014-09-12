<?php
class SettingsController extends AppController
{
    /**
    * view/change user info
    */
    public function userInfo ()
    {
        $user = new User();
        $page = Param::get('page_next', 'userinfo');
        switch ($page) {

            case 'userinfo':
                break;
            case 'info_ok':
            
                $user->user_fname = Param::get('user_fname');
                $user->user_lname = Param::get('user_lname');
                $user->user_username = Param::get('user_username');
                $user->user_email = Param::get('user_email');
                $user->user_id = get_session('logged_in', 'user_id');
                $user->current_username = get_session('logged_in', 'user_username');
                $user->current_email = get_session('logged_in', 'user_email');
                try {
                    $logged_user = $user->updateUser();
                    if ($logged_user)
                    {
                        print_r($logged_user);
                        add_session('logged_in',$logged_user);
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
    public function passwordChange ()
    {
        $user = new User();
        $page = Param::get('page_next', 'passwordchange');
        switch ($page) {

            case 'passwordchange':
                break;
            case 'info_ok':
                $user->user_username = get_session('logged_in','user_username');
                $user->user_new_password = Param::get('user_new_password');
                $user->user_confirm_password = Param::get('user_confirm_password');
                $user->user_password = Param::get('user_password');
                $user->user_id = get_session('logged_in','user_id');
                try {
                    if ( $user->passwordChange() )
                    {

                    }else{
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