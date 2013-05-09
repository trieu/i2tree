<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Request $request
 * @property CI_DB_active_record $db
 * @property GCM $gcm
 */
class user_device_id_model extends CI_Model {

    const TABLE = 'user_device_ids';

    var $id = 0;
    var $user_id = 0;
    var $device_token = '';
    var $device_model = '';
    var $os_name = ''; //@TODO
    var $os_version = '';
    var $notify_count = 0;
    var $creation_time = 0;
    var $last_notify_time = 0;

    function __construct() {
        parent::__construct();
    }

    function unregister() {
        
    }

    function isExistedDevice() {
        $this->db->where('device_token', $this->device_token);
        $query = $this->db->get(self::TABLE);
        $r = count($query->result()) > 0;
        return $r;
    }

    function register() {

        $this->device_token = $this->request->param('device_token', TRUE, '');
        $this->device_model = $this->request->param('device_model', TRUE, '');
        $this->os_name = $this->request->param('os_name', TRUE, 'Android');
        $this->os_version = $this->request->param('os_version', TRUE, '');
        $this->creation_time = time();
        if ($this->isExistedDevice()) {
            return 0;
        }

        $dbRet = $this->db->insert(self::TABLE, $this);
        //var_dump($dbRet);
        if (!$dbRet) {
            $errNo = $this->db->_error_number();
            $errMess = $this->db->_error_message();
            echo "DbError: Problem Inserting to " . self::TABLE . ": " . $errMess . " (" . $errNo . ")";
            exit;
        }
        return $this->db->insert_id();
    }

    function get_all() {
        $this->db->order_by("creation_time");
        $query = $this->db->get(self::TABLE);
        return $query->result();
    }

    function send_push_msg_to_all($filter_ids = array()) {
        $this->db->order_by("creation_time");
        $query = $this->db->get(self::TABLE);
        $dtokens = $query->result();
        $registatoin_ids = array();
        $this->load->library('GCM');
        $sendFailTokens = array();
        $c = 0;
        $debug = isset($_GET['debug']);
        foreach ($dtokens as $row) {
            if (empty($filter_ids)) {
                $message = array("cmd" => 'refresh');
                $registatoin_ids = array($row->device_token);
                if (!$debug) {
                    $this->gcm->send_notification($registatoin_ids, $message);
                } else {
		          echo $row->device_token . '<br>';
		        }
            } else {
                if (isset($filter_ids[$row->id])) {
                    $message = array("cmd" => 'refresh');
                    $registatoin_ids = array($row->device_token);
                    if (!$debug) {
                        $this->gcm->send_notification($registatoin_ids, $message);
                    }
                }
            }

//            $result = json_decode($this->gcm->send_notification($registatoin_ids, $message));
//            if($result->success != 1){
//                $sendFailTokens[] = $registatoin_ids;
//            } else {
//                $c++;
//            }
        }
        if ($debug) {
            echo count($dtokens);
            exit;
        }
        return $c;
    }

    function notify_to_device($registration_ids) {               
        $message = array("cmd" => 'refresh');
        $this->load->library('GCM');
        $this->gcm->send_notification($registration_ids, $message);		       
    }

}
