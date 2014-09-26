<?php
class Thread extends AppModel
{
    public $validation = array(
        'title' => array(
            'length' => array(
                'is_between', MIN_CHAR, MAX_CHAR_THREAD_TITLE,
            ),
        )
        
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
            "title" => $this->title,
            "klub_id" => $this->klub_id,
            "privacy" => $this->privacy,
            "user_id" => $comment->user_id
            );
        $db->insert("thread", $params);
        $this->id = $db->lastInsertId();
        $comment->write($this->id);
        $db->commit();
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
            WHERE thread_id = ?", array($this->id));
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

        $comment_counts = "(SELECT COUNT(id) FROM comment WHERE thread.id = comment.thread_id)";

        $last_posted = "(SELECT user.username FROM comment LEFT JOIN user ON comment.user_id=user.id
            WHERE comment.thread_id=thread.id ORDER BY comment.created DESC LIMIT 1)";

        $time_last_posted = "(SELECT comment.created FROM comment LEFT JOIN user ON comment.user_id=user.id
            WHERE comment.thread_id=thread.id ORDER BY comment.created DESC LIMIT 1)";

        $select_statements = "thread.id,title,thread.created,privacy,klub_id,username,
            $comment_counts AS comment_count, $last_posted AS last_posted, $time_last_posted as when_last";

        $rows = $db->rows("SELECT $select_statements FROM thread
            LEFT JOIN user ON thread.user_id=user.id ORDER BY when_last
            DESC LIMIT $start,$records_per_page");
        $threads = array();
        foreach ($rows as $row) {
            $threads[] = new self($row);
        }
        return $threads;
    }

    /**
    * get 1 thread
    * @param $id
    * @return $thread_row
    */
    public static function get($id)
    {
        $db = DB::conn();
        $select_statements = "thread.title,thread.id,thread.created,user.fname";
        $thread_row = $db->row("SELECT $select_statements FROM thread
            LEFT JOIN user ON thread.user_id=user.id
            WHERE thread.id = ?" , array($id));
        return new self($thread_row);
    }

    /**
    * gets comments of a thread
    * @param $id
    * @param $records_per_page
    * @return $comment_rows
    */
    public function getComments($id, $records_per_page)
    {
        $db = DB::conn();
        $start = ($this->page_num - 1) * $records_per_page ;
        $select_statements = "user.fname,comment.id as comment_id,comment.body,comment.created";
        $comment_rows = $db->rows(
        "SELECT $select_statements FROM comment LEFT JOIN user
            ON comment.user_id=user.id
            WHERE thread_id = ? ORDER BY created ASC
            LIMIT $start,$records_per_page",
            array($id)
        );
        return $comment_rows;
    }

}
