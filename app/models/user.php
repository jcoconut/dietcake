<?php
class User extends AppModel
{
	public $validation = array(
		'user_fname' => array(
			'format' => array(
				'alpha_only'
			),
			'length' => array(
				'validate_between', 1, 20,
			),
		),


		'user_lname' => array(
			'format' => array(
				'alpha_only'
			),
			'length' => array(
				'validate_between', 1, 20,
			),
		),
		'user_email' => array(
			'length' => array(
				'validate_between', 6, 20,
			),
		),
		'user_password' => array(
			'format' => array(
				'alpha_only'
			),
			'length' => array(
				'validate_between', 1, 20,
			),
		),
		'user_username' => array(
			'format' => array(
				'alpha_only'
			),
			'length' => array(
				'validate_between', 1, 20,
			),
		),
		'user_secret' => array(
			'length' => array(
				'validate_between', 6, 20,
			),
		),
	);
	
	public function register()
	{
		$this->validate();
		
		if ($this->hasError() || $this->hasError()) {
			throw new ValidationException('invalid');
		}
		$db = DB::conn();
		$db->begin();
		$db->query('INSERT INTO user SET user_fname = ?, user_lname = ?, user_email = ?, user_username = ?, user_password = ?, user_registered = NOW()',
			array($this->user_fname,$this->user_lname,$this->user_email,$this->user_username,$this->user_password));
		$this->id = $db->lastInsertId();
		// write first comment at the same time
		// $this->write($);
		$db->commit();
	}
	public function kuke(){
		$db = DB::conn();
		$db->begin();
		$db->query('INSERT INTO user SET user_fname = ?,user_lname = ?', array('haha',$this->hey));
		$this->id = $db->lastInsertId();
		// write first comment at the same time
		// $this->write($comment);
		$db->commit();
	}
	

}
