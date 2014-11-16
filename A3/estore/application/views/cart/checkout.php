<h2>Creditcard information:</h2>

<?php
  echo form_open_multipart('/cart/purchase');

  echo form_label('Creditcard number');
  echo form_error('card_number');
  echo form_input('card_number', set_value('card_number'), 'required');

  echo form_label('Creditcard number expiry date month (MM)');
  echo form_error('card_expiry_month');
  echo form_input('card_expiry_month', set_value('card_expiry_month'), 'required');

  echo form_label('Creditcard number expiry date year (YY)');
  echo form_error('card_expiry_year');
  echo form_input('card_expiry_year', set_value('card_expiry_year'), 'required');
?>

<?php
  echo form_submit('submit', 'Complete checkout');
  echo form_close();
?>

Checkout. This function should collect payment information (credit card number and expiry date) and
display a printable receipt (a simple example that shows how to print from JavaScript is available http://www.javascripter.net/faq/printing.htm).

Email receipt to customer. Documentation for sending email from CodeIgniter is available here (https://ellislab.com/codeigniter/user-guide/libraries/email.html).
To use this feature you will need access to a public SMTP server. One possibility is to use the SMTP server provided by Gmail (https://www.digitalocean.com/community/tutorials/how-to-use-google-s-smtp-server).
