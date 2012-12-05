<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property mc2ads_model $mc2ads_model
 */
class mc2ads extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mc2ads_model');
    }

    /**
     * @Decorated
     */
    public function save() {
        $data = $this->mc2ads_model->save();
        //redirect('/contact/?id=' . $id, 'refresh');
        $this->load->view('mc2ads/save_success', $data);
    }

    /**
     * @Api
     */
    public function get_top_ads() {
        $status = array('status' => 'error', 'data' => array());
        $data = $this->mc2ads_model->get_top_ads();
        if (!empty($data)) {
            $status['status'] = 'ok';
            $status['data'] = $data;
            $status['base_url'] = base_url();
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

    /**
     * @Decorated
     */
    public function index() {
        $this->page_decorator->setPageTitle("mc2ads for Mobile Apps");

        $data = array();
        $this->load->view("mc2ads/new_ads_view", $data);
    }

    /**
     * @Decorated
     */
    public function list_ads() {
        $this->page_decorator->setPageTitle("mc2ads for Mobile Apps");
        $this->load->library('table');
        $data = array();
        $tmpl = array(
            'table_open' => '<table border="1" cellpadding="4" cellspacing="0">',
            'heading_row_start' => '<tr>',
            'heading_row_end' => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end' => '</th>',
            'row_start' => '<tr>',
            'row_end' => '</tr>',
            'cell_start' => '<td>',
            'cell_end' => '</td>',
            'row_alt_start' => '<tr>',
            'row_alt_end' => '</tr>',
            'cell_alt_start' => '<td>',
            'cell_alt_end' => '</td>',
            'table_close' => '</table>'
        );

        $this->table->set_template($tmpl);

        $data['students_table'] = $this->table->generate($this->contact_model->get());

        $this->load->view("unit-tests/students_view", $data);
    }

}
