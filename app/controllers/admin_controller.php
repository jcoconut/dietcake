<?php
class AdminController extends AppController
{
    /**
    * admin home page
    */
    public function index()
    {
        redirect_not_admin();
        $klubs = Klub::getKlubs();
        $this->set(get_defined_vars());    
    }

    /**
    * add klub
    */
    public function addKlub()
    {
        redirect_not_admin();
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
                    flash_message('positive_message', true);
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

    /**
    * edit klub
    */
    public function editKlub()
    {
        redirect_not_admin();
        $klub = new Klub();
        $selected_klub = Klub::getKlub(Param::get('klub_id'));
        $page = Param::get('page_next', 'editklub');
        switch ($page) {

            case 'editklub':

                break;

            case 'klub_ok': 
                $klub->klub_id = Param::get('klub_id');
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

    /**
    * delete klub
    */
    public function deleteKlub()
    {
        redirect_not_admin();
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

    /**
    * add user
    */
    public function addUser()
    {
        redirect_not_admin();
        $user = new User();
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
                    $page = 'adduser';
                    if($user->addUser()) {
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

    /**
    * user list
    */
    public function userList()
    {
        redirect_not_admin();     
        $users = User::getUsers(ITEMS_PER_PAGE,Param::get('page_num', 1));

        $page = new Pagination();
        $page->total_rows = User::countUsers();
        $page->per_page = ITEMS_PER_PAGE;
        $paginate = $page->pageIt();

        $this->set(get_defined_vars());
    }

    /**
    * delete user
    */
    public function deleteUser()
    {
        redirect_not_admin();
        $user = new User();   
        $user->id = Param::get('id');
        $deleted = $user->deleteUser();
        if($deleted) {
            flash_message('message', 'User has been deleted!');
            flash_message('positive_message', true);
        } else {
            flash_message('message', 'User to delete does not exist!');
        }
        redirect('userlist');
    }

    /**
    * members list
    */
    public function memberList()
    {
        redirect_not_admin();       
        $klub_id = Param::get('id');
        $selected_klub = Klub::getKlub($klub_id);
        $members = Member::getKlubMembers(ITEMS_PER_PAGE, $klub_id, Param::get('page_num', 1));

        $page = new Pagination();
        $page->total_rows = Member::countMembers(Param::get('id'));
        $page->per_page = ITEMS_PER_PAGE;
        $page->extra_query = array("id=$klub_id");
        $paginate = $page->pageIt();
        $this->set(get_defined_vars());
    }

    /**
    * view a user's klubs
    */
    public function viewUserKlubs()
    {
        redirect_not_admin();
        $user_info = User::getUser(Param::get('id'));
        $klubs = Member::getUserBoth(Param::get('id'));
        $this->set(get_defined_vars());
       
    }

    /**
    * change member's level
    */
    public function changeMemberLevel()
    {
        redirect_not_admin();
        $member = new Member();
        $member->id = Param::get('member_id');
        $member->user_id = Param::get('user_id');
        $member->level = Param::get('level');
        $member->updated = Param::get('updated', 0);
        $member->changeLevel();
        flash_message('message', 'Success!');
        flash_message('positive_message', true);
        redirect(url('admin/viewuserklubs', array("id" => $member->user_id)));
    }
}