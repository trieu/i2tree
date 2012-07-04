<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class br_scorer_model extends CI_Model {

    var $id = 0;
    var $answered_question = 0;
    var $star = 0;
    var $os = "";
    var $os_version = "";
    var $firstname = "";
    var $lastname = "";
    var $email = "";
    var $social_security_number = "";
    var $gps_lat = 0;
    var $gps_lon = 0;
    var $country_code = "";
    var $region_code = "";
    var $timestamp = 0;

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

    function insert_scorer() {
        $this->answered_question = intval($this->paramPost('answered_question', TRUE, 0));
        $this->star = intval($this->paramPost('star', TRUE, 0));
        $this->email = cleanUserInput($this->paramPost('email', TRUE));
        $this->firstname = cleanUserInput($this->paramPost('firstname', TRUE));
        $this->lastname = cleanUserInput($this->paramPost('lastname', TRUE));
        
        if( ! $this->email || $this->answered_question <= 0 || ! $this->star <= 0 || ! $this->firstname || ! $this->lastname  ) {
            return FALSE;
        }
        
        $this->timestamp = time();




        $this->os = cleanUserInput($this->paramPost('os', TRUE, ''));
        $this->os_version = cleanUserInput($this->paramPost('os_version', TRUE, ''));
        $this->social_security_number = cleanUserInput($this->paramPost('social_security_number', TRUE, ''));
        $this->gps_lat = floatval($this->paramPost('gps_lat', TRUE, 0));
        $this->gps_lon = floatval($this->paramPost('gps_lon', TRUE, 0));
        $this->country_code = cleanUserInput($this->paramPost('country_code', TRUE, ''));
        $this->region_code = cleanUserInput($this->paramPost('region_code', TRUE, ''));


        $this->db->insert('bt_scorers', $this);
        return $this->db->affected_rows() > 0;
    }

}