<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property js_data_model $js_data_model
 */
class crawler_api extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('js_data_model');
    }

    function index() {
        redirect('unit-tests/crawler_api/search?q="khoa học máy tính"');
    }

    /**
     * @Decorated
     */
    public function view() {
        $id = $this->input->get('id', TRUE);
        $data = array('id' => $id);
        $this->load->view('unit-tests/crawler_data_view', $data);
    }

    /**
     * @Decorated
     */
    public function search() {
        $q = $this->input->get('q', TRUE);
        $data = array('hits' => $this->js_data_model->searchDocsByContent($q));
        $this->load->view('unit-tests/crawler_data_view', $data);
    }

    
    public function search_by_keywords() {
        $q = $this->input->get('q', TRUE);
        $data = array('hits' => $this->js_data_model->searchDocsByContent($q));
        echo $this->load->view('unit-tests/crawler_data_view', $data, true);
    }

    /**
     * @Api
     */
    public function get() {
        $id = $this->input->get('id', TRUE);
        $this->output->set_output($this->js_data_model->get($id));
    }

    /**
     * @Api   
     */
    public function post_structured_data() {
        $json_data = $this->input->get_post('json_data');
        $status = array("status" => "fail");
        if (is_string($json_data)) {
            if ($this->js_data_model->insert($json_data, 1, JS_STRUCTURED_DATA, '', FALSE)) {
                $status = array("status" => "ok");
            }
        }
        $this->output->set_output(json_encode($status));
    }

    /**
     * @Api   
     */
    public function post() {
        $content = $this->input->get_post('content');
        $url = $this->input->get_post('url');
        $title = $this->input->get_post('title');

        $status = array("status" => "fail");
        if (is_string($content)) {
            $dataObj = array('url' => $url, 'content' => $content, 'title' => $title);
            if ($this->js_data_model->insert($dataObj, 1, JS_TEXT_DATA, $content, TRUE, $url)) {
                $status = array("status" => "ok");
            }
        }
        $this->output->set_output(json_encode($status));
    }

}
