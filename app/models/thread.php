<?php
class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'is_between', 1, 30,
            ),
        ),
    );
    
    //function for inserting/creating thread
    public function create (Comment $comment)
    {
        $this->validate();
        $comment->validate();
        if ($this->hasError() || $comment->hasError())
        {
            throw new ValidationException('invalid thread or comment');
        }
        $db = DB::conn();
        $db->begin();
        
        $db->query('INSERT INTO thread SET thread_title = ?, thread_user_id = ?, thread_created = NOW()',
        array($this->title, $this->user_id));
        $this->thread_id = $db->lastInsertId();
        $this->write($comment);
        $db->commit();
    }

    //count all thread,return int
    public static function count_threads ()
    {

        $db = DB::conn();
        $count = $db->row("SELECT COUNT(*) as count FROM thread");
        return $count['count'];
    }

    //count all comments of given thread id return int
    public function count_comments ()
    {

        $db = DB::conn();
        $count = $db->row("SELECT COUNT(*) as count FROM comment
        WHERE comment_thread_id = ?", array($this->thread_id));
        return $count['count'];
    }

    /*
    get threads = depending
    on the passed parameter itemsPerPage
    */
    public function getAll ($itemsPerPage)
    {
        //sql statements are very long,divided into separate variables
        $db = DB::conn();
        $start = ($this->pn - 1) * $itemsPerPage ;

        $comment_counts = "(select count(comment_id) from comment where thread.thread_id = comment.comment_thread_id)";
        $last_posted = "(select user.user_username from comment left join user on comment.comment_user_id=user.user_id
        where comment.comment_thread_id=thread.thread_id ORDER BY comment.comment_created DESC  limit 1)";

        $select_statements = "thread.thread_id,thread.thread_title,thread.thread_created,user.user_username,
        $comment_counts as comment_count,
        $last_posted as last_posted";

        $rows = $db->rows("SELECT $select_statements FROM thread
        LEFT JOIN user ON thread.thread_user_id=user.user_id LIMIT $start,$itemsPerPage");

        return $rows;
    }

    /*
    get 1 thread depending
    on parameter id
    */
    public static function get ($id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread
        LEFT JOIN user ON thread.thread_user_id=user.user_id
        WHERE thread.thread_id = ?' , array($id));
        return $row;

    }

    /*
    insert a new comment
    */
    public function write (Comment $comment)
    {   
        if (!$comment->validate())
        {
            throw new ValidationException('invalid comment');
        }

        $db = DB::conn();
        $params = array(
            "comment_thread_id" => $this->thread_id,
            "comment_user_id" => $this->user_id,
            "comment_body" => $comment->body,
            
            );
        $db->insert("comment",$params);
    }

    /*
    gets comments of a thread = depending
    on the passed parameter itemsPerPage
    */
    public function getComments ($thread_id,$itemsPerPage)
    {
        $comments = array();
        $db = DB::conn();
        $start = ($this->pn - 1) * $itemsPerPage ;

        $rows = $db->rows(
        "SELECT * FROM comment
        LEFT JOIN user ON comment.comment_user_id=user.user_id
        WHERE comment_thread_id = ? ORDER BY comment_created ASC
        LIMIT $start,$itemsPerPage",
        array($thread_id)
        );
    
        return $rows;
    }


}
