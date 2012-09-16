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

    protected function getIP() {
        $ip;
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
        else
            $ip = "UNKNOWN";
        return $ip;
    }

    /*
      {
      city: "Ho Chi Minh City",
      region_code: "20",
      region_name: "Ho Chi Minh",
      metrocode: "",
      zipcode: "",
      longitude: "106.667",
      latitude: "10.75",
      country_code: "VN",
      ip: "58.186.221.76",
      country_name: "Vietnam"
      }
     */

    function getRequestInfo() {
        $this->load->library('curl');
        // Simple call to remote URL
        $json = json_decode($this->curl->simple_get('http://freegeoip.net/json/' . $this->getIP()));

//        echo $json->latitude;
//        echo $json->longitude;
        return $json;
    }

}