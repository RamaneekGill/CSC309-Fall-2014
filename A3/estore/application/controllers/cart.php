<?php
class Cart extends MY_Controller {

  public function index() {
    $session_cart = $this->session->userdata('session_cart');
    $data['cart_items'] = array();
    $cart_total = 0.0;

    if (is_array($session_cart)) {
      foreach ($session_cart as $index=>$item) {
        $order_item = unserialize($item);

        $this->load->model('product_model');
        $product = $this->product_model->get($order_item->product_id);

        $price = $order_item->quantity * $product->price;

        $cart_item = array(
                       'name'     => $product->name,
                       'quantity' => $order_item->quantity,
                       'id'       => $index,
                       'price'    => $price
                     );

        $cart_total += $price;

        array_push($data['cart_items'], $cart_item);
      }
    }

    $this->session->set_userdata('cart_total', $cart_total);
    $data['cart_total'] = $cart_total;

    $this->loadView('Shopping Cart', 'cart/cart.php', $data);
  }

  public function add($id) {
    $session_cart = $this->session->userdata('session_cart');

    // Check if already in cart
    if (is_array($session_cart)) {
      foreach ($session_cart as $index=>$item) {
        $order_item = unserialize($item);

        if ($order_item->product_id == (int) $id) {
          $order_item->quantity += 1;
          $session_cart[$index] = serialize($order_item);

          $this->session->set_userdata('session_cart', $session_cart);

          redirect('/cart', 'refresh');
        }
      }
    }

    $order_item = new Order_Item();
    $order_item->order_id   = -1;
    $order_item->product_id = (int) $id;
    $order_item->quantity   = 1;

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

  public function update($id, $amount) {
    $session_cart = $this->session->userdata('session_cart');
    $order_item = unserialize($session_cart[(int) $id]);

    if ($order_item->quantity == 0 && $amount == -1) {
      redirect('/cart', 'refresh');
    }

    $order_item->quantity += (int) $amount;
    $session_cart[(int) $id] = serialize($order_item);

    $this->session->set_userdata('session_cart', $session_cart);

    redirect('/cart', 'refresh');
  }

  public function clear() {
    $this->session->unset_userdata('session_cart');
    redirect('/cart', 'refresh');
  }

  public function checkout() {
    $this->loadView('Complete Purchase', 'cart/checkout.php');
  }

  public function purchase() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('card_number', 'Creditcard number', 'required|numeric|length[16]');
    $this->form_validation->set_rules('card_expiry_month', 'Creditcard expiry date (month)', 'required|numeric|length[2]');
    $this->form_validation->set_rules('card_expiry_year', 'Creditcard expiry date (year)', 'required|numeric|length[2]');

    if ($this->form_validation->run() === TRUE) {
      $card_number       = $this->input->get_post('card_number');
      $card_expiry_month = $this->input->get_post('card_expiry_month');
      $card_expiry_year  = $this->input->get_post('card_expiry_year');

      $this->load->model('order_model');

      $order = new Order();
      $order->customer_id       = $this->session->userdata('customer_id');
      $order->order_date        = date('Y-m-d');
      $order->order_time        = date('H:i:s');
      $order->total             = $this->session->userdata('cart_total');
      $order->creditcard_number = $card_number;
      $order->creditcard_month  = $card_expiry_month;
      $order->creditcard_year   = $card_expiry_year;

      $this->order_model->insert($order);

      $this->session->set_userdata('order', serialize($order));

      redirect("/cart/receipt/", 'refresh');
    } else {
      $this->loadView('Complete Purchase', 'cart/checkout.php');
    }
  }

  public function receipt() {
    $order = unserialize($this->session->userdata('order'));
    $data['order'] = $order;

    $session_cart = $this->session->userdata('session_cart');
    $data['cart_items'] = array();

    if (is_array($session_cart)) {
      foreach ($session_cart as $index=>$item) {
        $order_item = unserialize($item);

        $this->load->model('product_model');
        $product = $this->product_model->get($order_item->product_id);

        $price = $order_item->quantity * $product->price;

        $cart_item = array(
                       'name'     => $product->name,
                       'quantity' => $order_item->quantity,
                       'price'    => $price
                     );

        array_push($data['cart_items'], $cart_item);
      }
    }

    $this->loadView('Receipt', 'cart/receipt.php', $data);

    // $this->session->unset_userdata('session_cart');
    // $this->session->unset_userdata('order');
  }

}
