<?php
class Comment extends AppModel
{
    
    public $validation = array(
        
        'body' => array(
            'required' => array(
            'required',
            ),
        ),
    );

    /**
    * insert a new comment
    * @param $thread_id
    */
    public function write($thread_id)
    {   
        if (!$this->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $params = array(
            "thread_id" => $thread_id,
            "user_id" => $this->user_id,
            "body" => $this->body,  
            );
        $db->insert("comment", $params);
    }

}
