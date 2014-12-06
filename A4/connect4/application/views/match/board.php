<h1>Game Area</h1>

<div id='game-board'>
  <h2>Board</h2>
  <div id='turn'>
    <?php
      if ($user->id == $turn)
        echo "Your turn";
      else
        echo $otherUser->login . "'s turn";
    ?>
  </div>
  <table>
    <thead>
      <tr>
        <?php
          for ($i = 0; $i < 7; $i++) {
            echo "<th class='drop' data-col='$i'>↓</th>";
          }
        ?>
      </tr>
    </thead>
    <tbody id='board-content'>
      <?php
        if (isset($board)) {
          foreach ($board as $row) {
            echo '<tr>';
            foreach ($row as $item) {
              if ($item == 1) {
                echo '<td><div class="piece-p1"></div></td>';
              } else if ($item == 2) {
                echo '<td><div class="piece-p2"></div></td>';
              } else {
                echo '<td></td>';
              }
            }
            echo '</tr>';
          }
        }
      ?>
    </tbody>
  </table>
</div>

<div id='game-chat'>
  <h2>Chat</h2>
  <div id='status'>
    <?php
      if ($status == "playing")
        echo "Playing against ";
      else
        echo "Waiting on ";
      echo $otherUser->first . " " . $otherUser->last . " (" . $otherUser->login . ")";
    ?>
  </div>

  <?php
    echo form_textarea(array('name' => 'conversation', 'readonly' => 'readonly'));

    echo form_open();
    echo form_input('msg');
    echo form_submit('Send', 'Send');
    echo form_close();
  ?>
</div>

<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
<script>
  var otherUser   = "<?= $otherUser->login ?>";
  var otherUserID = "<?= $otherUser->id ?>";
  var user        = "<?= $user->login ?>";
  var userID      = "<?= $user->id ?>"
  var matchUser1  = "<?= $matchUser1 ?>";
  var status      = "<?= $status ?>";
  var turn        = "<?= $turn ?>";

  $(function(){
    $('body').everyTime(1000, 'body_timer', function() {
      if (status == 'waiting') {
        $.getJSON('<?= base_url() ?>arcade/checkInvitation', function (data, text, jqZHR) {
          if (data && data.status == 'rejected') {
            alert("Sorry, your invitation to play was declined!");
            window.location.href = '<?= base_url() ?>arcade/index';
          }

          if (data && data.status == 'accepted') {
            status = 'playing';
            $('#status').html('Playing against ' + otherUser);
          }
        });
      }

      $.getJSON("<?= base_url() ?>board/getMsg", function (data, text, jqXHR) {
        if (data && data.status == 'success') {
          var conversation = $('[name=conversation]').val();
          var msg = data.message;
          if (msg.length > 0)
            $('[name=conversation]').val(conversation + "\n" + otherUser + ": " + msg);
        }
      });

      $.getJSON("<?= base_url() ?>board/getBoard", function (data, text, jqXHR) {
        if (data && data.status == 'success') {
          updateBoard(data.board);
          turn = data.turn;

          if (data.turn == userID)
            $('#turn').html('Your turn');
          else
            $('#turn').html(otherUser + "'s turn");

          if (data.winner !== -1) {
            winState(data.winner);
          }
        }
      });
    });

    $('.drop').click(function() {
      if (turn == userID) {
        var col = this.dataset.col;
        $.post("<?= base_url() ?>board/drop/" + col, function (data, text, jqXHR) {
          var data = JSON.parse(data);
          if (data && data.status == 'success') {
            updateBoard(data.board);

            if (data.winner !== -1) {
              winState(data.winner);
            }
          }
        });
      }
    });

    function winState(state) {
      // $('body').stopTime('body_timer');

      if (state === userID) {
        alert("You win!");
      } else if (state === otherUserID) {
        alert("You lost!");
      } else if (state === -2) {
        alert("Tie game!");
      }
    }

    function updateBoard(rows) {
      var $board = $('#board-content');
      $board.html('');
      for (var row = 0; row < rows.length; row++) {
        $board.append('<tr>');

        for (var col = 0; col < rows[row].length; col++) {
          var item = rows[row][col];
          if (item === 0) {
            $board.append('<td></td>')
          } else if (item === matchUser1) {
            $board.append('<td><div class="piece-p1"></div></td>')
          } else {
            $board.append('<td><div class="piece-p2"></div></td>')
          }
        }

        $board.append('</tr>');
      }
    }

    $('form').submit(function() {
      var $msg = $('[name=msg]');
      var msg = $msg.val();

      if (msg !== '') {
        var arguments = $(this).serialize();
        $.post("<?= base_url() ?>board/postMsg", arguments, function (data, text, jqXHR) {
          var conversation = $('[name=conversation]').val();
          $('[name=conversation]').val(conversation + "\n" + user + ": " + msg);
          $msg.val('');
        });
      }
      return false;
    });
  });
</script>
