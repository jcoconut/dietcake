<?php
class Member extends AppModel
{
    const REQUESTED = 0;
    const MEMBER = 1;
    const LEADER = 2;
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
            "level" => self::REQUESTED,
        );
        $db->insert("member", $params);
    }

    /**
    * get user requests
    * @return $requests
    */
    public function getUserRequests()
    {
        $db = DB::conn();
        $rows = $db->rows("SELECT * from member
            WHERE user_id = ? AND level = ?", array($this->user_id,self::REQUESTED));
        $requests = array();
        foreach ($rows as $row) {
            $requests[] = new self($row);
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
            member.klub_id IN ($klubs)", array(self::REQUESTED));
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
            WHERE user_id = ? AND level = ?", array($this->user_id,self::MEMBER));
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
            WHERE user_id = ? AND level = ?", array($this->user_id,self::LEADER));
        foreach ($rows as $leadership) {
            $leaderships[] = $leadership['klub_id'];
        }
        return $leaderships;
    }

    /**
    * count members of a klub
    * @return $count
    */
    public static function countMembers($klub_id)
    {
        $db = DB::conn();
        return (int) $db->value('SELECT COUNT(*) FROM member WHERE klub_id = ?', array($klub_id));
    }

    /**
    * get members of klub
    * @param $records_per_page
    * @return $members
    */
    public static function getKlubMembers($records_per_page, $klub_id, $page_num)
    {
        $db = DB::conn();
        $start = ($page_num - 1) * $records_per_page ;
        $rows = $db->rows("SELECT * from member
            LEFT JOIN user ON member.user_id=user.id
            WHERE klub_id = ? AND level != ?
            ORDER BY member.updated DESC
            LIMIT $start,$records_per_page", array($klub_id,self::REQUESTED));
        $members = array();
        foreach ($rows as $row) {
            $members[] = new self($row);
        }
        return $members;
    }

    /**
    * get member leader/member
    * @return $klubs
    */
    public static function getBoth($user_id)
    {
        $db = DB::conn();
        $rows = $db->rows("SELECT * from member
            LEFT JOIN klub ON member.klub_id=klub.klub_id
            WHERE user_id = ?", array($user_id));
        $klubs = array();
        foreach ($rows as $row) {
            $klubs[] = new self($row);
        }
        return $klubs;
    }

    /**
    * get user klubs id array
    * @return $klub_ids
    */
    public function getUserKlubIds()
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
            "updated" => date('Y-m-d H:i:s')
        );
        $where_params = array(
            "id" => $this->id
        );
        $db->update("member", $params, $where_params);     
    }

    /**
    * change member level
    */
    public function changeLevel()
    {      
        $db = DB::conn();
        $params = array('level' => $this->level);
        if ($this->updated) {
            $params['updated'] = date('Y-m-d H:i:s');
        }
        $where_params = array("id" => $this->id);
        $db->update("member", $params, $where_params);    
    }  
}