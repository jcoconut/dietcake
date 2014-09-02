<?php
class SettingsController extends AppController
{
	public function info ()
	{
		$user = new User();
		$page = Param::get('page_next', 'info');
		switch ($page) {

		case 'info':
		break;
		case 'info_ok':
		
		$user->user_fname = Param::get('user_fname');
		$user->user_lname = Param::get('user_lname');
		$user->user_username = Param::get('user_username');
		$user->user_email = Param::get('user_email');
	
		try {
			$logged_user = $user->update_user();
			if($logged_user){
				add_session('logged_in',$logged_user);
			}else{
				$page = 'info';
			}
		} catch (ValidationException $e) {
			$page = 'info';
		}
			break;
			default:
				throw new NotFoundException("{$page} is not found");
			break;
		}
		
		$this->set(get_defined_vars());
		$this->render($page);
	}
	public function password_change ()
	{
		$user = new User();
		$page = Param::get('page_next', 'password_change');
		switch ($page) {

		case 'password_change':
		break;
		case 'info_ok':
		
		$user->user_password = Param::get('user_password');
		$user->user_confirm_password = Param::get('user_confirm_password');
		try {
			if($user->register()){

			}else{
				$page = 'info';
			}
		} catch (ValidationException $e) {
			$page = 'info';
		}
			break;
			default:
				throw new NotFoundException("{$page} is not found");
			break;
		}
		
		$this->set(get_defined_vars());
		$this->render($page);
	}

}