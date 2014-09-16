<?php
class User extends AppModel
{
    const MIN_CHAR = 1;
    const MAX_CHAR = 30;
    
    public $password_match = true;
    public $password_correct = true;
    public $already_registered = false;
    public $email_taken = false;
    public $username_taken = false;

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
                'is_alpha'
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
    public function register()
    {
       
        $this->password_match = is_same($this->password,$this->confirm_password);
        if (!$this->validate() || ($this->password_match==false)) {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();         
        if($this->checkEmailExist()) {
            $this->email_taken = true;
        }
        if($this->checkUsernameExist()) {
            $this->username_taken = true;
        }
        if($this->email_taken ||  $this->username_taken) {
            return false;
        } else {     
            $params = array(
                "fname" => $this->fname,
                "lname" => $this->lname,
                "email" => $this->email,
                "username" => $this->username,
                "password" => md5(sha1($this->password))
            );
            $db->insert("user", $params);
            $this->id = $db->lastInsertId();
            $db->commit();
            return true;
        } 
        
    }

    public function addUser()
    {
       
        
        if (!$this->validate()) {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();         
        if($this->checkEmailExist()) {
            $this->email_taken = true;
        }
        if($this->checkUsernameExist()) {
            $this->username_taken = true;
        }
        if($this->email_taken || $this->username_taken) {
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
            // $this->id = $db->lastInsertId();
            $db->commit();
            return true;
        } 
        
    }

    public function checkEmailExist(){
        $db = DB::conn();
        $found = $db->row("SELECT * FROM user
            WHERE email = ? " , array($this->email));
        return $found;
    }
    public function checkUsernameExist(){
        $db = DB::conn();
        $found = $db->row("SELECT * FROM user
            WHERE username = ? " , array($this->username));
        return $found;
    }

    /**
    * update user info
    */
    public function updateUser ()
    {
        $this->validate();
        if ($this->hasError()) {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();
        if(!is_same($this->current_email, $this->email))
        {
            if($this->checkEmailExist()) {
                $this->email_taken = true;
            }
        }
        if(!is_same($this->current_username, $this->username)) {
        
            if($this->checkUsernameExist()) {
                $this->username_taken = true;
            }
        }
        if($this->email_taken ||  $this->username_taken) {
           return false;
        } else {
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
                WHERE id = ? " , array( $this->id ) );
            $db->commit();
            return $logged_user;
        }
    }

    /**
    * change user password
    */
    public function passwordChange ()
    {
        $this->password_match = is_same($this->new_password,$this->confirm_password);
        if (!$this->validate() || ($this->password_match==false))
        {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();
        $loguser = $db->row('SELECT * FROM user
            WHERE username = ? AND password = ?' ,
            array($this->username,md5(sha1($this->password))));
        if($loguser){
            $db->query("UPDATE user
            SET password = ? WHERE username = ? " ,
            array(md5(sha1($this->new_password)) , $this->username) );
            $db->commit();
            return true;
        }else{
            $this->password_correct = false;
        }
    }

    /**
    * login validate in db
    * @return array
    */
    public function validateLogin()
    {
        $db = DB::conn();
        $loguser = $db->row('SELECT * FROM user
            WHERE username = ? AND password = ?' ,
            array($this->username,md5(sha1($this->password))));
        
        if($loguser)
        {
            return $loguser;    
        }
        
    }

    /**
    * get all users
    */
    public function getUsers(){
        $db = DB::conn();
        $users = $db->rows("SELECT * FROM user");
        return $users;
    }
    
    /**
    * get one user
    */
    public function getUser(){
        $db = DB::conn();
        $user = $db->row("SELECT fname,lname FROM user WHERE id = ?", array($this->user_id));
        return $user;
    }

    /**
    * delete user
    */
    public function deleteUser ()
    {  
        $db = DB::conn();
        $db->query("DELETE FROM user WHERE id = ?", array($this->id));
        $deleted = $db->rowCount();
        return $deleted;
    }

}