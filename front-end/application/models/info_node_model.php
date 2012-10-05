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
                    || $fieldname === "user_id") {
                $safe_params[$fieldname] = $fieldvalue;
            }
        }

        if (!empty($safe_params)) {
            $query = $this->db->get_where(self::$TABLE_NAME, $safe_params);
            return $query->result();
        }
        return array();
    }

    function get_categories() {
        $query = $this->db->get('categories');
        return $query->result();
    }

    function get_last_ten_nodes() {
        $query = $this->db->get(self::$TABLE_NAME, 100);
        return $query->result();
    }

    function insert() {

        $this->title = cleanUserInput($this->paramPost('title', TRUE, ""));
        $this->content = cleanUserInput($this->paramPost('content', TRUE, ""));
        $this->is_paid = cleanUserInput($this->paramPost('is_paid', TRUE, "0"));
        $this->is_problem = cleanUserInput($this->paramPost('is_problem', TRUE, "0"));
        $this->category = cleanUserInput($this->paramPost('category', TRUE, "0"));
        $this->thumbnail_url = cleanUserInput($this->paramPost('thumbnail_url', TRUE, ""));
        $this->user_id = cleanUserInput($this->paramPost('user_id', TRUE, "0"));
        $this->price = floatval($this->paramPost('price', TRUE, "0"));
        $this->creation_date = time();

        $table = self::$TABLE_NAME;
        $dbRet = $this->db->insert($table, $this);
        //var_dump($dbRet);
        if (!$dbRet) {
            $errNo = $this->db->_error_number();
            $errMess = $this->db->_error_message();
            echo "Problem inserting to " . $table . ": " . $errMess . " (" . $errNo . ")";
            exit;
        }
        return $this->db->insert_id();
    }

}