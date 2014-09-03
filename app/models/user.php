<?php
class User extends AppModel
{
    const MIN_CHAR = 1;
    const MAX_CHAR = 30;
    
    public $password_match = true;
    public $password_correct = true;
    public $already_registered = false;

    public $validation = array(
        'user_fname' => array(
            'format' => array(
                'alpha_only'
            ),
            'length' => array(
                'validate_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'user_lname' => array(
            'format' => array(
                'alpha_only'
            ),
            'length' => array(
                'validate_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'user_email' => array(
            'format' => array(
                'is_email'
            ),
            'length' => array(
                'validate_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'user_username' => array(
            'format' => array(
                'alpha_only'
            ),
            'length' => array(
                'validate_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),

        'user_password' => array(
            'length' => array(
                'validate_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),
                
        'user_new_password' => array(
            'length' => array(
                'validate_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        ),
    );

    /*
    function to call
    when registering form is submitted
    checks in database if existing email or username
    */
    public function register ()
    {
        $this->validate();
        $this->password_match = is_same($this->user_password,$this->user_confirm_password);
        if ($this->hasError() || ($this->password_match==false))
        {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();
        $found = $db->row('SELECT * FROM user
        WHERE user_username = ? OR user_email = ?',
        array($this->user_username,$this->user_email));

        if($found)
        {
            $this->already_registered = true;
            return false;
        }else{

            $db->query('INSERT INTO user
            SET user_fname = ?, user_lname = ?,
            user_email = ?, user_username = ?, user_password = ?, user_registered = NOW()',
            array($this->user_fname,$this->user_lname,
            $this->user_email,$this->user_username,md5(sha1($this->user_password))));

            $this->id = $db->lastInsertId();
            $db->commit();
            return true;
        }
        
    }

    /*
    updating information
    of a logged user
    checks in database if existing email or username
    */
    public function update_user ()
    {
        $found = "";
        $user_id = get_session('logged_in','user_id');
        $this->validate();
        if ($this->hasError())
        {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();
        $current_info = $db->row(
        "SELECT * FROM user
        WHERE user_id = ? " ,
        array( $user_id ) );     
    
        if(!is_same($current_info['user_email'],$this->user_email) || !is_same($current_info['user_username'],$this->user_username))
        {
            $found = $db->row("SELECT * FROM user
            WHERE user_email = ? OR user_username = ? " ,
            array($this->user_email,$this->user_username));
        }
        
        if($found)
        {
            $this->already_registered = true;
            return false;
        }else{
            //update the user database
            $params = array(
                "user_fname" => $this->user_fname,
                "user_lname" => $this->user_lname,
                "user_email" => $this->user_email,
                "user_username" => $this->user_username
                );
            $where_params = array("user_id" => $user_id);
            $db->update("user",$params,$where_params);
            //get the user row to update session 
            $logged_user = $db->row("SELECT * FROM user
            WHERE user_id = ? " , array( $user_id ) );
            $db->commit();
            return $logged_user;
        }
        
    }
    
    /*
    changing password of a logged user
    current password must be correct
    tries to login again
    */
    public function password_change ()
    {
    
        
        $this->validate();
        $this->password_match = is_same($this->user_new_password,$this->user_confirm_password);
        if ($this->hasError() || ($this->password_match==false))
        {
            throw new ValidationException('invalid');
        }
    
        $db = DB::conn();
        $db->begin();
        $pota = $this->user_username;
        //try to login again to check if correct current password
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

    /*
    looks for the input username and password in user table
    */
    public function login ()
    {
        $db = DB::conn();
        $db->begin();
        $loguser = $db->row('SELECT * FROM user
        WHERE user_username = ? AND user_password = ?' ,
        array($this->user_username,md5(sha1($this->user_password))));
        
        if($loguser)
        {
            return $loguser;    
        }
        
    }
    

}