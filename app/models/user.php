<?php
class User extends AppModel
{
	const MIN_CHAR = 1;
	const MAX_CHAR = 30;
	
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
				'validate_between', 1, self::MAX_CHAR,
			),
		),

		'user_email' => array(
			'format' => array(
				'is_email'
			),
			'length' => array(
				'validate_between', 6, self::MAX_CHAR,
			),
		),

		'user_username' => array(
			'format' => array(
				'alpha_only'
			),
			'length' => array(
				'validate_between', 1, self::MAX_CHAR,
			),
		),

		'user_password' => array(
			'length' => array(
				'validate_between', 6, self::MAX_CHAR,
			),
		),
				
		
	);

	public $password_match = true;
	public $already_registered = false;
	public function register()
	{
	
		$this->validate();
		$this->password_match = is_same($this->user_password,$this->user_confirm_password);
		if ($this->hasError() || ($this->password_match==false)) {
			throw new ValidationException('invalid');
		}
		$db = DB::conn();
		$db->begin();
		$found = $db->row('SELECT * FROM user WHERE user_username = ? OR user_email = ?',array($this->user_username,$this->user_email));
		if($found){
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

	public function login(){
		$db = DB::conn();
		$db->begin();
		$loguser = $db->row('SELECT * FROM user WHERE user_username = ?', array($this->user_username));
		if($loguser['user_password']===md5(sha1($this->user_password))){
			return $loguser;	
		}
		
	}
	

}
