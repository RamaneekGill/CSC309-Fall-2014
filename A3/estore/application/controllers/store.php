<?php
class Store extends MY_Controller {

  public function __construct() {
    parent::__construct();

    $config['upload_path']   = './images/product/';
    $config['allowed_types'] = 'gif|jpg|png';

    $this->load->library('upload', $config);
  }

  public function index() {
    $this->load->model('product_model');
    $products = $this->product_model->getAll();

    $data['products']  = $products;
    $data['logged_in'] = $this->isLoggedIn();
    $data['is_admin']  = $this->isAdmin();

    if ($this->isAdmin()) {
      $this->load->model('order_model');
      $data['orders'] = $this->order_model->getAll();
    }

    $this->loadView('Catalogue', 'product/list.php', $data);
  }

  public function add() {
    $this->loadView('Add new card', 'product/new.php');
  }

  public function create() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name','Name','required|is_unique[products.name]');
    $this->form_validation->set_rules('description','Description','required');
    $this->form_validation->set_rules('price','Price','required');

    $fileUploadSuccess = $this->upload->do_upload();

    if ($this->form_validation->run() === TRUE && $fileUploadSuccess) {
      $this->load->model('product_model');

      $product = new Product();
      $product->name        = $this->input->get_post('name');
      $product->description = $this->input->get_post('description');
      $product->price       = $this->input->get_post('price');

      $data = $this->upload->data();
      $product->photo_url = $data['file_name'];

      $this->product_model->insert($product);

      redirect('/', 'refresh');
    } else {
      if (!$fileUploadSuccess) {
        $data['fileerror'] = $this->upload->display_errors();
      }

      $this->loadView('Add new card', 'product/new.php', $data);
    }
  }

  public function edit($id) {
    $this->load->model('product_model');
    $product = $this->product_model->get($id);
    $data['product'] = $product;

    $this->loadView('Edit' . $product->name, 'product/edit.php', $data);
  }

  public function update($id) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name','Name','required');
    $this->form_validation->set_rules('description','Description','required');
    $this->form_validation->set_rules('price','Price','required');

    $product = new Product();
    $product->id = $id;

    if ($this->form_validation->run() == true) {
      $product->name        = $this->input->get_post('name');
      $product->description = $this->input->get_post('description');
      $product->price       = $this->input->get_post('price');

      $this->load->model('product_model');
      $this->product_model->update($product);

      redirect('/', 'refresh');
    } else {
      $product->name        = set_value('name');
      $product->description = set_value('description');
      $product->price       = set_value('price');
      $data['product'] = $product;

      $this->loadView('Edit' . $product->name, 'product/edit.php', $data);
    }
  }

  public function delete($id) {
    $this->load->model('product_model');

    if (isset($id)) {
      $this->product_model->delete($id);
    }

    redirect('/', 'refresh');
  }
}
