<?php
class Cart extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $data['title'] = 'Shopping Cart';

    $session_cart = $this->session->userdata('session_cart');
    $data['cart_items'] = array();

    if (is_array($session_cart)) {
      foreach ($session_cart as $index=>$item) {
        $order_item = unserialize($item);

        $this->load->model('product_model');
        $product = $this->product_model->get($order_item->product_id);

        $cart_item = array('name' => $product->name,
                           'quantity' => $order_item->quantity,
                           'id' => $index,
                           'price' => $product->price);

        array_push($data['cart_items'], $cart_item);
      }
    }

    $this->load->view('templates/header.php', $data);
    $this->load->view('cart/cart.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function add($id) {
    $session_cart = $this->session->userdata('session_cart');

    $this->load->model('order_item');
    $order_item = new Order_Item();
    $order_item->order_id = -1;
    $order_item->product_id = (int) $id;
    $order_item->quantity = 1;

    if (is_array($session_cart)) {
      array_push($session_cart, serialize($order_item));
    } else {
      $session_cart = array(serialize($order_item));
    }

    $this->session->set_userdata('session_cart', $session_cart);

    redirect('/cart', 'refresh');
  }

  public function remove($id) {
    $session_cart = $this->session->userdata('session_cart');
    unset($session_cart[(int) $id]);
    $this->session->set_userdata('session_cart', $session_cart);

    redirect('/cart', 'refresh');
  }

  public function clear() {
    $this->session->unset_userdata('session_cart');
    redirect('/cart', 'refresh');
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
