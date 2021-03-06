<?php
class Klub extends AppModel
{
    public $klub_taken = false;

    public $validation = array(
        'klub_name' => array(
            'format' => array(
                'is_alpha'
            ),
            'length' => array(
                'is_between', MIN_CHAR, MAX_CHAR_KLUBNAME,
            ),
        ),
        'klub_details' => array(
            'length' => array(
                'is_between', MIN_CHAR, MAX_CHAR_BODY,
            ),
        )
       
    );

    /**
    * get all klubs
    * @return $klubs
    */
    public static function getAll()
    {  
        $db = DB::conn();
        $except = Member::REQUESTED;
        $klubs = $db->rows("SELECT klub.klub_id,klub_name,klub_details,
            (SELECT COUNT(id) FROM member
            WHERE klub.klub_id = member.klub_id
            AND member.level != ?) as members from klub" , array($except));  
        return $klubs;    
    }

    /**
    * get klub
    * @return $klub
    */
    public static function get($klub_id)
    {  
        $db = DB::conn();
        $row = $db->row("SELECT * from klub WHERE klub_id = ?", array($klub_id));  
        if($row) {
            return new self($row);    
        }
        
    }

    /**
    * insert klub
    * @return boolean
    */
    public function add()
    {  
        if (!$this->validate()) {
            throw new ValidationException();
        }
        $db = DB::conn();
        $db->begin();         
        if($this->checkKlubExist()) {
            $this->klub_taken = true;
        }
        if($this->klub_taken) {
            throw new ValidationException(); 
        }   
        $params = array(
            "klub_name" => $this->klub_name,
            "klub_details" => $this->klub_details,
            "klub_updated" => date('Y-m-d H:i:s')
        );
        $db->insert("klub", $params);
        $this->id = $db->lastInsertId();
        $db->commit();     
    }

    /**
    * check if klub exist
    * @return $found
    */
    public function checkKlubExist()
    {
        $db = DB::conn();
        $found = $db->row("SELECT klub_name FROM klub
            WHERE klub_name = ? " , array($this->klub_name));
        return $found;
    }

    /**
    * update klub info
    */
    public function edit()
    {
        $this->validate();
        if ($this->hasError()) {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();
        if(!is_same($this->current_name, $this->klub_name) && $this->checkKlubExist()) {
            $this->klub_taken = true;
            throw new ValidationException();
        }
        $params = array(
            "klub_name" => $this->klub_name,
            "klub_details" => $this->klub_details,
            "klub_updated" => date('Y-m-d H:i:s'),
        );
        $where_params = array("klub_id" => $this->klub_id);
        $db->update("klub", $params, $where_params);
        $db->commit();
        return true;
    }

    /**
    * delete klub
    * @return $deleted
    */
    public function delete()
    {
        $db = DB::conn();
        $db->query("DELETE FROM klub WHERE klub_id = ?", array($this->klub_id));
        return $db->rowCount();
    }
}