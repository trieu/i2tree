<?php
require_once(dirname(__FILE__).'/annotations.php');
/**
 * Description of Secured
 *
 * @author Trieu Nguyen
 * @Target("method")
 */
class Secured extends Annotation {
    const ROLE_USER = "user";
    const ROLE_ADMIN = "administrator";
    const ROLE_OPERATOR = "operator";

    public $role = Secured::ROLE_USER;
    public $level;
}
?>
