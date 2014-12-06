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

    $turn = $state['turn'];

    if ($turn == $user->id) {
      for ($row = 5; $row >= 0; $row--) {
        if ($state['board'][$row][$col] == 0) {
          $state['board'][$row][$col] = $turn;
          break;
        }
      }

      $state['winner'] = $this->_checkWin($state['board']);

      $state['turn'] = $match->user1_id == $user->id ? $match->user2_id : $match->user1_id;

      $this->match_model->updateBoardState($match->id, serialize($state));

      if ($this->db->trans_status() === FALSE) {
        $errormsg = "Transaction error";
        goto transactionerror;
      }

      // if all went well commit changes
      $this->db->trans_commit();

      echo json_encode(array('status' => 'success',
                             'board'  => $state['board'],
                             'turn'   => $state['turn'],
                             'winner' => $state['winner']));
      return;
    } else {
      $errormsg = 'Wrong turn';
      $this->db->trans_rollback();
      goto error;
    }

    transactionerror:
      $this->db->trans_rollback();

    error:
      echo json_encode(array('status' => 'failure', 'message' => $errormsg));
  }

  public function getBoard() {
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

  private function _checkWin($board) {
    $user = $_SESSION['user'];

    $this->load->model('user_model');
    $this->load->model('match_model');

    // MATCH::U1WIN;
    // MATCH::U2WIN;
    // MATCH::TIE;

    return Match::ACTIVE;
  }

  function _winning($board, $id, $cur, $d, $pieces) {
    if ($pieces == 4) {
      return TRUE;
    } else {
      $next = array('row' => $cur['row'] + $d['row'], 'col' => $cur['col'] + $d['col']);
      if ($board[$next['row']][$next['col']] && $board[$next['row']][$next['col']] == $id) {
        return $this->_winning($board, $id, $next, $d, $pieces + 1);
      } else {
        return FALSE;
      }
    }
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
