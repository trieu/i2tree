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

    function save($id = 0) {

        $t = time();
        $uploadedFolder = './uploads/';
        $rs = $this->request->getUploadedImageWithThumb('image_ads', 'ads-img-' . $t, 'ads-img-' . $t, $uploadedFolder);
        //var_dump($rs);
        //exit;
        $this->title = $this->request->param('title', TRUE, '');
        $this->description = $this->request->param('description', TRUE, '');
        $this->image_url = $this->request->param('image_url', TRUE, '');
        if ($this->image_url != '') {
            //TODO
        }
        $this->image_url = $rs['image_ads'];

        $this->creation_time = $t;

        if ($id > 0) {
            $dbRet = $this->db->update(self::TABLE, $this, 'id = ' . $id);
        } else {
            $dbRet = $this->db->insert(self::TABLE, $this);
        }
        //var_dump($dbRet);
        if (!$dbRet) {
            $errNo = $this->db->_error_number();
            $errMess = $this->db->_error_message();
            echo "DbError: Problem Inserting to " . self::TABLE . ": " . $errMess . " (" . $errNo . ")";
            exit;
        }
        if ($id == 0) {
            $id = $this->db->insert_id();
        }
        if ($id > 0) {
            $this->load->model('user_device_id_model');
            $this->user_device_id_model->send_push_msg_to_all();
        }
        return $id;
    }

    function get_table_data($start = 0, $limit = 100) {
        $this->db->order_by("creation_time", "desc");
        $query = $this->db->get(self::TABLE, $limit, $start);
        $data = array();
        if ($query->num_rows() > 0) {
            $data[] = array(
                'ID',
                'Tiêu đề',
                'Nội dung chi tiết',
                'Hình',
                'Thời gian tạo',
                'Chức năng'
            );
            foreach ($query->result() as $row) {
                $editUrl = '<a href="' . action_url('mc2ads/edit/' . $row->id) . '">Cập nhật</a>';
                $actions = '<div>' . $editUrl . '<br><br><a href="' . action_url('mc2ads/delete/' . $row->id) . '">Xóa</a></div>';
                $img = '<img style="max-width:100px;max-height:100px;" src="' . base_url() . str_replace('./', '', $row->image_url) . '" />';
                $data[] = array(
                    $row->id,
                    $row->title,
                    $row->description,
                    $img,
                    date('d/m/Y', $row->creation_time),
                    $actions
                );
            }
        }
        return $data;
    }

    function update_view_count_ads($id) {
        $id = intval($id);
        $this->db->query('UPDATE ' . self::TABLE . ' SET view_count=view_count+1 WHERE id=' . $id);
    }

    function get_top_ads() {
        $this->db->order_by("creation_time", "desc");
        $query = $this->db->get(self::TABLE, 15);
        return $query->result();
    }

    public function edit($id) {
        $this->db->where('id', $id);
        $query = $this->db->get(self::TABLE);
        return $query->result();
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete(self::TABLE);
      
    }

}