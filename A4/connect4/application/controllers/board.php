<?php
class Board extends MY_Controller {

  public function _remap($method, $params = array()) {
    // Enforce access control to protected functions
    if (!isset($_SESSION['user']))
      redirect('account/loginForm', 'refresh'); //Then we redirect to the index page again

    return call_user_func_array(array($this, $method), $params);
  }

  public function index() {
    $user = $_SESSION['user'];

    $this->load->model('user_model');
    $this->load->model('invite_model');
    $this->load->model('match_model');

    $user = $this->user_model->get($user->login);
    $invite = $this->invite_model->get($user->invite_id);

    if ($user->user_status_id == User::WAITING) {
      $invite    = $this->invite_model->get($user->invite_id);
      $otherUser = $this->user_model->getFromId($invite->user2_id);
    }
    else if ($user->user_status_id == User::PLAYING) {
      $match = $this->match_model->get($user->match_id);

      $state = array(
                 'turn' => $match->user1_id,
                 'board' => array(
                   array(0, 0, 0, 0, 0, 0, 0),
                   array(0, 0, 0, 0, 0, 0, 0),
                   array(0, 0, 0, 0, 0, 0, 0),
                   array(0, 0, 0, 0, 0, 0, 0),
                   array(0, 0, 0, 0, 0, 0, 0),
                   array(0, 0, 0, 0, 0, 0, 0)
                 ),
                 'winner' => -1
               );
      $this->match_model->updateBoardState($match->id, serialize($state));
      $data['turn']  = $state['turn'];
      $data['board'] = $state['board'];

      if ($match->user1_id == $user->id)
        $otherUser = $this->user_model->getFromId($match->user2_id);
      else
        $otherUser = $this->user_model->getFromId($match->user1_id);

      $data['matchUser1'] = $match->user1_id;
    }

    $data['user']       = $user;
    $data['otherUser']  = $otherUser;

    switch ($user->user_status_id) {
      case User::PLAYING:
        $data['status'] = 'playing';
        break;
      case User::WAITING:
        $data['status'] = 'waiting';
        break;
    }

    $this->loadView('Match with ' . $otherUser->login, 'match/board', $data);
  }

  public function goHome() {
    $user = $_SESSION['user'];
    $this->load->model('user_model');
    $this->load->model('match_model');

    $user = $this->user_model->get($user->login);
    $this->user_model->updateStatus($user->id, User::AVAILABLE);

    redirect('arcade/index', 'refresh');
  }

  public function drop($col) {
    $this->load->model('user_model');
    $this->load->model('match_model');
    $user = $_SESSION['user'];

    // start transactional mode
    $this->db->trans_begin();

    $user  = $this->user_model->get($user->login);
    $match = $this->match_model->getExclusive($user->match_id);
    $state = unserialize($match->board_state);

    if (!isset($state)) {
      $errormsg = 'Get board error';
      goto error;
    }

    if ($state['turn'] == $user->id) {
      $piece = $state['turn'] == $match->user1_id ? 1 : 2;
      $new_row = 0;

      for ($row = 5; $row >= 0; $row--) {
        if ($state['board'][$row][$col] === 0) {
          $new_row = $row;
          $state['board'][$row][$col] = $piece;
          break;
        }
      }

      $state['winner'] = $this->_checkWin($state['board'], $col, $new_row, $state['turn']);
      $state['turn']   = $match->user1_id == $user->id ? $match->user2_id : $match->user1_id;

      $this->match_model->updateBoardState($match->id, serialize($state));

      if ($this->db->trans_status() === FALSE) {
        $errormsg = "Transaction error";
        goto transactionerror;
      }

      // If all went well commit changes
      $this->db->trans_commit();

      echo json_encode(array('status' => 'success',
                             'board'  => $state['board'],
                             'turn'   => $state['turn'],
                             'winner' => $state['winner']));
      return;
    } else {
      $errormsg = 'Wrong turn';
      goto transactionerror;
    }

    transactionerror:
      $this->db->trans_rollback();

    error:
      echo json_encode(array('status' => 'failure', 'message' => $errormsg));
  }

  public function getBoard() {
    $user = $_SESSION['user'];
    $this->load->model('user_model');
    $this->load->model('match_model');

    $user = $this->user_model->get($user->login);
    if ($user->user_status_id != User::PLAYING) {
      $errormsg = "Not in PLAYING state";
      goto error;
    }

    // start transactional mode
    $this->db->trans_begin();

    $match = $this->match_model->getExclusive($user->match_id);

    if ($this->db->trans_status() === FALSE) {
      $errormsg = "Transaction error";
      goto transactionerror;
    }

    // if all went well commit changes
    $this->db->trans_commit();

    $state = unserialize($match->board_state);
    $board = $state['board'];
    $turn  = $state['turn'];

    echo json_encode(array('status' => 'success',
                           'board'  => $state['board'],
                           'turn'   => $state['turn'],
                           'winner' => $state['winner']));
    return;

    transactionerror:
      $this->db->trans_rollback();

    error:
      echo json_encode(array('status' => 'failure', 'message' => $errormsg));
  }

  private function _checkWin($board, $col, $row, $turn) {
    $user = $_SESSION['user'];
    $this->load->model('user_model');
    $this->load->model('match_model');

    $user  = $this->user_model->get($user->login);
    $match = $this->match_model->getExclusive($user->match_id);

    if ($this->_checkWinH($board, $row, $col) ||
        $this->_checkWinV($board, $row, $col)) {

      if ($turn === $match->user1_id) {
        return Match::U1WON;
      } else {
        return Match::U2WON;
      }
    }

    foreach ($board as $board_row) {
      // There's still an empty spot: keep giong
      if (in_array(0, $board_row))
        return Match::ACTIVE;
    }

    // No win and no more spots: tie
    return Match::TIE;
  }

  private function _checkWinH($board, $row, $col) {
    $piece = $board[$row][$col];
    $pieces = 0;

    // Count to the left
    for ($i = $col; $i >= 0; $i--) {
      if ($board[$row][$i] !== $piece) {
        break;
      }

      $pieces++;
    }

    // Count to the right
    for ($i = $col + 1; $i < 7; $i++) {
      if ($board[$row][$i] !== $piece) {
        break;
      }

      $pieces++;
    }

    return $pieces >= 4;
  }

  private function _checkWinV($board, $row, $col) {
    if ($row > 2) {
      return FALSE;
    }

    $piece = $board[$row][$col];

    // Count downwards
    for ($i = $row; $i < 6; $i++) {
      if ($board[$i][$col] !== $piece) {
        return FALSE;
      }
    }

    return TRUE;
  }

  public function postMsg() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('msg', 'Message', 'required');

    if ($this->form_validation->run() == TRUE) {
      $this->load->model('user_model');
      $this->load->model('match_model');

      $user = $_SESSION['user'];

      $user = $this->user_model->getExclusive($user->login);
      if ($user->user_status_id != User::PLAYING) {
        $errormsg = "Not in PLAYING state";
        goto error;
      }

      $match = $this->match_model->get($user->match_id);

      $msg = $this->input->post('msg');

      if ($match->user1_id == $user->id)  {
        $msg = $match->u1_msg == '' ? $msg : $match->u1_msg . "\n" . $msg;
        $this->match_model->updateMsgU1($match->id, $msg);
      }
      else {
        $msg = $match->u2_msg == '' ? $msg : $match->u2_msg . "\n" . $msg;
        $this->match_model->updateMsgU2($match->id, $msg);
      }

      echo json_encode(array('status' => 'success'));
      return;
    }

    $errormsg = "Missing argument";

    error:
      echo json_encode(array('status' => 'failure', 'message' => $errormsg));
  }

  public function getMsg() {
    $this->load->model('user_model');
    $this->load->model('match_model');

    $user = $_SESSION['user'];

    $user = $this->user_model->get($user->login);
    if ($user->user_status_id != User::PLAYING) {
      $errormsg = "Not in PLAYING state";
      goto error;
    }

    // start transactional mode
    $this->db->trans_begin();

    $match = $this->match_model->getExclusive($user->match_id);

    if ($match->user1_id == $user->id) {
    $msg = $match->u2_msg;
      $this->match_model->updateMsgU2($match->id,"");
    }
    else {
      $msg = $match->u1_msg;
      $this->match_model->updateMsgU1($match->id,"");
    }

    if ($this->db->trans_status() === FALSE) {
      $errormsg = "Transaction error";
      goto transactionerror;
    }

    // if all went well commit changes
    $this->db->trans_commit();

    echo json_encode(array('status' => 'success', 'message' => $msg));
    return;

    transactionerror:
      $this->db->trans_rollback();

    error:
      echo json_encode(array('status' => 'failure', 'message' => $errormsg));
  }
}
