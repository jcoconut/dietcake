<?php
class UserController extends AppController
{
    /**
    * user home page
    */
    public function index()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN) {
            redirect(url('/'));
        }
        $member = new Member();
        $member->user_id = get_session('logged_in','id');
        $member->klubs = $member->getUserLeaderships();
        $klubs = $member->getUserBoth(get_session('logged_in','id'));
        if(count($member->klubs) > 0) {
            $requests = $member->getKlubRequests();
        }
        $this->set(get_defined_vars());    
    }

    /**
    * klub list
    */
    public function klubs()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN) {
            redirect(url('/'));
        }
        $klub = new Klub();
        $klubs = $klub->getKlubs();

        $member = new Member();
        $member->user_id = get_session('logged_in', 'id');
        $memberships = $member->getUserMemberships();
        $leaderships = $member->getUserLeaderships();
        $requests = $member->getUserRequests();
        $this->set(get_defined_vars());    
   }

    /**
    * join the klub
    */
    public function join()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN) {
            redirect(url('/'));
        }
        $member = new Member();
        $member->klub_id = Param::get('klub_id');
        $member->klub_name = Param::get('klub_name');
        $member->user_id = get_session('logged_in','id');
        $requested = $member->addRequest();
        if($requested) {
            $message = "You requested to join $member->klub_name,<br>Please wait to be accepted";
            flash_message("message", $message);
            flash_message('positive_message', 1);
        }
        redirect('klubs');
    }

    /**
    * klub members
    */
    public function member_list()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN) {
            redirect(url('/'));
        }
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
    * view user's klubs
    */
    public function view_user_klubs()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN) {
            redirect(url('/'));
        }
        $user_info = User::getUser(Param::get('id'));
        $klubs = Member::getUserBoth(Param::get('id'));
        $this->set(get_defined_vars());
    }
    
    /**
    * accept request
    */
    public function accept_request()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN) {
            redirect(url('/'));
        }
        $member = new Member();
        $member->id = Param::get('id');
        $accepted = $member->acceptMember();
        redirect(url('user/index'));
    }
}