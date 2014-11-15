<?php
class Cart extends MY_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $data['title'] = 'Shopping Cart';

    $this->load->view('templates/header.php', $data);
    $this->load->view('cart/cart.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function add($id) {
    // $this->load->model('order');
    // $product = $this->product_model->get($id);
    // $data['product'] = $product;

    // $data['title'] = $product->name;

    // $this->load->view('templates/header.php', $data);
    // $this->load->view('product/card.php', $data);
    // $this->load->view('templates/footer.php', $data);

    redirect('/cart', 'refresh');
  }

  public function checkout() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('card_number', 'Credit card number', 'required|length[16]');
  }
}
