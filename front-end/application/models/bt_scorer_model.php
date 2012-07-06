<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class bt_scorer_model extends CI_Model {

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
	
	function get_scorer_result() {
		$url = parse_url($_SERVER['REQUEST_URI']);
		parse_str($url['query'], $params);
		//var_dump($params);exit;
		
		$safe_params = array();
		foreach($params as $fieldname => $fieldvalue )
		{
			if($fieldname === "id" || $fieldname === "email" || $fieldname === "social_security_number" 
				|| $fieldname === "country_code" || $fieldname === "region_code" ) {
				$safe_params[$fieldname] = $fieldvalue;
			}
		}
		
		if( ! empty($safe_params) ) {
			$query = $this->db->get_where('bt_scorers', $safe_params);
			return $query->result();
		}
		return array();
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

    protected function getIP() {
        $ip;
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else
            $ip = "UNKNOWN";
        return $ip;
    }

    /*
      {
      city: "Ho Chi Minh City",
      region_code: "20",
      region_name: "Ho Chi Minh",
      metrocode: "",
      zipcode: "",
      longitude: "106.667",
      latitude: "10.75",
      country_code: "VN",
      ip: "58.186.221.76",
      country_name: "Vietnam"
      }
     */

    function getRequestInfo() {
        $this->load->library('curl');
        // Simple call to remote URL
        $json = json_decode($this->curl->simple_get('http://freegeoip.net/json/' . $this->getIP()));

//        echo $json->latitude;
//        echo $json->longitude;
        return $json;
    }

    function insert_scorer() {
        $this->answered_question = intval($this->paramPost('answered_question', TRUE, 0));
        $this->star = intval($this->paramPost('star', TRUE, 0));
        $this->email = cleanUserInput($this->paramPost('email', TRUE));
        $this->firstname = cleanUserInput($this->paramPost('firstname', TRUE));
        $this->lastname = cleanUserInput($this->paramPost('lastname', TRUE));

        $this->os = cleanUserInput($this->paramPost('os', TRUE, ''));
        $this->os_version = cleanUserInput($this->paramPost('os_version', TRUE, ''));
        $this->social_security_number = cleanUserInput($this->paramPost('social_security_number', TRUE, ''));

        if ($this->email || $this->answered_question <= 0 || !$this->star <= 0 || !$this->firstname || !$this->lastname) {
            //TODO
            // return FALSE;
        }

        $this->timestamp = time();

        $requestInfo = $this->getRequestInfo();

        $this->gps_lat = floatval($requestInfo->latitude);
        $this->gps_lon = floatval($requestInfo->longitude);

        $this->country_code = cleanUserInput($requestInfo->country_code);
        $this->region_code = cleanUserInput($requestInfo->region_name);

        $table = 'bt_scorers';
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