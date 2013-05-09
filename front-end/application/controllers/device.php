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
    public function notify_all() {
        $status = array('status' => 'ok', 'data' => array());
        $this->user_device_id_model->send_push_msg_to_all();
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
	

    public function notify_to_device() { 
        $registration_ids = array();
        $debug = isset($_GET['debug']);
        if ($debug) {            
            //trieu's Droid 1
            $registration_ids[] = 'APA91bHrToGD4LUnfBAHPtY5iKEzwurRzvYR8MAbFok0I1dVM9REh9Q8Ac5ew2eHdvKznVgIbElrozaiaIAgBXZ7WTWNPvzPobAad5r1xMmo4s71c8C-mbGU5mcxTzq57pmo_rDtw028';
            $this->user_device_id_model->notify_to_device($registration_ids);  
        } else if(isset($_POST['device_tokens'])) {            
            $device_tokens = explode('&&&', $_POST['device_tokens']);
            foreach ($device_tokens as $key => $device_token) {
                if( trim($device_token) != '' ){
                    $registration_ids = array();
                    $registration_ids[] = $device_token;
                    echo $device_token . ' OK ';
                    $this->user_device_id_model->notify_to_device($registration_ids);
                }
            }
        }
              
    }

    /**
     * @Decorated
     * @Secured(role = "administrator")
     */
    public function manage() {        
        $this->page_decorator->setPageTitle("Manage Devices");
        $data = array();
        $data['registered_devices'] =  $this->user_device_id_model->get_all();
        $this->load->view("mc2ads/gcm_view", $data);
    }

}
