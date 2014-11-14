<h2>
  Admin Login
  <?php echo anchor('/catalogue', 'Back') ?>
</h2>

<?php
  echo form_open_multipart('/loginAdmin');

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
