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
        'user_fname' => array(
            'format' => array(
                'is_alpha'
            ),
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'user_lname' => array(
            'format' => array(
                'is_alpha'
            ),
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'user_email' => array(
            'format' => array(
                'is_email'
            ),
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'user_username' => array(
            'format' => array(
                'is_alpha'
            ),
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'user_password' => array(
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),
       'user_new_password' => array(
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
       
        $this->password_match = is_same($this->user_password,$this->user_confirm_password);
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
                "user_fname" => $this->user_fname,
                "user_lname" => $this->user_lname,
                "user_email" => $this->user_email,
                "user_username" => $this->user_username,
                "user_password" => md5(sha1($this->user_password))
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
                "user_fname" => $this->user_fname,
                "user_lname" => $this->user_lname,
                "user_email" => $this->user_email,
                "user_username" => $this->user_username,
                "user_type" => $this->user_type,
                "user_password" => md5(sha1($this->user_password))
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
            WHERE user_email = ? " , array($this->user_email));
        return $found;
    }
    public function checkUsernameExist(){
        $db = DB::conn();
        $found = $db->row("SELECT * FROM user
            WHERE user_username = ? " , array($this->user_username));
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
        if(!is_same($this->current_email, $this->user_email))
        {
            if($this->checkEmailExist()) {
                $this->email_taken = true;
            }
        }
        if(!is_same($this->current_username, $this->user_username)) {
        
            if($this->checkUsernameExist()) {
                $this->username_taken = true;
            }
        }
        if($this->email_taken ||  $this->username_taken) {
           return false;
        } else {
            $params = array(
                "user_fname" => $this->user_fname,
                "user_lname" => $this->user_lname,
                "user_email" => $this->user_email,
                "user_username" => $this->user_username
                );
            $where_params = array("user_id" => $this->user_id);
            $db->update("user",$params,$where_params);
            $logged_user = $db->row("SELECT * FROM user
                WHERE user_id = ? " , array( $this->user_id ) );
            $db->commit();
            return $logged_user;
        }
    }

    /**
    * change user password
    */
    public function passwordChange ()
    {
        $this->password_match = is_same($this->user_new_password,$this->user_confirm_password);
        if (!$this->validate() || ($this->password_match==false))
        {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();
        $loguser = $db->row('SELECT * FROM user
            WHERE user_username = ? AND user_password = ?' ,
            array($this->user_username,md5(sha1($this->user_password))));
        if($loguser){
            $db->query("UPDATE user
            SET user_password = ? WHERE user_username = ? " ,
            array(md5(sha1($this->user_new_password)) , $this->user_username) );
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
            WHERE user_username = ? AND user_password = ?' ,
            array($this->user_username,md5(sha1($this->user_password))));
        
        if($loguser)
        {
            return $loguser;    
        }
        
    }
    

}