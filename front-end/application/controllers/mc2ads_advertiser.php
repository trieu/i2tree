<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Request $request
 * @property mc2ads_advertiser_model $mc2ads_advertiser_model
 */
class mc2ads_advertiser extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mc2ads_advertiser_model');
    }

    /**
     * @Decorated
     */
    public function save() {
        $id = $this->request->param('id', TRUE, 0);
        $this->mc2ads_advertiser_model->save($id);
        $data['status'] = 'save_ok';        
        $data['redirect_url'] = action_url('mc2ads_advertiser/manage/');
        $this->load->view('mc2ads/success', $data);
    }

    /**
     * public
     * @Api
     */
    public function get_advertisers() {
        $status = array('status' => 'error', 'data' => array());
        $data = $this->mc2ads_advertiser_model->get_advertisers();
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
     * @Secured(role = "administrator")
     */
    public function index() {
        redirect('mc2ads_advertiser/manage');
    }

    /**
     * @Decorated
     * @Secured(role = "administrator")
     */
    public function edit($id) {
        $this->page_decorator->setPageTitle("Cập nhật thông tin ");

        $data = array();
        $data['ads'] = $this->mc2ads_advertiser_model->edit($id);
        $this->load->view("mc2ads/edit_advertiser_info_view", $data);
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

        $html = '<style>#advertiser_des img{width:99%}</style>';
        $html .= $this->table->generate($this->mc2ads_advertiser_model->get_table_data());
        $this->output->set_output($html);
    }

}
