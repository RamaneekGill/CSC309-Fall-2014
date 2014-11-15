<?php
class Admin extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $data['title'] = 'Admin Login';

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/adminlogin.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function admin_login() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == TRUE) {
      $username = $this->input->get_post('username');
      $password = $this->input->get_post('password');

      if ($username == 'admin' && $password == 'admin') {
        $this->session->set_userdata('admin_logged_in', TRUE);

        redirect('/', 'refresh');
      }
    }

    $this->index();
  }

  public function logout() {
    $this->session->set_userdata('admin_logged_in', FALSE);

    redirect('/', 'refresh');
  }

  public function delete_data() {
    if ($this->isAdmin()) {
      $this->load->model('customer_model');
      $this->customer_model->delete_all();

      $this->load->model('order_model');
      $this->order_model->delete_all();
    }

    redirect('/', 'refresh');
  }
}
