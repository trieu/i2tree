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
        redirect('/contact/?id='.$id, 'refresh');
    }

   /**
     * @Decorated(themeName = "business")
     */
    public function index() {        
        $this->page_decorator->setPageTitle("Greengar Studios &#8212; Simple, Fun, Useful Mobile Apps");

        $data = array();
        $this->load->view("unit-tests/contact_view", $data);
    }

}
