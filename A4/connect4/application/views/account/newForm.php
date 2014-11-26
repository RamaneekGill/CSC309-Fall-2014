<div class='account-form'>
  <h1>New Account</h1>

  <?php
    echo form_open('account/createNew');

    echo form_label('Username');
    echo form_error('username');
    echo form_input('username',set_value('username'),"required");

    echo form_label('Password');
    echo form_error('password');
    echo form_password('password','',"id='pass1' required");

    echo form_label('Password Confirmation');
    echo form_error('passconf');
    echo form_password('passconf','',"id='pass2' required oninput='checkPassword();'");

    echo form_label('First name');
    echo form_error('first');
    echo form_input('first',set_value('first'),"required");

    echo form_label('Last name');
    echo form_error('last');
    echo form_input('last',set_value('last'),"required");

    echo form_label('Email');
    echo form_error('email');
    echo form_input('email',set_value('email'),"required");

    echo form_label('Captcha', 'Type the captcha code');
    echo img(array('src' => site_url('secureimagetest/securimage'), 'alt' => 'Captcha', 'id' => 'captcha'));
    echo form_input(array('name' => 'captcha'));
    echo form_error('captcha');
    echo "<a id='reload'>New captcha</a>";

    echo form_submit('submit', 'Register');
    echo form_close();
  ?>
</div>

<script>
  $(function(){
    $('#reload').click(function(){
      $('#captcha').attr('src', '<?php echo site_url("secureimagetest/securimage");?>');
    });
  });

  function checkPassword() {
    var p1 = $('#pass1');
    var p2 = $('#pass2');

    if (p1.val() == p2.val()) {
      p1.get(0).setCustomValidity("");  // All is well, clear error message
      return true;
    } else {
      p1.get(0).setCustomValidity("Passwords do not match");
      return false;
    }
  }
</script>
