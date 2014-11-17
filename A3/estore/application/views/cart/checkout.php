<h2>Creditcard information:</h2>

<?php
  echo form_open_multipart('/cart/purchase');

  echo form_label('Creditcard number');
  echo form_error('card_number');
  echo form_input('card_number', set_value('card_number'), 'required');

  echo form_label('Creditcard expiry date: month (MM)');
  echo form_error('card_expiry_month');
  echo form_input('card_expiry_month', set_value('card_expiry_month'), 'required');

  echo form_label('Creditcard expiry date: year (YY)');
  echo form_error('card_expiry_year');
  echo form_input('card_expiry_year', set_value('card_expiry_year'), 'required');
?>

<?php
  echo form_submit('submit', 'Complete checkout');
  echo form_close();
?>
