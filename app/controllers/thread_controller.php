<?php
class ThreadController extends AppController
{
	public function index()
	{
		$threads = Thread::getAll();
		$this->set(get_defined_vars());
	}
	public function user_login(){

		$user = new User();
		$user->user_username = Param::get('user_username');
		$user->user_password = Param::get('user_password');
		$okpyn =$user->login();
		print_r("<pre>");
		print_r($okpyn);
		print_r("</pre>");
		if($user->login()){
			echo "nakalogin!";
			$this->Session->write('User.eyeColor', 'Green');
		}else{
			echo "invalid user!";
		}
		$user->autoRender = false;
		exit();
	}
	public function register()
	{

		$user = new User();
		$page = Param::get('page_next', 'register');
		switch ($page) {

		case 'register':
		break;
		case 'register_ok':
		
		$user->user_fname = Param::get('user_fname');
		$user->user_lname = Param::get('user_lname');
		$user->user_username = Param::get('user_username');
		$user->user_email = Param::get('user_email');
		$user->user_password = Param::get('user_password');
		$user->user_confirm_password = Param::get('user_confirm_password');
		try {
			if($user->register()){

			}else{
				$page = 'register';
			}
		} catch (ValidationException $e) {
			$page = 'register';
		}
			break;
			default:
				throw new NotFoundException("{$page} is not found");
			break;
		}
		
		$this->set(get_defined_vars());
		$this->render($page);
	}
	public function create()
	{
	$thread = new Thread;
	$comment = new Comment;
	$page = Param::get('page_next', 'create');
		switch ($page) {

		case 'create':
		break;
		case 'create_end':
		$thread->title = Param::get('title');
		$comment->username = Param::get('username');
		$comment->body = Param::get('body');
		try {
			$thread->create($comment);
		} catch (ValidationException $e) {
			$page = 'create';
		}
			break;
			default:
				throw new NotFoundException("{$page} is not found");
			break;
		}
		$this->set(get_defined_vars());
		$this->render($page);
	}

	public function view()
	{
		$thread = Thread::get(Param::get('thread_id'));
		$comments = $thread->getComments();

		$this->set(get_defined_vars());
	}
	public function write()
	{
		$thread = Thread::get(Param::get('thread_id'));
		$comment = new Comment;
		$page = Param::get('page_next', 'write');
		switch ($page) {
		case 'write':
			break;
		case 'write_end':
			$comment->username = Param::get('username');
			$comment->body = Param::get('body');
		try {
			$thread->write($comment);
		} catch (ValidationException $e) {
			$page = 'write';
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
