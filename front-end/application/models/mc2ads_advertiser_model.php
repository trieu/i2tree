<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Request $request
 * @property CI_DB_active_record $db
 */
class mc2ads_advertiser_model extends CI_Model {

    const TABLE = 'mc2ads_advertiser';

    var $id;
    var $name = '';    
    var $description = '';
    var $creation_time = 0;

    function __construct() {
        parent::__construct();
    }

    function save($id = 0) {

        $t = time();           
        $this->creation_time = $t;
        $this->name = $this->request->param('name', TRUE, '');
        $this->description = $this->request->param('description', TRUE, '');               

        if ($id > 0) {
            $obj = clone($this);
            unset($obj->creation_time);                   
            $dbRet = $this->db->update(self::TABLE, $obj, 'id = ' . $id);
        } else {
            $dbRet = $this->db->insert(self::TABLE, $this);
        }
        //var_dump($dbRet);
        if (!$dbRet) {
            $errNo = $this->db->_error_number();
            $errMess = $this->db->_error_message();
            echo "DbError: Problem Inserting to " . self::TABLE . ": " . $errMess . " (" . $errNo . ")";
            exit;
        }
        if ($id == 0) {
            $id = $this->db->insert_id();
        }        
        return $id;
    }

    

    function get_advertisers() {
        $this->db->order_by("creation_time", "desc");
        $query = $this->db->get(self::TABLE, 15);
        return $query->result();
    }

    public function edit($id) {
        $this->db->where('id', $id);
        $query = $this->db->get(self::TABLE);
        return $query->result();
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete(self::TABLE);
      
    }

}