<?php
class SessionController extends AppController
{
    public function index(){
        $client = new apiClient();
        $client->setClientId(CLIENT_ID);
        $client->setClientSecret(CLIENT_SECRET);
        $client->setDeveloperKey(API_KEY);
        $client->setRedirectUri(REDIRECT_URI);
        $client->setApprovalPrompt(false);
        $oauth2 = new apiOauth2Service($client);
        $this->set(get_defined_vars());    
    }


    public function googleLogin()
    {
        $client = new apiClient();
        $client->setClientId(CLIENT_ID);
        $client->setClientSecret(CLIENT_SECRET);
        $client->setDeveloperKey(API_KEY);
        $client->setRedirectUri(REDIRECT_URI);
        $client->setApprovalPrompt(false);
        $oauth2 = new apiOauth2Service($client);
        $code = Param::get('code');
        if (isset($code)) {
            $client->authenticate();

            $info = $oauth2->userinfo->get();
            if(isset($info['hd']) and $info['hd']=="klab.com") {
                $user = new Users;
                $user->user_id = $info['id'];
                $user->image = $info['picture'];
                
                if(!$user->getUser()) {
                    $user->fname = str_replace("(Cyscorpions)","",$info['given_name']);
                    $user->lname = $info['family_name'];
                    $user->email = $info['email'];    
                    $user->addUser();
                }
                $logged_user = $user->getUser();
                set_session('logged_in',$logged_user);
                redirect(url('user/index'));

            } else {
                flash_message('message', 'Please use klab email only!');
                echo "sorry, use klab mail..ONLY!!!!";

            }
            
            exit();
        }
    }


    /**
    * default page
    */
    public function adminLogin()
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

}