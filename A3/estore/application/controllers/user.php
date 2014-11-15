<?php
class User extends CI_Controller {

  function __construct() {
    parent::__construct();
    // $this->load->model('customer_model');

    // $this->userLoggedIn = false;
    // $this->adminLoggedIn = false;
  }

  function login() {
    $data['title'] = 'Login / Register';

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/login.php');
    $this->load->view('templates/footer.php', $data);
  }

  function userlogin() {
    // $this->load->library('form_validation');
    // $this->form_validation->set_rules('username', 'Username', 'required|xss_clean|callback__username_check');
    // $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|callback__password_check');

    // if ($this->form_validation->run() == FALSE) {
    //     $this->load->view('logincenter');
    // }
    // else {
    //     $data['query'] = $this->db->get('users');
    //         if ($this->_is_admin($data['query']->name)) {
    //             $this->load->view('admin', $data);
    //         }
    //         else {
    //             echo "err";
    //         }
    // }
  }

  function admin() {
    $data['title'] = 'Admin Login';

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/adminlogin.php');
    $this->load->view('templates/footer.php', $data);
  }

  function adminlogin() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required|xss_clean|callback__username_check');
    $this->form_validation->set_rules('password', 'Password', 'required|xss_clean|callback__password_check');

    // if ($this->form_validation->run() == FALSE) {
    //     $this->load->view('logincenter');
    // }
    // else {
    //     $data['query'] = $this->db->get('users');
    //         if ($this->_is_admin($data['query']->name)) {
    //             $this->load->view('admin', $data);
    //         }
    //         else {
    //             echo "err";
    //         }
    // }
  }
