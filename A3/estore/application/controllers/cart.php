<?php
class Cart extends CI_Controller {

  function __construct() {
    parent::__construct();
  }

  function view() {
    $data['title'] = 'Shopping Cart';

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/cart.php');
    $this->load->view('templates/footer.php', $data);
  }

  function add($id) {
    // $this->load->model('order');
    // $product = $this->product_model->get($id);
    // $data['product'] = $product;

    // $data['title'] = $product->name;

    // $this->load->view('templates/header.php', $data);
    // $this->load->view('product/card.php', $data);
    // $this->load->view('templates/footer.php', $data);

    redirect('/cart', 'refresh');
  }