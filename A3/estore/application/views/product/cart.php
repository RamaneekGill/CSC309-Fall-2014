The shopping cart should show the total cost for the items selected.

For unfinalized orders, store shopping cart information on the server using a PHP session. Store information in the provided database only once orders are finalized.
All data provided by the user should be validated. Enforce the following validation rules:
Credit card number must have 16 digits
Expiration date should be a valid date (MM/YY)
The card should not have expired
All fields in the customer profile should not be null
Customer email most conform to a valid email format
Password most be at least 6 characters long
