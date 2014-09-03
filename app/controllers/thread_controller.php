<?php
class ThreadController extends AppController
{
    const THREADS_PER_PAGE = 10;
    const COMMENTS_PER_PAGE = 10;

    /*
    current homepage
    gets/shows threads depending
    on THREADS_PER_PAGE
    */
    public function index ()
    {
        $thread = new Thread();
        $thread->pn = Param::get('pn');
        $page ="";
        //if no page is set,set pn(page number) to 1
        if(!isset($thread->pn) || !is_numeric($thread->pn) )
        {
            $thread->pn = 1;
        }

        $threads = $thread->getAll(self::THREADS_PER_PAGE);
        if(count($threads)>0){
            $page = new Pagination(Thread::count_threads(),self::THREADS_PER_PAGE);
            $paginate = $page->pageit();
        }
        
        //if there threads but method did not return any threads
        //this is for pages that do not exist
        if(Thread::count_threads() > 0 && count($threads) == 0)
        {
            $threads = "not exist";
        }
        $this->set(get_defined_vars());
    }

    /*
    function that handles
    when login form is submitted
    */
    public function user_login ()
    {

        $user = new User();
        $user->user_username = Param::get('user_username');
        $user->user_password = Param::get('user_password');
        $logged_user = $user->login();
        
        if($user->login()){
            session_start();
            add_session('logged_in',$logged_user);
            redirect(url('/'));

        }else{
            flash( 'login_failed', 'Login credentials invalid!' ); 
            redirect(url('/'));
        }
        $user->autoRender = false;
        exit();
    }

    /*
    logout and remove/destroy current session
    */
    public function logout()
    {
        session_destroy();
        redirect(url('/'));
    }

    /*
    register a new user
    also the landing page if
    success or if
    there are validation errors
    */
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
                //if validations are ok
                if($user->register()){

                }else{ //if not redirect to self
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

    /*
    function for creating thread
    redirect to created thread if
    validation/input successful
    else redirect to self
    */
    public function create ()
    {
        //if not logged in,redirect to homepage
        if(!check_session('logged_in'))
        {
            redirect(url('/'));
        }

        $thread = new Thread;
        $comment = new Comment;
        
        $page = Param::get('page_next', 'create');
        switch ($page)
        {
            case 'create':

                break;

            case 'create_end':
            $thread->title = Param::get('title');
            $thread->user_id = get_session('logged_in','user_id');
            $comment->body = Param::get('body');
            
            try {
                $thread->create($comment);
            } catch (ValidationException $e) {
                $page = 'create';
            }
                redirect(url('thread/view?thread_id='.$thread->thread_id));
                break;
            
        default:
            throw new NotFoundException("{$page} is not found");
            break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    /*
    view one thread and comments each page
    depending on COMMENTS_PER_PAGE
    */
    public function view ()
    {
        $thread = new Thread();
        $thread->pn = Param::get('pn');

        //if no page is set,set pn(page number) to 1
        if(!isset($thread->pn) || !is_numeric($thread->pn) ){
            $thread->pn = 1;
        }

        $view_thread = $thread->get(Param::get('thread_id'));
        $thread->thread_id = $view_thread['thread_id'];
        $comments = $thread->getComments($thread->thread_id,self::COMMENTS_PER_PAGE);
        
        $page = new Pagination($thread->count_comments(),self::COMMENTS_PER_PAGE,array("thread_id=$thread->thread_id"));
        $paginate = $page->pageit();
        
        //if there threads but method did not return any threads
        //this is for pages that do not exist
        if($thread->count_comments() > 0 && count($comments) == 0){
            $threads = "not exist";
        }

        $this->set(get_defined_vars());
    }

    /*
    function that handles when
    writing a comment form is submitted
    */
    public function write_comment()
    {   
        $thread = new Thread();
        $thread->thread_id = Param::get('thread_id');
    
        $thread->user_id = get_session('logged_in','user_id');
        $comment = new Comment;
        $page = Param::get('page_next', 'write');
        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->body = Param::get('body');
            try {
                $thread->write($comment);
            } catch (ValidationException $e) {
                $page = 'write';
            }
            //redirect back to thread
            redirect(url('thread/view?thread_id='.$thread->thread_id));
                break;  

            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $user->autoRender = false;
        exit();

    }

}