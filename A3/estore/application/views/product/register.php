<h2>
  Register
  <?php echo anchor('/', 'Back') ?>
</h2>

<?php
  echo form_open_multipart('/user/new_user');

  echo form_label('First name');
  echo form_error('first');
  echo form_input('first', set_value('first'), 'required');

  echo form_label('Last name');
  echo form_error('last');
  echo form_input('last', set_value('last'), 'required');

  echo form_label('Email');
  echo form_error('email');
  echo form_input('email', set_value('email'), 'required');

  echo form_label('Username');
  echo form_error('login');
  echo form_input('login', set_value('login'), 'required');

  echo form_label('Password');
  echo form_error('password');
  echo form_password('password', set_value('password'), 'required');

  echo form_label('Confirm Password');
  echo form_error('passconf');
  echo form_password('passconf', set_value('passconf'), 'required');
?>

<?php
  echo form_submit('submit', 'Register');
  echo form_close();
?>
