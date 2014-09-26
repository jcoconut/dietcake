<?php
class AdminController extends AppController
{
    /**
    * admin home page
    */
    public function index()
    {
        redirect_not_admin();
        $klubs = Klub::getAll();
        $this->set(get_defined_vars());    
    }

    /**
    * add klub
    */
    public function add_klub()
    {
        redirect_not_admin();
        $klub = new Klub();
        $page = Param::get('page_next', 'add_klub');
        switch ($page) {

            case 'add_klub':

                break;

            case 'klub_ok': 
                $klub->klub_name = Param::get('klub_name');
                $klub->klub_details = Param::get('klub_details');
                try {
                    $klub->add();
                    flash_message('message', 'Klub has been Added!');
                    flash_message('positive_message', true);
                    redirect('index');
                   
                } catch (ValidationException $e) {
                    $page = 'add_klub';
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
    public function edit_klub()
    {
        redirect_not_admin();
        $klub = new Klub();
        $selected_klub = Klub::get(Param::get('klub_id'));
        $page = Param::get('page_next', 'edit_klub');
        switch ($page) {

            case 'edit_klub':

                break;

            case 'klub_ok': 
                $klub->klub_id = Param::get('klub_id');
                $klub->klub_name = Param::get('klub_name');
                $klub->klub_details = Param::get('klub_details');
                $klub->current_name = $selected_klub->klub_name;
                try {
                    $klub->edit();
                    flash_message('message', 'Klub has been Edited!');
                    flash_message('positive_message', 1);
                    redirect('index');   
                } catch (ValidationException $e) {
                    $page = 'edit_klub';
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
    public function delete_klub()
    {
        redirect_not_admin();
        $klub = Klub::get(Param::get('klub_id'));
        $deleted = $klub->delete();
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
    public function add_user()
    {
        redirect_not_admin();
        $user = new User();
        
        $page = Param::get('page_next', 'add_user');
        switch ($page) {
            case 'add_user':

                break;
            case 'user_ok': 
                $user->fname = Param::get('fname');
                $user->lname = Param::get('lname');
                $user->username = Param::get('username');
                $user->email = Param::get('part_email')."@klab.com";
                $user->type = Param::get('type',NORMAL);
                $user->password = rand_string(6);

                try {
                    $page = 'add_user';
                    if($user->add()) {
                        redirect(url(''));
                    }
                } catch (ValidationException $e) {
                    $page = 'add_user';
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
    public function user_list()
    {
        redirect_not_admin();     
        $users = User::getAll(ITEMS_PER_PAGE, Param::get('page_num', 1));

        $page = new Pagination();
        $page->total_rows = User::count();
        $page->per_page = ITEMS_PER_PAGE;
        $paginate = $page->pageIt();

        $this->set(get_defined_vars());
    }

    /**
    * delete user
    */
    public function delete_user()
    {
        redirect_not_admin();
        $user = new User();   
        $user->id = Param::get('id');
        $deleted = $user->delete();
        if($deleted) {
            flash_message('message', 'User has been deleted!');
            flash_message('positive_message', true);
        } else {
            flash_message('message', 'User to delete does not exist!');
        }
        redirect('user_list');
    }

    /**
    * members list
    */
    public function member_list()
    {
        redirect_not_admin();       
        $klub_id = Param::get('id');
        $selected_klub = Klub::get($klub_id);
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
    public function view_user_klubs()
    {
        redirect_not_admin();
        $user_info = User::get(Param::get('id'));
        $klubs = Member::getBoth(Param::get('id'));
        $this->set(get_defined_vars());
    }

    /**
    * change member's level
    */
    public function change_member_level()
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
        redirect(url('admin/view_user_klubs', array("id" => $member->user_id)));
    }
}