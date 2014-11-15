<?php
class User extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $data['title'] = 'Login';

    $this->load->view('templates/header.php', $data);
    $this->load->view('user/login.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function login() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == TRUE) {
      $this->load->model('customer_model');

      $username = $this->input->get_post('username');
      $password = $this->input->get_post('password');

      if ($this->customer_model->get($username, $password)) {
        $userdata = array(
                    'username'  => $username,
                    'logged_in' => TRUE
                   );

        $this->session->set_userdata($userdata);

        redirect('/', 'refresh');
      }
    }

    $this->index();
  }

  public function logout() {
    $userdata = array(
                'username'  => NULL,
                'logged_in' => FALSE
               );

    $this->session->set_userdata($userdata);

    redirect('/', 'refresh');
  }

  public function register() {
    $data['title'] = 'Register';

    $this->load->view('templates/header.php', $data);
    $this->load->view('user/register.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function new_user() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('first', 'First name', 'required|max_length[24]');
    $this->form_validation->set_rules('last', 'Last name', 'requiredmax_length[24]');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[45]');
    $this->form_validation->set_rules('login','Username','required|is_unique[customers.login]|max_length[16]');
    $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|min_length[6]|max_length[16]');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');

    if ($this->form_validation->run() == TRUE) {
      $this->load->model('customer_model');

      $customer = new Customer();
      $customer->first = $this->input->get_post('first');
      $customer->last = $this->input->get_post('last');
      $customer->email = $this->input->get_post('email');
      $customer->login = $this->input->get_post('login');
      $customer->password = $this->input->get_post('password');

      $this->customer_model->insert($customer);

      // Then we redirect to the index page again
      redirect('/login', 'refresh');
    }

    $this->register();
  }
}
