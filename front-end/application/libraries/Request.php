<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * HTTP request info : params, IP, GeoIpLocation
 */
class Request {

    protected $CI;

    /**
     * __construct
     *
     * @return void
     * @author Trieu Nguyen
     * */
    public function __construct() {
        $this->CI = & get_instance();
    }

    public function paramPost($index = '', $xss_clean = FALSE, $default = FALSE) {
        if (!isset($_POST[$index])) {
            return $default;
        }
        return $this->CI->input->post($index, $xss_clean);
    }

    public function paramGet($index = '', $xss_clean = FALSE, $default = FALSE) {
        if (!isset($_GET[$index])) {
            return $default;
        }
        return $this->CI->input->get($index, $xss_clean);
    }

    public function param($index = '', $xss_clean = FALSE, $default = FALSE) {
        if (isset($_GET[$index])) {
            return $this->CI->input->get($index, $xss_clean);
        } else if (isset($_POST[$index])) {
            return $this->CI->input->post($index, $xss_clean);
        }
        return $default;
    }

    public function getIP() {
        $ip = "UNKNOWN";
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
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

    /**
     * get IP Information from request
     * @return JSONObject
     */
    public function getLocationInfo() {
        $this->CI->load->library('curl');
        $json = json_decode($this->CI->curl->simple_get('http://freegeoip.net/json/' . $this->getIP()));
        return $json;
    }

}
