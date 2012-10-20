<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class contact_model extends CI_Model {

    var $id = 0;
    var $name = "";
    var $email = "";
    var $school = "";
    var $year = 1;
    var $phone = "";
    var $position = "";

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

    function save() {

        $this->school = cleanUserInput($this->paramPost('school', TRUE, ""));
        $this->email = cleanUserInput($this->paramPost('email', '', ""));
        $this->year = intval($this->paramPost('year', TRUE, 1));
        $this->phone = cleanUserInput($this->paramPost('phone', TRUE, ""));

        $position = $_POST['position'];
        if (!empty($position)) {
            $N = count($position);
            for ($i = 0; $i < $N; $i++) {
                $this->position .= ($position[$i] . ',');
            }
        }

        //$this->position = cleanUserInput($this->paramPost('position', TRUE, ""));
        $this->name = cleanUserInput($this->paramPost('name', TRUE, ""));

        $table = 'students';
        $dbRet = $this->db->insert($table, $this);

        if (!$dbRet) {
            $errNo = $this->db->_error_number();
            $errMess = $this->db->_error_message();
            echo "Problem inserting to " . $table . ": " . $errMess . " (" . $errNo . ")";
            exit;
        }
        return $this->db->insert_id();
    }

    function get($filter = FALSE) {
        if ($filter) {
            $data = array();
        } else {
            $query = $this->db->query("SELECT * FROM students");

            if ($query->num_rows() > 0) {
                $data[] = array(
                    'ID',
                    'Position',
                    'Name',
                    'Email',
                    'School',
                    'Year',
                    'Phone',
                    'Actions'
                );
                foreach ($query->result() as $row) {


                    $email = urlencode($row->email);
                    //anchor(site_url('contact/edit/'. $row->id), 'Edit') .'<br>'
                    $googleUrl = '<a target="_blank" href="https://www.google.com.vn/search?q=' . $email. '">Google</a>';
                    $actions = '<div>' .$googleUrl . '<br><a target="_blank" href="mailto:' . $row->email . '">Email</a></div>';

                    $data[] = array(
                        $row->id,
                        $row->position,
                        $row->name,
                        $row->email,
                        $row->school,
                        $row->year == 0 ? 'Graduated' : $row->year,
                        $row->phone,
                        $actions
                    );
                }
            }
            return $data;
        }
        return $data;
    }

}