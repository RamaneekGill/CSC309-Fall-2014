<?php
class Order_Model extends CI_Model {

  public function __construct() {
    $this->load->database();
  }

  function getAll() {
    $query = $this->db->get('orders');
    return $query->result('Order');
  }

  function delete($id) {
    return $this->db->delete('orders', array('id' => $id ));
  }

  function insert($order) {
    return $this->db->insert('orders',
                             array('name' => $order->name,
                             'description' => $order->description,
                             'price' => $order->price,
                             'photo_url' => $order->photo_url));
  }

  function update($order) {
    $this->db->where('id', $order->id);
    return $this->db->update('orders',
                             array('name' => $order->name,
                             'description' => $order->description,
                             'price' => $order->price));
  }
}
