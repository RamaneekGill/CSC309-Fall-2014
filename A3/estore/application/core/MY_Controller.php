<?php
class MY_Controller extends CI_Controller {
  var $data;

  public function __construct() {
    parent::__construct();

    $this->load->library('session');
  }

  public function isAdmin() {
    return $this->session->userdata('is_admin');
  }

  public function isLoggedIn() {
    return $this->session->userdata('logged_in');
  }
}