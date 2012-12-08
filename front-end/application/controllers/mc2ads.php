<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Request $request
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
        $id = $this->request->param('id', TRUE, 0);
        $id = $this->mc2ads_model->save($id);

        if ($id > 0) {
            $data['status'] = 'save_ok';
        } else {
            $data['status'] = 'fail';
        }
        $this->load->view('mc2ads/success', $data);
    }

    /**
     * public
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
     * public
     * @Api
     */
    function update_view_count_ads($id) {
        $this->mc2ads_model->update_view_count_ads($id);
        exit(1);
    }

    /**
     * @Decorated
     * @Secured(role = "administrator")
     */
    public function index() {
        $this->page_decorator->setPageTitle("Nhập thông tin Ad mới");
        $data = array();
        $this->load->view("mc2ads/new_ads_view", $data);
    }

    /**
     * @Decorated
     * @Secured(role = "administrator")
     */
    public function edit($id) {
        $this->page_decorator->setPageTitle("Cập nhật thông tin Ad");

        $data = array();
        $data['ads'] = $this->mc2ads_model->edit($id);
        $this->load->view("mc2ads/edit_ads_view", $data);
    }

    /**
     * @Decorated
     * @Secured(role = "administrator")
     */
    public function delete($id) {
        $this->page_decorator->setPageTitle("Xóa thông tin Ad");
        $this->mc2ads_model->delete($id);
        if ($id > 0) {
            $data['status'] = 'save_ok';
            $this->mc2ads_model->delete($id);
        } else {
            $data['status'] = 'fail';
        }
        $this->load->view('mc2ads/success', $data);
    }

    /**
     * @Decorated
     * @Secured(role = "administrator")
     */
    public function manage() {
        $this->page_decorator->setPageTitle("Quảng lý Ads");
        $this->load->library('table');

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

        $this->output->set_output($this->table->generate($this->mc2ads_model->get_table_data()));
    }

}
