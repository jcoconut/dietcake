<?php
class Thread extends AppModel
{
    public $validation = array(
        'thread_title' => array(
            'length' => array(
                'is_between', 1, 30,
            ),
        ),
    );
    
    /**
    * insert new thread
    * @param $comment
    * @return true
    */
    public function create(Comment $comment)
    {
        if ( !$this->validate() || !$comment->validate() ) {
            throw new ValidationException('invalid thread or comment');
        }
        $db = DB::conn();
        $db->begin();
        $params = array(
            "thread_title" => $this->thread_title,
            "thread_user_id" => $comment->user_id 
            );
        $db->insert("thread", $params);
        $this->thread_id = $db->lastInsertId();
        $comment->write($this->thread_id);
        $db->commit();
        return true;
    }

    /**
    * count all threads
    * @return int
    */
    public static function countThreads()
    {
        $db = DB::conn();
        return (int) $db->value("SELECT COUNT(*) FROM thread");
    }

    /**
    * count all comments of 1 thread
    * @return $count
    */
    public function countComments()
    {
        $db = DB::conn();
        $count = $db->row("SELECT COUNT(*) as count FROM comment
            WHERE comment_thread_id = ?", array($this->thread_id));
        return $count['count'];
    }

    /**
    * get threads
    * @param $records_per_page
    * @return $thread_rows
    */
    public function getAll($records_per_page)
    {
        $db = DB::conn();
        $start = ($this->page_num - 1) * $records_per_page ;

        $comment_counts = "(SELECT COUNT(comment_id) FROM comment WHERE thread.thread_id = comment.comment_thread_id)";
        $last_posted = "(SELECT user.user_username FROM comment LEFT JOIN user ON comment.comment_user_id=user.user_id
            WHERE comment.comment_thread_id=thread.thread_id ORDER BY comment.comment_created DESC LIMIT 1)";
        $time_last_posted = "(SELECT comment.comment_created FROM comment LEFT JOIN user ON comment.comment_user_id=user.user_id
            WHERE comment.comment_thread_id=thread.thread_id ORDER BY comment.comment_created DESC LIMIT 1)";
        $select_statements = "thread.thread_id,thread.thread_title,thread.thread_created,user.user_username,
            $comment_counts AS comment_count, $last_posted AS last_posted, $time_last_posted as when_last";

        $thread_rows = $db->rows("SELECT $select_statements FROM thread
            LEFT JOIN user ON thread.thread_user_id=user.user_id ORDER BY when_last DESC LIMIT $start,$records_per_page");
        return $thread_rows;
    }

    /**
    * get 1 thread
    * @param $thread_id
    * @return $thread_row
    */
    public static function get($thread_id)
    {
        $db = DB::conn();
        $thread_row = $db->row('SELECT * FROM thread
            LEFT JOIN user ON thread.thread_user_id=user.user_id
            WHERE thread.thread_id = ?' , array($thread_id));
        return $thread_row;
    }

    /**
    * gets comments of a thread
    * @param $thread_id
    * @param $records_per_page
    * @return $comment_rows
    */
    public function getComments($thread_id, $records_per_page)
    {
        $db = DB::conn();
        $start = ($this->page_num - 1) * $records_per_page ;
        $comment_rows = $db->rows(
        "SELECT * FROM comment LEFT JOIN user
            ON comment.comment_user_id=user.user_id
            WHERE comment_thread_id = ? ORDER BY comment_created ASC
            LIMIT $start,$records_per_page",
            array($thread_id)
        );
        return $comment_rows;
    }

}
