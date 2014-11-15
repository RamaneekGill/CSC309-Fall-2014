<?php
class User extends MY_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->library('session');
  }

  public function index() {
    $data['title'] = 'Login';

    $data['logged_in'] = $this->isLoggedIn();

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/login.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function login() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == FALSE) {
      $data['title'] = 'Login';

      $data['logged_in'] = $this->isLoggedIn();

      $this->load->view('templates/header.php', $data);
      $this->load->view('product/login.php', $data);
      $this->load->view('templates/footer.php', $data);
    } else {
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
      } else {
        $data['title'] = 'Login';

        $data['logged_in'] = $this->isLoggedIn();

        $this->load->view('templates/header.php', $data);
        $this->load->view('product/login.php', $data);
        $this->load->view('templates/footer.php', $data);
      }
    }
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

    $data['logged_in'] = $this->isLoggedIn();

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/register.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function new_user() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('first', 'First name', 'required|max_length[24]');
    $this->form_validation->set_rules('last', 'Last name', 'requiredmax_length[24]');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_emailmax_length[45]');
    $this->form_validation->set_rules('login','Username','required|is_unique[customers.login]|max_length[16]');
    $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]|max_length[16]');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');

    if ($this->form_validation->run() == FALSE) {
      $data['title'] = 'Register';

      $data['logged_in'] = $this->isLoggedIn();

      $this->load->view('templates/header.php', $data);
      $this->load->view('product/register.php', $data);
      $this->load->view('templates/footer.php', $data);
    } else {
      $this->load->model('customer_model');

      $customer = new Customer();
      $customer->first = $this->input->get_post('first');
      $customer->last = $this->input->get_post('last');
      $customer->email = $this->input->get_post('email');
      $customer->login = $this->input->get_post('login');
      $customer->password = $this->input->get_post('password');

      $this->customer_model->insert($customer);

      // Then we redirect to the index page again
      redirect('/', 'refresh');
    }
  }

  public function admin() {
    $data['title'] = 'Admin Login';

    $data['logged_in'] = $this->isLoggedIn();

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/adminlogin.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function adminlogin() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

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
}
