<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class aes_key_model extends CI_Model {

    const TABLE = 'aes_keys';

    var $id = 0;
    var $key = '';
    var $creation_time;

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_key($id) {
        $this->db->where("id", $id);
        $query = $this->db->get(self::TABLE);
        foreach ($query->result() as $row) {
            return $row->key;
        }
        return '';
    }

    function get_new_key() {
        $this->load->helper('random_password');
        $aes_key = get_random_password(10, 15, TRUE, TRUE, TRUE);
        $id = $this->save($aes_key);
        $data = array('aes_key' => $aes_key, 'id' => $id );
        return $data;
    }

    function save($key) {
        $this->key = $key;
        $this->creation_time = time();
        $dbRet = $this->db->insert(self::TABLE, $this);
        //var_dump($dbRet);
        if (!$dbRet) {
            $errNo = $this->db->_error_number();
            $errMess = $this->db->_error_message();
            echo "Problem Inserting to " . $table . ": " . $errMess . " (" . $errNo . ")";
            exit;
        }
        return $this->db->insert_id();
    }
    
    function decryptData($paramName = 'data') {
        $aes_key = $this->aes_key_model->get_key($this->request->param('id'));
        $sValue = $this->request->param($paramName);
        $data = aesDecrypt($sValue, $aes_key);
        return parse_str($data);
        
    }

}