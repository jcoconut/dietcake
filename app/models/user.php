<?php
class User extends AppModel
{
    const MIN_CHAR = 1;
    const MAX_CHAR = 30;
    
    public $is_password_match = true;
    public $is_password_match = true;
    public $is_already_registered = false;
    public $is_email_taken = false;
    public $is_username_taken = false;

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

        'email' => array(
            'format' => array(
                'is_email'
            ),
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'username' => array(
            'format' => array(
                'is_alpha_nonspaced'
            ),
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'password' => array(
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),
       'new_password' => array(
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),
    );
    
    /**
    * insert user
    * @return boolean
    */
    public function add()
    {
         
        if (!$this->validate()) {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();         
        if($this->checkEmailExist()) {
            $this->is_email_taken = true;
        }
        if($this->checkUsernameExist()) {
            $this->is_username_taken = true;
        }
        if($this->is_email_taken || $this->is_username_taken) {
            return false;
        } else {     
            $params = array(
                "fname" => $this->fname,
                "lname" => $this->lname,
                "email" => $this->email,
                "username" => $this->username,
                "type" => $this->type,
                "password" => md5(sha1($this->password))
            );
            $db->insert("user", $params);
            $db->commit();
            return true;
        } 
        
    }

    /**
    * check email exist
    * @return $found
    */
    public function checkEmailExist()
    {
        $db = DB::conn();
        $found = $db->row("SELECT * FROM user
            WHERE email = ? " , array($this->email));
        return $found;
    }

    /**
    * check username exist
    * @return $found
    */
    public function checkUsernameExist()
    {
        $db = DB::conn();
        $found = $db->row("SELECT * FROM user
            WHERE username = ? " , array($this->username));
        return $found;
    }

    /**
    * update user info
    */
    public function update()
    {
        $this->validate();
        if ($this->hasError()) {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();
        if(!is_same($this->current_email, $this->email)) {
            if($this->checkEmailExist()) {
                $this->is_email_taken = true;
            }
        }
        if(!is_same($this->current_username, $this->username)) {
        
            if($this->checkUsernameExist()) {
                $this->is_username_taken = true;
            }
        }
        if($this->is_email_taken ||  $this->is_username_taken) {
           return false;
        }
        $params = array(
            "fname" => $this->fname,
            "lname" => $this->lname,
            "email" => $this->email,
            "username" => $this->username,
            "updated" => date('Y-m-d H:i:s')
            );
        $where_params = array("id" => $this->id);
        $db->update("user",$params,$where_params);
        $logged_user = $db->row("SELECT * FROM user
            WHERE id = ? " , array( $this->id ));
        $db->commit();
        return $logged_user;
        
    }

    /**
    * change user password
    */
    public function passwordChange()
    {
        $this->is_password_match = is_same($this->new_password,$this->confirm_password);
        if (!$this->validate() || ($this->is_password_match==false)) {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();
        $loguser = $db->row('SELECT * FROM user
            WHERE username = ? AND password = ?' ,
            array($this->username,md5(sha1($this->password))));
        if($loguser) {
            $db->query("UPDATE user
            SET password = ? WHERE username = ? " ,
            array(md5(sha1($this->new_password)) , $this->username) );
            $db->commit();
            return true;
        } else {
            $this->is_password_match = false;
        }
    }

    /**
    * login validate in db
    * @return $loguser
    */
    public function validateLogin()
    {
        $db = DB::conn();
        $loguser = $db->row('SELECT * FROM user
            WHERE username = ? AND password = ?' ,
            array($this->username, md5(sha1($this->password))));
        if($loguser) {
            return $loguser;    
        }
        
    }

    /**
    * count all users
    * @return int
    */
    public static function count()
    {
        $db = DB::conn();
        return (int) $db->value("SELECT COUNT(*) FROM user");
    }

    /**
    * get all users
    * @return $users
    */
    public static function getAll($records_per_page, $page_num)
    {
        $db = DB::conn();
        $start = ($page_num - 1) * $records_per_page ;
        $rows = $db->rows("SELECT * FROM user ORDER BY created
            DESC LIMIT $start,$records_per_page");
        $users = array();
        foreach ($rows as $row) {
            $users[] = new self($row);
        }
        return $users;
    }
    
    /**
    * get one user
    * @return $user
    */
    public static function get($user_id)
    {
        $db = DB::conn();
        $user = $db->row("SELECT fname,lname FROM user WHERE id = ?", array($user_id));
        return new self($user);
    }

    /**
    * delete user
    * @return $deleted
    */
    public function delete()
    {  
        $db = DB::conn();
        $db->query("DELETE FROM user WHERE id = ?", array($this->id));
        return $db->rowCount();
    }

}