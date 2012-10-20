<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Request $request
 * @property Dropbox $dropbox
 * @property js_data_model $js_data_model
 * @property search_engine_model $search_engine_model
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
        $this->store_user_info();
        redirect('cloud_storage/check_status');
    }

    public function check_status() {
        if ($this->session->userdata('oauth_token') != '' && $this->session->userdata('oauth_token_secret') != '') {
            echo '<html><head></head><body><script>window.close();</script></body><html>';
        } else {
            if ($this->input->get('web_login') === 'true') {
                redirect('cloud_storage/request_dropbox');
            }
            echo 'false';
        }
    }

    private function store_user_info() {
        $params = array();
        $params['key'] = $this->config->item('dropbox_key');
        $params['secret'] = $this->config->item('dropbox_secret');
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));

        $this->load->library('dropbox', $params);

        $dbobj = $this->dropbox->account();
        $this->session->set_userdata('display_name', $dbobj->display_name);
        $this->session->set_userdata('email', $dbobj->email);
        $this->session->set_userdata('uid', $dbobj->uid);
    }

    public function test_dropbox() {
        $params = array();
        $params['key'] = $this->config->item('dropbox_key');
        $params['secret'] = $this->config->item('dropbox_secret');
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));

        $this->load->library('dropbox', $params);

        $dbobj = $this->dropbox->account();
        echo json_encode($dbobj);
        exit;
//        $dbobj = $this->dropbox->metadata('/Photos',array());
//        var_dump($dbobj);

        $filepath = 'uploads/imagination.jpg';
        $dbobj = $this->dropbox->put('Public/imagination.jpg', array('file' => $filepath));
        var_dump($dbobj);
        echo '<br>' . $filepath . ': ' . filesize($filepath) . ' bytes';
    }

    private function init_dropbox_client() {
        $params = array();
        $params['key'] = $this->config->item('dropbox_key');
        $params['secret'] = $this->config->item('dropbox_secret');
        $params['access'] = array('oauth_token' => urlencode($this->session->userdata('oauth_token')),
            'oauth_token_secret' => urlencode($this->session->userdata('oauth_token_secret')));
        $this->load->library('dropbox', $params);
    }

    public function add_image_node() {
        $this->init_dropbox_client();

        $name = $this->input->post('name');
        $data = array();
        $data['album_name'] = $this->input->post('title');
        $data['album_des'] = $this->input->post('keywords');
        $data['body'] = $this->input->post('html');


        $text = $this->load->view('tree_tpl_nodes/image_node', $data, TRUE);

        $path = 'i2tree/image-gallery/' . $this->js_data_model->getId() . '-' . $name . '.html';
        $dbobj = $this->dropbox->put('Public/' . $path, array('text' => $text));

        $uid = $this->session->userdata('uid');
        $published_url = "http://dl.dropbox.com/u/$uid/" . $path;
        echo $published_url;
    }

    public function add_info_node() {
        $this->load->model('search_engine_model');
        $this->init_dropbox_client();

        $name = $this->input->post('name');
        $data = array();
        $data['title'] = $this->input->post('title');
        $data['keywords'] = $this->input->post('keywords');
        $data['body'] = $this->input->post('html');

        $text = $this->load->view('tree_tpl_nodes/info_node', $data, TRUE);

        $path = 'i2tree/' . $this->js_data_model->getId() . '-' . $name . '.html';
        $uid = $this->session->userdata('uid');
        $published_url = "http://dl.dropbox.com/u/$uid/" . $path;

        $this->search_engine_model->index($data['title'], $data['body'], $published_url, $data['keywords'], $uid);
        $this->dropbox->put('Public/' . $path, array('text' => $text));

        echo $published_url;
    }

    public function test_search_index() {
        $this->load->library('request');
        $this->load->model('search_engine_model');


        $q = $this->request->param('q', TRUE, '');
        $uid = 4074962;
        $data['hits'] = $this->search_engine_model->searchDocsByContent($q, $uid);
        $this->load->view('tree_tpl_nodes/search_results_view', $data);
    }

    public function test_index() {
        $this->load->library('request');
        $this->load->model('search_engine_model');
        $this->init_dropbox_client();

        $data = array();
        $data['title'] = $this->request->param('title', TRUE, '');
        $data['keywords'] = $this->request->param('keywords', TRUE, '');
        $data['body'] = $this->request->param('html', TRUE, '');

        $uid = 4074962;
        $published_url = "https://dl.dropbox.com/u/4074962/i2tree/134258291057-mobile-opportunity-the-shape-of-the-smartphone-and-mobile-data-markets.html";

        $this->search_engine_model->index($data['title'], $data['body'], $published_url, $data['keywords'], $uid);

        echo $published_url;
    }

}