<?php
class SettingsController extends AppController
{
    /*
    view and change information of
    currently logged user
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
            
                try {
                    $logged_user = $user->update_user();
                    if ($logged_user)
                    {
                        addSession('logged_in',$logged_user);
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
    
    /*password change 
    
    */
    public function passwordChange ()
    {
        $user = new User();
        $page = Param::get('page_next', 'password_change');
        switch ($page) {

            case 'password_change':
                break;
            case 'info_ok':
                $user->user_username = get_session('logged_in','user_username');
                $user->user_new_password = Param::get('user_new_password');
                $user->user_confirm_password = Param::get('user_confirm_password');
                $user->user_password = Param::get('user_password');
                try {
                    if ( $user->password_change() )
                    {

                    }else{
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