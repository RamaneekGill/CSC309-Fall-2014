Edit shopping cart content's (change item quantity, delete items)

The shopping cart should show the total cost for the items selected.

For unfinalized orders, store shopping cart information on the server using a PHP session.
Store information in the provided database only once orders are finalized.
All data provided by the user should be validated. Enforce the following validation rules:
Credit card number must have 16 digits
Expiration date should be a valid date (MM/YY)
The card should not have expired
All fields in the customer profile should not be null
Customer email most conform to a valid email format
Password most be at least 6 characters long

Checkout. This function should collect payment information (credit card number and expiry date) and
display a printable receipt (a simple example that shows how to print from JavaScript is available http://www.javascripter.net/faq/printing.htm).

Email receipt to customer. Documentation for sending email from CodeIgniter is available here (https://ellislab.com/codeigniter/user-guide/libraries/email.html).
To use this feature you will need access to a public SMTP server. One possibility is to use the SMTP server provided by Gmail (https://www.digitalocean.com/community/tutorials/how-to-use-google-s-smtp-server).

<h2>Creditcard information:</h2>
Number:
Expiry date:

<button>Checkout</button>
