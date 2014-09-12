<?php
class Klub extends AppModel
{
    const MIN_CHAR = 1;
    const MAX_CHAR = 30;
    
    public $klub_taken = false;

    public $validation = array(
        'klub_name' => array(
            'format' => array(
                'is_alpha'
            ),
            'length' => array(
                'is_between', self::MIN_CHAR, self::MAX_CHAR,
            ),
        )
       
    );

    /**
    * get all klubs
    * @return $klubs
    */
    public function getKlubs()
    {  
        $db = DB::conn();
        $klubs = $db->rows("SELECT * from klub");  
        return $klubs;    
    }

    /**
    * get all klubs
    * @return $klubs
    */
    public function getKlub()
    {  
        $db = DB::conn();
        $klub = $db->row("SELECT * from klub WHERE klub_id = ?", array($this->klub_id));  
        return $klub;    
    }

    /**
    * insert klub
    * @return boolean
    */
    public function addKlub()
    {
       
        if (!$this->validate()) {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();         
        if($this->checkKlubExist()) {
            $this->klub_taken = true;
        }
     
        if($this->klub_taken) {
            return false;
        } else {     
            $params = array(
                "klub_name" => $this->klub_name,
                "klub_details" => $this->klub_details,
                "klub_updated" => date('Y-m-d H:i:s')
            );
            $db->insert("klub", $params);
            $this->id = $db->lastInsertId();
            $db->commit();
            return true;
        } 
        
    }


    public function checkKlubExist(){
        $db = DB::conn();
        $found = $db->row("SELECT * FROM klub
            WHERE klub_name = ? " , array($this->klub_name));
        return $found;
    }

    /**
    * update klub info
    */
    public function editklub ()
    {
        $this->validate();
        if ($this->hasError()) {
            throw new ValidationException('invalid');
        }
        $db = DB::conn();
        $db->begin();
        if(!is_same($this->current_name, $this->klub_name))
        {
            if($this->checkKlubExist()) {
                $this->klub_taken = true;
            }
        }
        if($this->klub_taken) {
           return false;
        } else {
            $params = array(
                "klub_name" => $this->klub_name,
                "klub_details" => $this->klub_details,
                "klub_updated" => date('Y-m-d H:i:s'),
                );
            $where_params = array("klub_id" => $this->klub_id);
            $db->update("klub",$params,$where_params);
            $db->commit();
            return true;
        }
    }

    /**
    * delete klub
    */
    public function deleteKlub ()
    {
       
        $db = DB::conn();
        // $db->begin();
        // if(!is_same($this->current_name, $this->klub_name))
        // {
        //     if($this->checkKlubExist()) {
        //         $this->klub_taken = true;
        //     }
        // }

        $db->query("DELETE FROM klub WHERE klub_id = ?", array($this->klub_id));
        $deleted = $db->rowCount();
        return $deleted;

    }
  
    

}