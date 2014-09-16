<?php
class UserController extends AppController
{
   
    public function index(){
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
            redirect(url('/'));
        }
        $member = new Member();
        $member->user_id = get_session('logged_in','id');
        $member->klubs = $member->getUserLeaderships();
        // print_r("<pre>");
        // print_r($member->klubs);
        // print_r("</pre>");

        if(count($member->klubs) > 0){
            $requests = $member->getKlubRequests();
            // print_r("<pre>");
            // print_r($requests);
            // print_r("</pre>");
        }
        
      
        $this->set(get_defined_vars());    
    }

    public function klubs(){
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
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

    public function join(){
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
            redirect(url('/'));
        }
        $member = new Member();
        $member->klub_id = Param::get('klub_id');
        $member->klub_name = Param::get('klub_name');
        $member->user_id = get_session('logged_in','id');
        $requested = $member->addRequest();
        if($requested) {
            $message = "You requested to join $member->klub_name,<br>please wait to be accepted";
            flash_message("message", $message);
            flash_message('positive_message', 1);
        }
        redirect('klubs');
    }
    public function memberList()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
            redirect(url('/'));
        }
        $member = new member();
        $member->id = Param::get('id');
        $members = $member->getKlubMembers();
        $this->set(get_defined_vars());
    }

    public function viewUserKlubs()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
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
    // public function deleteUser()
    // {
    //     if(!is_logged('logged_in')){
    //         redirect(url('/'));
    //     }
    //     $user = new user();   
    //     $user->id = Param::get('id');
    //     $deleted = $user->deleteUser();
    //     if($deleted) {
    //         flash_message('message', 'User has been deleted!');
    //         flash_message('positive_message', 1);
    //     } else {
    //         flash_message('message', 'User to delete does not exist!');
    //     }
    //     redirect('userlist');
    // }
    // public function userList()
    // {
    //     if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
    //         redirect(url('/'));
    //     }

    // }
    public function acceptRequest()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
            redirect(url('/'));
        }
        $member = new Member();
        $member->id = Param::get('id');
        $accepted = $member->acceptMember();
        redirect(url('user/index'));
    }
}