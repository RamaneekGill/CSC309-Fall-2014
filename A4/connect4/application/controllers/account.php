<?php
class Account extends MY_Controller {

  public function _remap($method, $params = array()) {
    // Enforce access control to protected functions
    $protected = array('updatePasswordForm','updatePassword','index','logout');

    if (in_array($method,$protected) && !isset($_SESSION['user']))
    redirect('account/loginForm', 'refresh'); //Then we redirect to the index page again

    return call_user_func_array(array($this, $method), $params);
  }

  function loginForm() {
    $this->loadView('Login', 'account/loginForm');
  }

  function login() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->loadView('Login', 'account/loginForm');
    } else {
      $login = $this->input->post('username');
      $clearPassword = $this->input->post('password');

      $this->load->model('user_model');

      $user = $this->user_model->get($login);

      if (isset($user) && $user->comparePassword($clearPassword)) {
        $_SESSION['user'] = $user;
        $data['user'] = $user;

        $this->user_model->updateStatus($user->id, User::AVAILABLE);

        redirect('arcade/index', 'refresh'); //redirect to the main application page
      } else {
        $data['errorMsg']='Incorrect username or password!';
        $this->loadView('Login', 'account/loginForm', $data);
      }
    }
  }

  function logout() {
    $user = $_SESSION['user'];
    $this->load->model('user_model');
    $this->user_model->updateStatus($user->id, User::OFFLINE);
    session_destroy();
    redirect('account/index', 'refresh'); //Then we redirect to the index page again
  }

  function newForm() {
    $this->load->helper('html');
    $this->loadView('Register', 'account/newForm');
  }

  function createNew() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.login]');
    $this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('first', 'First name', 'required');
    $this->form_validation->set_rules('last', 'Last name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]');
    $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|callback__check_captcha');

    if ($this->form_validation->run() === FALSE) {
      $this->loadView('Register', 'account/newForm');
    } else {
      $user = new User();

      $user->login = $this->input->post('username');
      $user->first = $this->input->post('first');
      $user->last = $this->input->post('last');
      $clearPassword = $this->input->post('password');
      $user->encryptPassword($clearPassword);
      $user->email = $this->input->post('email');

      $this->load->model('user_model');

      $error = $this->user_model->insert($user);

      $this->loadView('Login', 'account/loginForm');
    }
  }

  public function securimage() {
    $this->load->config('csecurimage');
    $active = $this->config->item('si_active');
    $allsettings = array_merge($this->config->item($active), $this->config->item('si_general'));

    $this->load->library('securimage/securimage');
    $img = new Securimage($allsettings);

    //$img->captcha_type = Securimage::SI_CAPTCHA_MATHEMATIC;

    $img->show('libraries/securimage/backgrounds/bg6.png');
  }

  public function _check_captcha() {
    $this->load->library('securimage/securimage');
    $securimage = new Securimage();

    if (!$securimage->check($this->input->post('captcha'))) {
      $this->form_validation->set_message('_check_captcha', 'The code you entered is invalid');
      return FALSE;
    } else {
      return TRUE;
    }
  }

  function updatePasswordForm() {
    $this->loadView('Update Password', 'account/updatePasswordForm');
  }

  function updatePassword() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('oldPassword', 'Old Password', 'required');
    $this->form_validation->set_rules('newPassword', 'New Password', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->loadView('Update Password', 'account/updatePasswordForm');
    } else {
      $user = $_SESSION['user'];

      $oldPassword = $this->input->post('oldPassword');
      $newPassword = $this->input->post('newPassword');

      if ($user->comparePassword($oldPassword)) {
        $user->encryptPassword($newPassword);
        $this->load->model('user_model');
        $this->user_model->updatePassword($user);
        redirect('arcade/index', 'refresh');
      } else {
        $data['errorMsg']='Incorrect password!';
        $this->loadView('Update Password', 'account/updatePasswordForm', $data);
      }
    }
  }

  function recoverPasswordForm() {
    $this->loadView('Recover Password', 'account/recoverPasswordForm');
  }

  function recoverPassword() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'email', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->load->view('account/recoverPasswordForm');
    } else {
      $email = $this->input->post('email');
      $this->load->model('user_model');
      $user = $this->user_model->getFromEmail($email);

      if (isset($user)) {
        $newPassword = $user->initPassword();
        $this->user_model->updatePassword($user);

        $this->load->library('email');

        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'eugycheung@gmail.com';
        $config['smtp_pass']    = 'eugy940101';
        $config['charset']      = 'utf-8';
        $config['newline']      = '\r\n';
        $config['mailtype']     = 'text'; // or html
        $config['validation']   = TRUE; // bool whether to validate email or not

        $this->email->initialize($config);

        $this->email->from('csc309Login@cs.toronto.edu', 'Login App');
        $this->email->to($user->email);

        $this->email->subject('Password recovery');
        $this->email->message('Your new password is $newPassword');

        $result = $this->email->send();

        //$data['errorMsg'] = $this->email->print_debugger();

        //$this->load->view('emailPage',$data);
        $this->load->view('account/emailPage');
      } else {
        $data['errorMsg']='No record exists for this email!';
        $this->load->view('account/recoverPasswordForm',$data);
      }
    }
  }

}
