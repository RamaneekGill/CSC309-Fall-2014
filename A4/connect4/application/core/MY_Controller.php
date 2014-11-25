<?php
class MY_Controller extends CI_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->library('session');
  }

  public function isAdmin() {
    return $this->session->userdata('admin_logged_in');
  }

  public function isLoggedIn() {
    return $this->session->userdata('logged_in');
  }

  public function loadView($title, $view, $data = NULL) {
    $data['title']      = $title;
    $data['isAdmin']    = $this->isAdmin();
    $data['isLoggedIn'] = $this->isLoggedIn();

    $this->load->view('templates/header.php', $data);
    $this->load->view($view, $data);
    $this->load->view('templates/footer.php', $data);
  }

}
