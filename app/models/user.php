<?php
class User extends AppModel
{
	const MIN_CHAR = 1;
	const MAX_CHAR = 30;
	
	public $password_match = true;
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
				
		
	);

	

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
		$found = $db->row('SELECT * FROM user WHERE user_username = ? OR user_email = ?',array($this->user_username,$this->user_email));

		if($found)
		{
			$this->already_registered = true;
			return false;
		}else{
			$db->query('INSERT INTO user SET user_fname = ?, user_lname = ?, user_email = ?, user_username = ?, user_password = ?, user_registered = NOW()',
			array($this->user_fname,$this->user_lname,$this->user_email,$this->user_username,md5(sha1($this->user_password))));
			$this->id = $db->lastInsertId();
			$db->commit();
			return true;
		}
		
	}

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
		$current_info = $db->row("SELECT * FROM user WHERE user_id = ? " , array( $user_id ) );
		
	
		if(!is_same($current_info['user_email'],$this->user_email) || !is_same($current_info['user_username'],$this->user_username))
		{
			$found = $db->row("SELECT * FROM user WHERE user_email = ? OR user_username = ? ",array($this->user_email,$this->user_username));
		}
		
		if($found)
		{
			$this->already_registered = true;
			return false;
		}else{
			//update the user database
			$db->query("UPDATE user SET user_fname = ?, user_lname = ?, user_email = ?, user_username = ? WHERE user_id=$user_id " ,
			array($this->user_fname,$this->user_lname,$this->user_email,$this->user_username));
			//get the user row to update session 
			$logged_user = $db->row("SELECT * FROM user WHERE user_id = ? " , array( $user_id ) );
			$db->commit();
			return $logged_user;
		}
		
	}

	public function login ()
	{
		$db = DB::conn();
		$db->begin();
		$loguser = $db->row('SELECT * FROM user WHERE user_username = ?', array($this->user_username));
		if($loguser['user_password']===md5(sha1($this->user_password)))
		{
			return $loguser;	
		}
		
	}
	

}
