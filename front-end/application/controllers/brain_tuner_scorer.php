<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Dropbox $dropbox
 * @property br_scorer_model $br_scorer_model
 */
class brain_tuner_scorer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('br_scorer_model');
    }

    /**
     * @Api   
     */
    public function insert_scorer() {
        $status = array("status" => "error");
        if ($this->br_scorer_model->insert_scorer()) {
            $status['status'] = 'ok';
            $this->output->set_output(json_encode($status));
        }
        $this->output->set_output(json_encode($status));
    }

}