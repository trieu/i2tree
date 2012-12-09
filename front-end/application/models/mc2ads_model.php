<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Request $request
 * @property CI_DB_active_record $db
 */
class mc2ads_model extends CI_Model {

    const TABLE = 'mc2ads';

    var $id;
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
        
        $this->creation_time = $t;
        $this->title = $this->request->param('title', TRUE, '');
        $this->description = $this->request->param('description', TRUE, '');
        $this->image_url = $this->request->param('image_url', TRUE, '');
        
        $rs = $this->request->getUploadedImageWithThumb('image_ads', 'ads-img-' . $t, 'ads-img-' . $t, $uploadedFolder);
        if(isset($rs['image_ads']) && $rs['image_ads'] != ''){
            $this->image_url = $rs['image_ads'];
        }
        if($this->image_url == ''){
            return 0;
        }

        if ($id > 0) {
            $obj = clone($this);
            unset($obj->id);
            unset($obj->view_count);            
            $dbRet = $this->db->update(self::TABLE, $obj, 'id = ' . $id);
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
           // $this->user_device_id_model->send_push_msg_to_all();
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
                'Số lần xem',
                'Chức năng'
            );
            foreach ($query->result() as $row) {
                $editUrl = '<a href="' . action_url('mc2ads/edit/' . $row->id) . '">Cập nhật</a>';
                $actions = '<div>' . $editUrl . '<br><br><a href="' . action_url('mc2ads/delete/' . $row->id) . '">Xóa</a></div>';
                $img = '<img style="max-width:100px;max-height:100px;" src="' . base_url() . str_replace('./', '', $row->image_url) . '" />';
                $data[] = array(
                    $row->id,
                    '<p style="text-align:center;font-weight:bold;">'.$row->title.'</p>',
                    '<p style="width:450px">'.$row->description.'</p>',
                    $img,
                    date('d/m/Y', $row->creation_time),
                    '<p style="text-align:center;font-weight:bold;">'.$row->view_count.'</p>',
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