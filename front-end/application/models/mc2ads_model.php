<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Request $request
 * @property CI_DB_active_record $db
 */
class mc2ads_model extends CI_Model {

    const TABLE = 'mc2ads';

    var $id = 0;
    var $title = '';
    var $image_url = '';
    var $description = '';
    var $creation_time = 0;
    var $view_count = 0;

    function __construct() {
        parent::__construct();
    }

    function save() {

        $t = time();
        $uploadedFolder = './uploads/';
        $rs = $this->request->getUploadedImageWithThumb('image_ads', 'ads-img-'.$t, 'ads-img-'.$t, $uploadedFolder);
        //var_dump($rs);
        //exit;
        $this->title = $this->request->param('title', TRUE, '');
        $this->description = $this->request->param('description', TRUE, '');
        $this->image_url = $rs['image_ads'];
        $this->creation_time = $t;
        

        $dbRet = $this->db->insert(self::TABLE, $this);
        //var_dump($dbRet);
        if (!$dbRet) {
            $errNo = $this->db->_error_number();
            $errMess = $this->db->_error_message();
            echo "DbError: Problem Inserting to " . self::TABLE . ": " . $errMess . " (" . $errNo . ")";
            exit;
        }
        $id = $this->db->insert_id();
        if($id>0){
            $this->load->model('user_device_id_model');
            $this->user_device_id_model->send_push_msg_to_all();   
            return $id;
        }
    }
    
    function get_top_ads() {
        $this->db->order_by("creation_time");
        $query = $this->db->get(self::TABLE, 10);
        return $query->result();
    }
    
}