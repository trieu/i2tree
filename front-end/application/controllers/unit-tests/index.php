<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class index extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * @Decorated
     * @Secured(role = "Operator")
     */
    public function test_role_operator() {
        $this->output->set_output('Operator');
    }

    /**
     * @Decorated
     * @Secured(role = "administrator")
     */
    public function test_role_administrator() {
        $this->output->set_output('Administrator');
    }

    /**
     * @Decorated
     * @Secured(role = "Administrator")
     */
    public function index() {
        if (ENVIRONMENT !== 'development') {
            return;
        }
        $controllers = array();
        $arr = $this->getDirectoryList(ApplicationHook::$CONTROLLERS_FOLDER_PATH . '/unit-tests/');
        foreach ($arr as $fileName) {
            $toks = explode(".", $fileName);
            if (count($toks) === 2 && $toks[1] === 'php' ) {
                $controllers[$toks[0]] = $toks[0];
            }
        }
        $data = array(
            "controllers" => $controllers
        );
        $this->load->view("unit-tests/list_view", $data);
    }

    private function getDirectoryList($directory) {
        $results = array();
        // create a handler for the directory
        $handler = opendir($directory);

        // open directory and walk through the filenames
        while ($file = readdir($handler)) {
            // if file isn't this directory or its parent, add it to the results
            if ($file != "." && $file != "..") {
                $results[] = $file;
            }
        }
        closedir($handler);
        return $results;
    }

}