<h2>
  Login
  <?php echo anchor('/catalogue', 'Back') ?>
</h2>

<?php
  echo form_open_multipart('/user/userlogin');

  echo form_label('Username');
  echo form_error('username');
  echo form_input('username',set_value('username'),"required");

  echo form_label('Password');
  echo form_error('password');
  echo form_password('description',set_value('password'),"required");
?>

<?php
  echo form_submit('submit', 'Login');
  echo form_close();
?>

<h2>
  Register
</h2>

<?php
  echo form_open_multipart('/user/userregister');

  echo form_label('Username');
  echo form_error('username');
  echo form_input('username',set_value('username'),"required");

  echo form_label('Password');
  echo form_error('password');
  echo form_password('description',set_value('password'),"required");
?>

<?php
  echo form_submit('submit', 'Login');
  echo form_close();
?>