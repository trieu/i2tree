<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Request $request
 * @property CI_DB_active_record $db
 */
class bt_global_scorer_model extends CI_Model {

    const TABLE = 'bt_global_scorers';

    var $id = 0;
    var $os = "";
    var $os_version = "";
    var $name = '';
    var $finish_time = 0;
    var $gps_lat = 0;
    var $gps_lon = 0;
    var $country_code = "";
    var $timestamp = 0;
	var $device = 'iPhone';

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_scorer_result() {
        $url = parse_url($_SERVER['REQUEST_URI']);
        parse_str($url['query'], $params);

        $safe_params = array();
        foreach ($params as $fieldname => $fieldvalue) {
            if ($fieldname === "id" || $fieldname === "country_code") {
                $safe_params[$fieldname] = $fieldvalue;
            }
        }

        if (!empty($safe_params)) {
            $query = $this->db->get_where(self::TABLE, $safe_params);
            return $query->result();
        }
        return array();
    }

    function get_top_scorers() {
        $this->db->order_by("finish_time"); 
        $query = $this->db->get(self::TABLE, 20);        
        return $query->result();
    }

    function insert_scorer() {
        $this->load->library('encrypt');

        $this->timestamp = time();
        $this->name = cleanUserInput($this->request->param('name', TRUE));
        $this->finish_time = floatval($this->request->param('finish_time', TRUE));
        $this->os = cleanUserInput($this->request->param('os', TRUE, ''));
        $this->os_version = cleanUserInput($this->request->param('os_version', TRUE, ''));
		$this->device = cleanUserInput($this->request->param('device', TRUE, 'iPhone'));
        $submitCode = $this->request->param('code', TRUE, '');

        $codeStr = $this->name . '-' . $this->os . '-' . $this->finish_time;
        $validSubmitCode = $this->encrypt->sha1($codeStr);

        if ($submitCode !== $validSubmitCode) {
            if (isset($_GET['debug'])) {
                echo "Invalid code $validSubmitCode != $submitCode";
                exit;
            }
            return FALSE;
        }

        $requestInfo = $this->request->getLocationInfo();

        $this->gps_lat = floatval($requestInfo->latitude);
        $this->gps_lon = floatval($requestInfo->longitude);
        $this->country_code = cleanUserInput($requestInfo->country_code);

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

}