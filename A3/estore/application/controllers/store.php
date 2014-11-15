<?php
class Store extends MY_Controller {

  public function __construct() {
    parent::__construct();

    $config['upload_path'] = './images/product/';
    $config['allowed_types'] = 'gif|jpg|png';

    $this->is_admin = false;

    $this->load->library('upload', $config);
    $this->load->library('session');
  }

  public function index() {
    $data['title'] = 'Catalogue';

    $this->load->model('product_model');
    $products = $this->product_model->getAll();
    $data['products'] = $products;

    $data['logged_in'] = $this->isLoggedIn();
    $data['is_admin'] = $this->isAdmin();
    if ($this->isAdmin()) {
      $this->load->model('order_model');
      $orders = $this->order_model->getAll();
      $data['orders'] = $orders;
    }

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/list.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function add() {
    $data['title'] = 'Add new card';

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/new.php');
    $this->load->view('templates/footer.php', $data);
  }

  public function create() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name','Name','required|is_unique[products.name]');
    $this->form_validation->set_rules('description','Description','required');
    $this->form_validation->set_rules('price','Price','required');

    $fileUploadSuccess = $this->upload->do_upload();

    if ($this->form_validation->run() == true && $fileUploadSuccess) {
      $this->load->model('product_model');

      $product = new Product();
      $product->name = $this->input->get_post('name');
      $product->description = $this->input->get_post('description');
      $product->price = $this->input->get_post('price');

      $data = $this->upload->data();
      $product->photo_url = $data['file_name'];

      $this->product_model->insert($product);

      // Then we redirect to the index page again
      redirect('/', 'refresh');
    } else {
      if (!$fileUploadSuccess) {
        $data['fileerror'] = $this->upload->display_errors();

        $this->load->view('templates/header.php', $data);
        $this->load->view('product/new.php');
        $this->load->view('templates/footer.php', $data);
        return;
      }

      $this->load->view('templates/header.php', $data);
      $this->load->view('product/new.php');
      $this->load->view('templates/footer.php', $data);
    }
  }

  public function edit($id) {
    $this->load->model('product_model');
    $product = $this->product_model->get($id);
    $data['product'] = $product;

    $data['title'] = 'Edit ' . $product->name;

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/edit.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  public function update($id) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name','Name','required');
    $this->form_validation->set_rules('description','Description','required');
    $this->form_validation->set_rules('price','Price','required');

    if ($this->form_validation->run() == true) {
      $product = new Product();
      $product->id = $id;
      $product->name = $this->input->get_post('name');
      $product->description = $this->input->get_post('description');
      $product->price = $this->input->get_post('price');

      $this->load->model('product_model');
      $this->product_model->update($product);

      // Then we redirect to the index page again
      redirect('/', 'refresh');
    } else {
      $product = new Product();
      $product->id = $id;
      $product->name = set_value('name');
      $product->description = set_value('description');
      $product->price = set_value('price');
      $data['product'] = $product;

      $this->load->view('templates/header.php', $data);
      $this->load->view('product/edit.php',$data);
      $this->load->view('templates/footer.php', $data);
    }
  }

  public function delete($id) {
    $this->load->model('product_model');

    if (isset($id))
      $this->product_model->delete($id);

    // Then we redirect to the index page again
    redirect('/', 'refresh');
  }
}
