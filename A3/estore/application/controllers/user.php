<?php
class User extends MY_Controller {

  public function index() {
    $this->loadView('Login', 'user/login.php');
  }

  public function login() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() === TRUE) {
      $this->load->model('customer_model');

      $username = $this->input->get_post('username');
      $password = $this->input->get_post('password');

      $user = $this->customer_model->get($username, $password);

      if ($user) {
        if ($username == 'admin') {
          $this->session->set_userdata('admin_logged_in', TRUE);
        } else {
          $userdata = array(
                     'username'    => $username,
                     'customer_id' => $customer->id,
                     'logged_in'   => TRUE
                    );
          $this->session->set_userdata($userdata);
        }

        redirect('/', 'refresh');
      }
    }

    $data['loginerror'] = 'Login error: incorrect credentials';
    $this->loadView('Login', 'user/login.php', $data);
  }

  public function logout() {
    if ($this->isAdmin()) {
      $this->session->set_userdata('admin_logged_in', FALSE);
    } else {
      $userdata = array(
                   'username'    => NULL,
                   'customer_id' => NULL,
                   'logged_in'   => FALSE
                  );
      $this->session->set_userdata($userdata);
    }

    redirect('/', 'refresh');
  }

  public function register() {
    $this->loadView('Register', 'user/register.php');
  }

  public function new_user() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('first', 'First name', 'required|max_length[24]');
    $this->form_validation->set_rules('last', 'Last name', 'required|max_length[24]');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[45]');
    $this->form_validation->set_rules('login','Username','required|is_unique[customers.login]|max_length[16]');
    $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[6]|max_length[16]');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');

    if ($this->form_validation->run() === TRUE) {
      $this->load->model('customer_model');

      $customer = new Customer();
      $customer->first    = $this->input->get_post('first');
      $customer->last     = $this->input->get_post('last');
      $customer->email    = $this->input->get_post('email');
      $customer->login    = $this->input->get_post('login');
      $customer->password = $this->input->get_post('password');

      $this->customer_model->insert($customer);

      redirect('/login', 'refresh');
    }

    $this->register();
  }

  public function delete_data() {
    if ($this->isAdmin()) {
      $this->load->model('customer_model');
      $this->customer_model->delete_all_customers();

      $this->load->model('order_model');
      $this->order_model->delete_all();
    }

    redirect('/', 'refresh');
  }

}
