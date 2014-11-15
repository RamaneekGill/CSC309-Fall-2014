<?php
class ShoppingCart extends CI_Controller {

  function view() {
    // $data['title'] = 'Shopping Cart';

    // $this->load->view('templates/header.php', $data);
    // $this->load->view('product/cart.php');
    // $this->load->view('templates/footer.php', $data);

    $data['title'] = 'Catalogue';

    $this->load->model('product_model');
    $products = $this->product_model->getAll();
    $data['products'] = $products;

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/list.php', $data);
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
