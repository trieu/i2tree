<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property user_device_id_model $user_device_id_model
 */
class device extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_device_id_model');
    }

    /**
     * @Api
     */
    public function register() {
        $status = array('status' => 'error', 'data' => array());
        $id = $this->user_device_id_model->register();
        if ($id > 0) {
            $status['status'] = 'ok';
        } else if ($id === 0) {
            $status['status'] = 'ok';
            $status['text'] = 'duplicated device token';
        }
        $this->output->set_output(json_encode($status));
    }

    /**
     * @Api
     */
    public function unregister() {
        $status = array('status' => 'error', 'data' => array());
        $data = $this->user_device_id_model->unregister();
        if (!empty($data)) {
            $status['status'] = 'ok';
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

    /**
     * @Api
     */
    public function notify() {
        $status = array('status' => 'ok', 'data' => array());
        $ids = array('1' => TRUE);
        $this->user_device_id_model->send_push_msg_to_all($ids);
        $this->output->set_output(json_encode($status));
    }

    /**
     * @Api
     */
    public function get_all() {
        $status = array('status' => 'error', 'data' => array());
        $data = $this->user_device_id_model->get_all();
        if (!empty($data)) {
            $status['status'] = 'ok';
            $status['data'] = $data;
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

}
