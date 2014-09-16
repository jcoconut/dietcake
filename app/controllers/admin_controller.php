<?php
class AdminController extends AppController
{
   
    public function index()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL){
            redirect(url('/'));
        }
        $klub = new Klub();
        $klubs = $klub->getKlubs();
        $this->set(get_defined_vars());    
    }

    public function addKlub()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL){
            redirect(url('/'));
        }
        $klub = new Klub();
        $page = Param::get('page_next', 'addklub');
        switch ($page) {

            case 'addklub':

                break;

            case 'klub_ok': 
                $klub->klub_name = Param::get('klub_name');
                $klub->klub_details = Param::get('klub_details');
                try {
    
                    $klub->addKlub();
                    flash_message('message', 'Klub has been Added!');
                    flash_message('positive_message', 1);
                    redirect('index');
                   
                } catch (ValidationException $e) {
                    $page = 'addklub';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);    
    }

    public function editKlub()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL){
            redirect(url('/'));
        }
        $klub = new Klub();
        $klub->klub_id = Param::get('klub_id');
        $selected_klub = $klub->getKlub();
        $page = Param::get('page_next', 'editklub');
        switch ($page) {

            case 'editklub':

                break;

            case 'klub_ok': 
                $klub->klub_name = Param::get('klub_name');
                $klub->klub_details = Param::get('klub_details');
                $klub->current_name = $selected_klub['klub_name'];
                try {
                    $klub->editKlub();
                    flash_message('message', 'Klub has been Edited!');
                    flash_message('positive_message', 1);
                    redirect('index');
                    
                   
                } catch (ValidationException $e) {
                    $page = 'editklub';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);    
    }

    public function deleteKlub()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL){
            redirect(url('/'));
        }
        $klub = new Klub();    
        $klub->klub_id = Param::get('klub_id');
        $deleted = $klub->deleteKlub();
        if($deleted){
            flash_message('message', 'Klub has been deleted!');
            flash_message('positive_message', 1);
        } else {
            flash_message('message', 'Klub to delete does not exist!');
        }
        redirect('index');
    }

    public function addUser()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL){
            redirect(url('/'));
        }
        $user = new user();
        $mailing = new Mailing();
        $page = Param::get('page_next', 'adduser');
        switch ($page) {
            case 'adduser':

                break;
            case 'user_ok': 
                $user->fname = Param::get('fname');
                $user->lname = Param::get('lname');
                $user->username = Param::get('username');
                $user->email = Param::get('part_email')."@klab.com";
                $user->type = Param::get('type',NORMAL);
                $user->password = rand_string(6);
                $mailing->email_ad = $user->email;
                $mailing->subject = "You have been Invited to Klabhouse!";
                $mailing->body = "Congratulations $user->fname $user->lname !
                    <p>sign in with this $user->username and password : $user->password </p>";
                try {
                    if(!$user->addUser()) {
                        $page = 'adduser';
                    } else {
                        $page = 'adduser';
                        $mailing->sendMail();
                        redirect(url(''));

                    }
                   
                } catch (ValidationException $e) {
                    $page = 'adduser';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);    
    }

    public function userList()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL){
            redirect(url('/'));
        }
        $user = new user();
        $users = $user->getUsers();
        $this->set(get_defined_vars());
    }

    public function deleteUser()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL){
            redirect(url('/'));
        }
        $user = new user();   
        $user->id = Param::get('id');
        $deleted = $user->deleteUser();
        if($deleted) {
            flash_message('message', 'User has been deleted!');
            flash_message('positive_message', 1);
        } else {
            flash_message('message', 'User to delete does not exist!');
        }
        redirect('userlist');
    }

    public function viewUserKlubs()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL){
            redirect(url('/'));
        }
        $user = new User();
        $member = new Member();
        $user->user_id = Param::get('id');
        $member->user_id = Param::get('id');
        $user_info = $user->getUser();
        $klubs = $member->getUserBoth();
        $this->set(get_defined_vars());
       
    }

    public function changeMemberLevel()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==NORMAL){
            redirect(url('/'));
        }
        $member = new Member();
        $member->id = Param::get('member_id');
        $member->user_id = Param::get('user_id');
        $member->level = Param::get('level');
        $member->updated = Param::get('updated', 0);
        $member->changeLevel();
        flash_message('message', 'Success!');
        flash_message('positive_message', 1);
        redirect(url('admin/viewuserklubs', array("id" => $member->user_id)));
    }
}