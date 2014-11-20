CSC309 A3
=========
2014-11-27
Eugene Yue-Hin Cheung    g3cheunh
Ramaneek Gill            g3gillra


### AMI ID:
ami-fc3eaf94


### Location of files:
/var/www/html/estore/


### Instructions for starting Apache:

Apache is already installed, configured for the files and running! Just launch
an instance, configure it with a Custom TCP rule that allows anyone to connect
to port 80, then visit the instance's Public DNS or IP address in your local
browser. Visiting the root will bring you to the main page of the estore
(e.g. http://<AMI.Public.IP.Address>/) -- no need to add "index.php" or anything
afterwards.

To SSH into the instance, you'll need to use the username "ubuntu", since the
AMI is based on an Ubuntu instance.


### Browser details:

The store should work fine in the latest versions of Chrome or Firefox.


### Website documentation:

All relevant work is done in application/controllers/, models/, and views/.
The controllers found in application/controllers/ extend the MY_Controller
class, which can be found in application/core. By using this parent class, we
can make use of common functionality used for checking login status and loading
views with the header and footer templates. There are 3 controllers, which cover
the functionality of the store (manages the card products), users (customers and
admin), and the cart that is deals with customer's orders.

Email credentials are defined in application/controllers/cart.php, within the
`receipt` method.

Keeping track of customer and admin logged in states is handled by using
CodeIgniter sessions, along with the `isAdmin` and `isLoggedIn` methods in
MY_Controller.
