<?php

class i2tree_base_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    protected function paramPost($index = '', $xss_clean = FALSE, $default = FALSE) {
        if (!isset($_POST[$index])) {
            return $default;
        }
        return $this->input->post($index, $xss_clean);
    }

    protected function paramGet($index = '', $xss_clean = FALSE, $default = FALSE) {
        if (!isset($_GET[$index])) {
            return $default;
        }
        return $this->input->get($index, $xss_clean);
    }

}