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
       
    );

    /**
    * insert user
    * @return boolean
    */
    public function register()
    {
       
        $this->password_match = is_same($this->user_password,$this->user_confirm_password);
        if (!$this->validate() || ($this->password_match==false))
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

    /**
    * login validate in db
    * @return array
    */
    public function validateLogin()
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