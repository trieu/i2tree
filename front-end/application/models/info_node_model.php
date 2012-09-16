<?php

require_once 'i2tree_base_model.php';

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class info_node_model extends i2tree_base_model {
    
    static $TABLE_NAME = 'info_nodes';

    var $id = 0;
    var $thumbnail_url = '';
    var $title = '';
    var $content = '';
    var $category = '';
    var $creation_date = '';
    var $is_paid = '';
    var $is_problem = '';
    var $price = '';
    var $user_id = '';

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_nodes_result() {
        $url = parse_url($_SERVER['REQUEST_URI']);
        parse_str($url['query'], $params);
        //var_dump($params);exit;

        $safe_params = array();
        foreach ($params as $fieldname => $fieldvalue) {
            if ($fieldname === "category" || $fieldname === "is_paid" || $fieldname === "is_problem"
                    || $fieldname === "user_id" ) {
                $safe_params[$fieldname] = $fieldvalue;
            }
        }

        if (!empty($safe_params)) {
            $query = $this->db->get_where(self::$TABLE_NAME, $safe_params);
            return $query->result();
        }
        return array();
    }

    function get_last_ten_nodes() {
        $query = $this->db->get(self::$TABLE_NAME, 10);
        return $query->result();
    }

    function insert() {
        $this->load->library('encrypt');

        $this->title = intval($this->paramPost('answered_question', TRUE, 0));
        $this->phone = cleanUserInput($this->paramPost('phone', TRUE, ""));
        $this->email = cleanUserInput($this->paramPost('email', ''));
        $this->firstname = cleanUserInput($this->paramPost('firstname', TRUE));
        $this->lastname = cleanUserInput($this->paramPost('lastname', TRUE));

        $this->os = cleanUserInput($this->paramPost('os', TRUE, ''));
        $this->os_version = cleanUserInput($this->paramPost('os_version', TRUE, ''));
        $this->social_security_number = cleanUserInput($this->paramPost('social_security_number', TRUE, ''));

        $versionType = $this->paramPost('version', TRUE, '');
        $submitCode = $this->paramPost('code', TRUE, '');
        $date = cleanUserInput($this->paramPost('date', ''));

        if ($this->email == "" || $this->answered_question <= 0) {
            //TODO
            //return FALSE;
        }

        if ($versionType === 'NK') {
            //TODO
        } else {
            //TODO
        }

        $codeStr = $this->email . '-' . $this->os_version . '-' . $date . '-' . $this->answered_question;
        $validSubmitCode = $this->encrypt->sha1($codeStr);
        //echo $codeStr ."\n";		echo $validSubmitCode ."\n";		echo $submitCode ."\n";			exit;

        if ($submitCode !== $validSubmitCode) {
            return FALSE;
        }
        $this->timestamp = time();

        $requestInfo = $this->getRequestInfo();

        $this->gps_lat = floatval($requestInfo->latitude);
        $this->gps_lon = floatval($requestInfo->longitude);

        $this->country_code = cleanUserInput($requestInfo->country_code);
        $this->region_code = cleanUserInput($requestInfo->region_name);

        $table = self::$TABLE_NAME;
        $dbRet = $this->db->insert($table, $this);
        //var_dump($dbRet);
        if (!$dbRet) {
            $errNo = $this->db->_error_number();
            $errMess = $this->db->_error_message();
            echo "Problem Inserting to " . $table . ": " . $errMess . " (" . $errNo . ")";
            exit;
        }
        return $this->db->insert_id();
    }

}