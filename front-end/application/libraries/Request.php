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

    public function getUploadedFileUrl($field_name, $newFileName, $uploadedFolder = './uploads/', $options = array()) {
        $allowedExts = array('jpg', 'jpeg', 'gif', 'png');
        $allowedFileSize = 500000;
        //	var_dump ( in_array(end(explode('.',$_FILES["$field_name"]["name"]) ), $allowedExts));
        // 	var_dump($_FILES);exit;

        $extension = strtolower(end(explode(".", $_FILES["$field_name"]["name"])));
        $results = array('error' => FALSE);

        if ((($_FILES["$field_name"]["type"] == "image/gif")
                || ($_FILES["$field_name"]["type"] == "image/jpeg")
                || ($_FILES["$field_name"]["type"] == "image/png")
                || ($_FILES["$field_name"]["type"] == "image/pjpeg"))
                && ($_FILES["$field_name"]["size"] < $allowedFileSize)
                && in_array($extension, $allowedExts)) {
            if ($_FILES["$field_name"]["error"] > 0) {
                $results['error'] = "Return Code: " . $_FILES["file"]["error"];
            } else {
                $relative_path = $uploadedFolder . $newFileName . '.' . $extension;
                move_uploaded_file($_FILES["$field_name"]["tmp_name"], $relative_path);
                $results["$field_name"] = $relative_path;
                $results['extension'] = $extension;
            }
        } else {
            $results['error'] = $_FILES["$field_name"]["name"] . " is an invalid file";
        }
        return $results;
    }

    public function getUploadedImageWithThumb($field_name, $newFileName, $newThumbFileName, $uploadedFolder = './uploads/', $options = array()) {
        $results = $this->getUploadedFileUrl($field_name, $newFileName, $uploadedFolder, $options);
        //var_dump($results);exit;
        if ( ! $results['error'] ) {
            $config['image_library'] = 'gd2';
            $config['source_image'] = $uploadedFolder . $newFileName . '.' . $results['extension'];
            $config['new_image'] = $uploadedFolder . $newThumbFileName . '.' . $results['extension'];
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 75;
            $config['height'] = 75;

            $this->CI->load->library('image_lib', $config);

            $this->CI->image_lib->resize();
            $results["$field_name" . '-thumb'] = $config['new_image'];
        }
        return $results;
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
