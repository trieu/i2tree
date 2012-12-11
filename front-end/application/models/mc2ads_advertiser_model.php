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

        $dbRet = $this->db->update(self::TABLE, $this, 'id = ' . $id);

        //var_dump($dbRet);
        if (!$dbRet) {
            $errNo = $this->db->_error_number();
            $errMess = $this->db->_error_message();
            echo "DbError: Problem Inserting to " . self::TABLE . ": " . $errMess . " (" . $errNo . ")";
            exit;
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

    function get_table_data($start = 0, $limit = 100) {
        $this->db->order_by("creation_time", "desc");
        $query = $this->db->get(self::TABLE, $limit, $start);
        $data = array();
        if ($query->num_rows() > 0) {
            $data[] = array(
                'ID',
                'Tên',
                'Nội dung chi tiết',
                'Chức năng'
            );
            foreach ($query->result() as $row) {
                $editUrl = '<a href="' . action_url('mc2ads_advertiser/edit/' . $row->id) . '">Cập nhật</a>';
                $actions = '<div>' . $editUrl . '</div>';
                $data[] = array(
                    $row->id,
                    '<p style="font-weight:bold;">' . $row->name . '</p>',
                    '<div id="advertiser_des" style="width:650px">' . $row->description . '</div>',
                    $actions
                );
            }
        }
        return $data;
    }

}