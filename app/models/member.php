<?php
class Member extends AppModel
{
    
    public function addRequest(){
        $db = DB::conn();
        $params = array(
            "klub_id" => $this->klub_id,
            "user_id" => $this->user_id,
            "level" => 0,
        );
        $db->insert("member", $params);
        return true;
    }

    public function getUserRequests()
    {
        $requests = "";
        $db = DB::conn();
        $rows = $db->rows("SELECT * from member
            WHERE user_id = ? AND level = ?", array($this->user_id,REQUESTED));
        foreach($rows as $request){
            $requests[] = $request['klub_id'];
        }
        return $requests;
    }

    public function getKlubRequests()
    {
        $columns = "member.id,klub.klub_name,member.user_id,member.klub_id,user.fname,member.created";
        $db = DB::conn();
        $klubs = implode(", ", $this->klubs); 
        $requests = $db->rows("SELECT $columns from member
            LEFT JOIN user ON member.user_id=user.id
            LEFT JOIN klub ON member.klub_id=klub.klub_id
            WHERE level = ? AND
            member.klub_id IN ($klubs)", array(REQUESTED));
        return $requests;
    }

    public function getUserMemberships()
    {
        $memberships = array();
        $db = DB::conn();
        $rows = $db->rows("SELECT klub_id from member
            WHERE user_id = ? AND level = ?", array($this->user_id,MEMBER));
        foreach ($rows as $membership) {
            $memberships[] = $membership['klub_id'];
        }
        return $memberships;
    }

    public function getUserLeaderships()
    {
        $leaderships = array();
        $db = DB::conn();
        $rows = $db->rows("SELECT klub_id from member
            WHERE user_id = ? AND level = ?", array($this->user_id,LEADER));
        foreach ($rows as $leadership) {
            $leaderships[] = $leadership['klub_id'];
        }
        return $leaderships;
    }
    public function getKlubMembers()
    {
        $db = DB::conn();
        $members = $db->rows("SELECT * from member
            LEFT JOIN user ON member.user_id=user.id
            WHERE klub_id = ? AND level != ?", array($this->id,REQUESTED));
        return $members;
    }
    /**
    * get member leader/member
    */
    public function getUserBoth()
    {
        $db = DB::conn();
        $klubs = $db->rows("SELECT * from member
            LEFT JOIN klub ON member.klub_id=klub.klub_id
            WHERE user_id = ?", array($this->user_id));
        return $klubs;
    }
    /**
    * add member
    * @return boolean
    */
    public function acceptMember()
    {
        $db = DB::conn();             
        $params = array("level" => 1);
        $where_params = array(
            "id" => $this->id,
            "updated" => date('Y-m-d H:i:s')
            );
        $db->update("member",$params,$where_params);
        return true;     
    }

    public function changeLevel()
    {
        $db = DB::conn();
        if($this->updated){
            $params = array(
                "level" => $this->level,
                "updated" => date('Y-m-d H:i:s')
                );
        }else{
            $params = array("level" => $this->level);
            
        }
        
        $where_params = array("id" => $this->id);
        $db->update("member",$params,$where_params);    
    }















    /**
    * delete member
    */
    public function deleteKlub ()
    {
       
        $db = DB::conn();
        $db->query("DELETE FROM klub WHERE klub_id = ?", array($this->klub_id));
        $deleted = $db->rowCount();
        return $deleted;

    }
  
    

}