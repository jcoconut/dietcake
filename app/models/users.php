<?php
class Users extends AppModel
{
    const MIN_CHAR = 1;
    const MAX_CHAR = 30;
    public $already_registered = false;

    public $validation = array(
        'fname' => array(
            'format' => array(
                'is_alpha'
            ),
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'lname' => array(
            'format' => array(
                'is_alpha'
            ),
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

    );
    
    /**
    * insert user
    * @return boolean
    */
    public function addUser()
    {
        $db = DB::conn();
        $params = array(
            "id" => $this->user_id,
            "fname" => $this->fname,
            "lname" => $this->lname,
            "email" => $this->email,
            "type" => 0,
            "image" => $this->image
        );
        $db->insert("users", $params);

        return true;
        
        
    }

    public function updateImage()
    {
        $db = DB::conn();
        $params = array(
            "image" => $this->image
        );
        $where_params = array("id" => $this->id);
        $db->update("users",$params,$where_params);
        $updated = $db->rowCount();
        return $updated;
    }

    /**
    * update user info
    */
    public function updateUser()
    {
        $this->validate();
        if ($this->hasError()) {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();
        $params = array(
            "fname" => $this->fname,
            "lname" => $this->lname,
            "updated" => date('Y-m-d H:i:s')
            );
        $where_params = array("id" => $this->id);
        $db->update("users",$params,$where_params);
        $logged_user = $db->row("SELECT * FROM users
            WHERE id = ? " , array( $this->id ));
        $db->commit();
        return $logged_user;
        
    }

    /**
    * count all users
    * @return int
    */
    public static function countUsers()
    {
        $db = DB::conn();
        return (int) $db->value("SELECT COUNT(*) FROM users");
    }

    /**
    * get all users
    * @return $users
    */
    public function getUsers($records_per_page){
        $db = DB::conn();
        $start = ($this->page_num - 1) * $records_per_page ;
        $users = $db->rows("SELECT * FROM users ORDER BY created
            DESC LIMIT $start,$records_per_page");
        return $users;
    }
    
    /**
    * get one user
    * @return $user
    */
    public function getUser(){
        $db = DB::conn();
        $user = $db->row("SELECT id,fname,lname,image,type FROM users where id = ? ", array($this->user_id));
        return $user;
    }
    /**
    * delete user
    * @return $deleted
    */
    public function deleteUser ()
    {  
        $db = DB::conn();
        $db->query("DELETE FROM users WHERE id = ?", array($this->id));
        $deleted = $db->rowCount();
        return $deleted;
    }

}