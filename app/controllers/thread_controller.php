<?php
class ThreadController extends AppController
{
    const THREADS_PER_PAGE = 10;
    const COMMENTS_PER_PAGE = 10;

    /**
    * thread list
    */
    public function threads()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
            redirect(url('/'));
        }
        
        $thread = new Thread();
        $thread->page_num = Param::get('page_num', 1);        
        $threads = $thread->getAll(self::THREADS_PER_PAGE);
        if (count($threads)>0) {
            $page = new Pagination();
            $page->total_rows = Thread::countThreads();
            $page->per_page = self::THREADS_PER_PAGE;
            $paginate = $page->pageIt();
        }
        if (Thread::countThreads() > 0 && count($threads) == 0) {
            $threads = "not exist";
        }
        $this->set(get_defined_vars());
    }

    /**
    * create thread
    */
    public function createThread()
    {
        
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
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
                $comment->user_id = get_session('logged_in', 'id');
                $comment->body = Param::get('body');
                try {
                    if ( $thread->create($comment) ) {
                        redirect(url('thread/viewthread?id='.$thread->id));
                    } else {
                        $page = 'create';
                    }
                   
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

    /**
    * view thread and its comments
    */
    public function viewThread()
    {
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
            redirect(url('/'));
        }
        $thread = new Thread();
        $thread->page_num = Param::get('page_num',1);
        $view_thread = $thread->get(Param::get('id'));
        $thread->id = $view_thread['id'];
        $comments = $thread->getComments($thread->id, self::COMMENTS_PER_PAGE);  
        $page = new Pagination();
        $page->total_rows = $thread->countComments();
        $page->per_page = self::COMMENTS_PER_PAGE;
        $page->extra_query = array("id=$thread->id");
        $paginate = $page->pageIt();
        $this->set(get_defined_vars());
    }

    /**
    * writes comment on thread
    */
    public function writeComment()
    {   
        if(!is_logged('logged_in') || get_session('logged_in','type')==ADMIN){
            redirect(url('/'));
        }
        $comment = new Comment;
        $comment->thread_id = Param::get('id'); 
        $comment->user_id = get_session('logged_in', 'id');
        $comment->body = Param::get('body');
        $page = Param::get('page_next', 'write');
        switch ($page) {
            case 'write':
                break;
            case 'write_end':   
                redirect(url('thread/viewthread?id='.$comment->thread_id));
                try {
                    $comment->write($comment->thread_id);
                } catch (ValidationException $e) {
                    $page = 'write';
                }      
                break;  
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }

    }

}