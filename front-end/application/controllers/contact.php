<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Dropbox $dropbox
 * @property contact_model $contact_model
 */
class contact extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contact_model');
    }

    public function save() {
        $id = $this->contact_model->save();
        redirect('/contact/?id=' . $id, 'refresh');
    }

    /**
     * @Decorated(themeName = "business")
     */
    public function index() {
        $this->page_decorator->setPageTitle("Greengar Studios &#8212; Simple, Fun, Useful Mobile Apps");

        $data = array();
        $this->load->view("unit-tests/contact_view", $data);
    }

    /**
     * @Decorated(themeName = "business")
     */
    public function students() {
        $this->page_decorator->setPageTitle("Greengar Studios &#8212; Simple, Fun, Useful Mobile Apps");
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
