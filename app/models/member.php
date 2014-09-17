<?php
class Member extends AppModel
{
    /**
    * add member as level 0
    * @return true
    */
    public function addRequest()
    {
        $db = DB::conn();
        $params = array(
            "klub_id" => $this->klub_id,
            "user_id" => $this->user_id,
            "level" => REQUESTED,
        );
        $db->insert("member", $params);
        return true;
    }

    /**
    * get user requests
    * @return $requests
    */
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

    /**
    * get klub requests
    * @return $requests
    */
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

    /**
    * get user's memberships
    * @return $memberships
    */
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

    /**
    * get user's leaderships
    * @return $leaderships
    */
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

    /**
    * count members of a klub
    * @return $count
    */
    public function countMembers()
    {
        $db = DB::conn();
        $count = $db->row("SELECT COUNT(*) as count FROM member
            WHERE klub_id = ?", array($this->klub_id));
        return $count['count'];
    }

    /**
    * get members of klub
    * @param $records_per_page
    * @return $members
    */
    public function getKlubMembers($records_per_page)
    {
        $db = DB::conn();
        $start = ($this->page_num - 1) * $records_per_page ;
        $members = $db->rows("SELECT * from member
            LEFT JOIN user ON member.user_id=user.id
            WHERE klub_id = ? AND level != ?
            ORDER BY member.updated DESC
            LIMIT $start,$records_per_page", array($this->klub_id,REQUESTED));
        return $members;
    }

    /**
    * get member leader/member
    * @return $klubs
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
    * get user klubs id array
    * @return $klub_ids
    */
    public function getUserKlubs()
    {
        $klub_ids = array();
        $db = DB::conn();
        $klubs = $db->rows("SELECT member.klub_id from member
            WHERE user_id = ?", array($this->user_id));
        foreach ($klubs as $klub) {
            $klub_ids[] = $klub['klub_id'];
        }
        return $klub_ids;
    }

    /**
    * add member
    * @return boolean
    */
    public function acceptMember()
    {
        $db = DB::conn();             
        $params = array(
            "level" => 1,
            "updated" => date('Y-m-d H:i:s'));
        $where_params = array(
            "id" => $this->id
            );
        $db->update("member",$params,$where_params);
        return true;     
    }

    /**
    * change member level
    */
    public function changeLevel()
    {
        $db = DB::conn();
        if($this->updated) {
            $params = array(
                "level" => $this->level,
                "updated" => date('Y-m-d H:i:s')
            );
        } else {
            $params = array("level" => $this->level);
            
        }
        $where_params = array("id" => $this->id);
        $db->update("member",$params,$where_params);    
    }  

}