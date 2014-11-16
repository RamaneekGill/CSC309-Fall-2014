<?php
class Cart extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $data['title'] = 'Shopping Cart';

    $data['cart_items'] = $this->session->userdata('session_cart');

    $this->load->view('templates/header.php', $data);
    $this->load->view('cart/cart.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function add($id) {
    $session_cart = $this->session->userdata('session_cart');


    $this->load->model('order_item');
    $order_item = new Order_Item();
    $order_item->product_id = $id;
    $order_item->quantity = 1;

    array_push($session_cart, "wat");
    $this->session->set_userdata('session_cart', $session_cart);

    redirect('/cart', 'refresh');
  }

  public function remove($id) {

  }

  public function checkout() {
    $data['title'] = 'Complete Purchase';

    $this->load->view('templates/header.php', $data);
    $this->load->view('cart/checkout.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function purchase() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('card_number', 'Credit card number', 'required|length[16]');

    $this->load->model('order_model');
  }
}
