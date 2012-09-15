<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class ads_model extends CI_Model {

    var $id = 0;
    var $answered_question = 0; //score
    var $os = "";    

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }   

    function get_last_ten_scorers() {
        $query = $this->db->get('bt_scorers', 10);
        return $query->result();
    }

    protected function paramPost($index = '', $xss_clean = FALSE, $default = FALSE) {
        if (!isset($_POST[$index])) {
            return $default;
        }
        return $this->input->post($index, $xss_clean);
    }

    protected function paramGet($index = '', $xss_clean = FALSE, $default = FALSE) {
        if (!isset($_GET[$index])) {
            return $default;
        }
        return $this->input->get($index, $xss_clean);
    }

}