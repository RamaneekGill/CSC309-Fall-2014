<?php
class Store extends CI_Controller {

  function __construct() {
    // Call the Controller constructor
    parent::__construct();

    $config['upload_path'] = './images/product/';
    $config['allowed_types'] = 'gif|jpg|png';
/*  $config['max_size'] = '100';
    $config['max_width'] = '1024';
    $config['max_height'] = '768';
*/

    $this->load->library('upload', $config);
  }

  function view() {
    $data['title'] = 'List';

    $this->load->model('product_model');
    $products = $this->product_model->getAll();
    $data['products'] = $products;

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/list.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  function add() {
    $data['title'] = 'Add new card';

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/new.php');
    $this->load->view('templates/footer.php', $data);
  }

  function create() {
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
      redirect('/view', 'refresh');
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

  function card($id) {
    $this->load->model('product_model');
    $product = $this->product_model->get($id);
    $data['product'] = $product;

    $data['title'] = $product->name;

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/card.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  function edit($id) {
    $this->load->model('product_model');
    $product = $this->product_model->get($id);
    $data['product'] = $product;

    $data['title'] = 'Edit ' . $product->name;

    $this->load->view('templates/header.php', $data);
    $this->load->view('product/edit.php', $data);
    $this->load->view('templates/footer.php', $data);
  }

  function update($id) {
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
      redirect('/view', 'refresh');
    } else {
      $product = new Product();
      $product->id = $id;
      $product->name = set_value('name');
      $product->description = set_value('description');
      $product->price = set_value('price');
      $data['product']=$product;

      $this->load->view('templates/header.php', $data);
      $this->load->view('product/edit.php',$data);
      $this->load->view('templates/footer.php', $data);
    }
  }

  function delete($id) {
    $this->load->model('product_model');

    if (isset($id))
      $this->product_model->delete($id);

    // Then we redirect to the index page again
    redirect('/view', 'refresh');
  }
}
?>
