<?php
class Product_Model extends CI_Model {

  public function getAll() {
    $this->db->trans_start();
    $query = $this->db->get('products');
    $this->db->trans_complete();

    return $query->result('Product');
  }

  public function get($id) {
    $this->db->trans_start();
    $query = $this->db->get_where('products', array('id' => $id));
    $this->db->trans_complete();

    return $query->row(0,'Product');
  }

  public function delete($id) {
    $this->db->trans_start();
    $result = $this->db->delete('products', array('id' => $id ));
    $this->db->trans_complete();

    return $result;
  }

  public function insert($product) {
    $this->db->trans_start();
    $result = $this->db->insert('products',
                                array('name' => $product->name,
                                'description' => $product->description,
                                'price' => $product->price,
                                'photo_url' => $product->photo_url));
    $this->db->trans_complete();

    return $result;
  }

  public function update($product) {
    $this->db->trans_start();
    $this->db->where('id', $product->id);
    $result = $this->db->update('products',
                                array('name' => $product->name,
                                'description' => $product->description,
                                'price' => $product->price));
    $this->db->trans_complete();

    return $result;
  }
}
