<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Dropbox $dropbox
 * @property js_data_model $js_data_model
 */
class cloud_storage extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('js_data_model');
    }

    // Call this method first by visiting http://SITE_URL/example/request_dropbox
    public function request_dropbox() {
        $params = array();
        $params['key'] = $this->config->item('dropbox_key');
        $params['secret'] = $this->config->item('dropbox_secret');

        $this->load->library('dropbox', $params);
        $data = $this->dropbox->get_request_token(site_url("cloud_storage/access_dropbox"));
        $this->session->set_userdata('token_secret', $data['token_secret']);
        redirect($data['redirect']);
    }

    //This method should not be called directly, it will be called after 
    //the user approves your application and dropbox redirects to it
    public function access_dropbox() {
        $params = array();
        $params['key'] = $this->config->item('dropbox_key');
        $params['secret'] = $this->config->item('dropbox_secret');

        $this->load->library('dropbox', $params);

        $oauth = $this->dropbox->get_access_token($this->session->userdata('token_secret'));

        $this->session->set_userdata('oauth_token', $oauth['oauth_token']);
        $this->session->set_userdata('oauth_token_secret', $oauth['oauth_token_secret']);
        redirect('cloud_storage/check_status');
    }

    public function check_status() {
        if ($this->session->userdata('oauth_token') != '' && $this->session->userdata('oauth_token_secret') != '') {
            echo '<html><head></head><script>window.close();</script><body></body><html>';
        } else {
            if ($this->input->get('web_login') === 'true') {
                redirect('cloud_storage/request_dropbox');
            }
            echo 'false';
        }
    }

    //Once your application is approved you can proceed to load the library
    //with the access token data stored in the session. If you see your account
    //information printed out then you have successfully authenticated with
    //dropbox and can use the library to interact with your account.
    public function test_dropbox() {
        $params = array();
        $params['key'] = $this->config->item('dropbox_key');
        $params['secret'] = $this->config->item('dropbox_secret');
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));

        $this->load->library('dropbox', $params);

//        $dbobj = $this->dropbox->account();
//        var_dump($dbobj);
//        $dbobj = $this->dropbox->metadata('/Photos',array());
//        var_dump($dbobj);

        $filepath = 'uploads/imagination.jpg';
        $dbobj = $this->dropbox->put('Public/imagination.jpg', array('file' => $filepath));
        var_dump($dbobj);
        echo '<br>' . $filepath . ': ' . filesize($filepath) . ' bytes';
    }

    public function add_info_node() {
        $params = array();
        $params['key'] = $this->config->item('dropbox_key');
        $params['secret'] = $this->config->item('dropbox_secret');
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));
        $this->load->library('dropbox', $params);
        $text = $this->input->post('text');
        $name = $this->input->post('name');
        $path = 'Public/' . $this->js_data_model->getId() . '-' . $name . '.html';
        $dbobj = $this->dropbox->put($path, array('text' => $text));
        var_dump($dbobj);
    }

}

/* End of file example.php */
/* Location: ./application/controllers/welcome.php */