<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Dropbox $dropbox
 * @property info_node_model $info_node_model
 */
class info_node extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('info_node_model');
    }

    /**
     * @Api
     */
    public function index() {
        $status = array("status" => "error");
        $this->output->set_output(json_encode($status));
    }

    /**
     * @Api   
     */
    public function submit() {
        $status = array("status" => "error", "id" => 0);
        $id = $this->info_node_model->insert();
        if ($id > 0) {
            $this->load->library('curl');
            $this->curl->simple_get('http://50.57.180.237:8080/gcm-demo/sendAll');
            
            $status['status'] = 'ok';
            $status['id'] = $id;
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

    public function request_info() {
        $this->info_node_model->getRequestInfo();
    }

    /**
     * @Api   
     */
    public function get_last_ten_nodes() {
        $status = array("status" => "error", "data" => array());
        $data = $this->info_node_model->get_last_ten_nodes();
        if (!empty($data)) {
            $status['status'] = 'ok';
            $status['data'] = $data;
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

    /**
     * @Api   
     */
    public function get_categories() {
        $status = array("status" => "error", "data" => array());
        $data = $this->info_node_model->get_categories();
        if (!empty($data)) {
            $status['status'] = 'ok';
            $status['data'] = $data;
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

    /**
     * @Api   
     */
    public function get_nodes_result() {
        $status = array("status" => "error", "data" => array());
        $data = $this->info_node_model->get_nodes_result();
        if (!empty($data)) {
            $status['status'] = 'ok';
            $status['data'] = $data;
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

}
