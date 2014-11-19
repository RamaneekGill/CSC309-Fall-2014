<?php
class Admin extends MY_Controller {

  public function index() {
    $this->loadView('Admin Login', 'user/adminlogin.php');
  }

  public function admin_login() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() === TRUE) {
      $this->load->model('customer_model');
      $username = $this->input->get_post('username');
      $password = $this->input->get_post('password');

      if ($username == 'admin') {
        $admin = $this->customer_model->get($username, $password);
        if ($admin) {
          $this->session->set_userdata('admin_logged_in', TRUE);

          redirect('/', 'refresh');
        }
      }
    }

    $data['loginerror'] = 'Login error: incorrect credentials';
    $this->loadView('Admin Login', 'user/adminlogin.php', $data);
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
