<?php
class Order_Item_Model extends CI_Model {

  function getAll() {
    $this->db->trans_start();
    $query = $this->db->get('orders');
    $this->db->trans_complete();

    return $query->result('Order');
  }

  function delete($id) {
    $this->db->trans_start();
    $result = $this->db->delete('orders', array('id' => $id ));
    $this->db->trans_complete();

    return $result;
  }

  function insert($order) {
    $this->db->trans_start();
    $result= $this->db->insert('orders',
                               array('name' => $order->name,
                               'description' => $order->description,
                               'price' => $order->price,
                               'photo_url' => $order->photo_url));
    $this->db->trans_complete();

    return $result;
  }

  function update($order) {
    $this->db->trans_start();
    $this->db->where('id', $order->id);
    $result = $this->db->update('orders',
                                array('name' => $order->name,
                                'description' => $order->description,
                                'price' => $order->price));
    $this->db->trans_complete();

    return $result;
  }
}
