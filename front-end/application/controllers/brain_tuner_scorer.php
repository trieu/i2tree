<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Dropbox $dropbox
 * @property bt_scorer_model $bt_scorer_model
 * @property aes_key_model $aes_key_model
 */
class brain_tuner_scorer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('bt_scorer_model');
        $this->load->model('bt_global_scorer_model');
        $this->load->model('aes_key_model');
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
    public function get_aes_key() {
        $data = $this->aes_key_model->get_new_key();
        $this->output->set_output(json_encode($data));
    }

    /**
     * @Api
     */
    public function show_aes_key() {

        $aes_key = $this->aes_key_model->get_key($this->request->param('id'));
        echo aesEncrypt("a=1&b=2", $aes_key);
        $data = array("aes_key" => $aes_key);
        $this->output->set_output(json_encode($data));
    }

    public function test_decode_base64() {
        $data = 'b3M9QW5kcm9pZCZsb2NhdGlvbj0xMC43NSwxMDYuNjY3JmZpbmlzaF90aW1lPTE2LjY2NyZuYW1lPXRyaWV1IE5ndXllbiZjb2RlPTMxMmEwMGUxNjdmZDhmMzAwZDYyMzA0ZTA5NDI1OTM0YzY4NDI4MjUmb3NfdmVyc2lvbj0yLjI';
        parse_str(base64_decode($data), $rs);
        var_dump($rs);
        $this->output->set_output('');
    }

    /**
     * @Api   
     */
    public function insert_scorer() {
        $status = array("status" => "error", "id" => 0);
        $id = $this->bt_scorer_model->insert_scorer();
        if ($id > 0) {
            $status['status'] = 'ok';
            $status['id'] = $id;
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

    /**
     * @Api   
     */
    public function secure_insert_global_scorer() {
        $status = array("status" => "error", "id" => 0);
        $id = $this->bt_global_scorer_model->secure_insert_scorer();
        if ($id > 0) {
            $status['status'] = 'ok';
            $status['id'] = $id;
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

    /**
     * @Api   
     */
    public function insert_global_scorer() {
        $status = array("status" => "error", "id" => 0);
        $id = $this->bt_global_scorer_model->insert_scorer();
        if ($id > 0) {
            $status['status'] = 'ok';
            $status['id'] = $id;
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

    /**
     * @DecoratedForMobile   
     */
    public function view_global_scorer() {		
        $this->page_decorator->setPageTitle("Global Brain Tuner Scorer");
        $data = array();
        $data['scorers'] = $this->bt_global_scorer_model->get_top_scorers();
        $this->load->view("bt2/global_scorer_view", $data);
    }

    public function request_info() {
        $this->bt_scorer_model->getRequestInfo();
    }

    /**
     * @DecoratedForMobile 
     */
    public function get() {
        $data = array();
        $this->load->view("unit-tests/bt_scorer_view", $data);
    }

    /**
     * @Api   
     */
    public function get_last_ten_scorers() {
        $status = array("status" => "error", "data" => array());
        $data = $this->bt_scorer_model->get_last_ten_scorers();
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
    public function get_scorer_result() {
        $status = array("status" => "error", "data" => array());
        $data = $this->bt_scorer_model->get_scorer_result();
        if (!empty($data)) {
            $status['status'] = 'ok';
            $status['data'] = $data;
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

}
