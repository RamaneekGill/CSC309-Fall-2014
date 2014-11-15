<?php
class Order_Model extends CI_Model {

  function getAll() {
    $query = $this->db->get('orders');
    return $query->result('Order');
  }

  function delete($id) {
    return $this->db->delete('orders', array('id' => $id ));
  }

  function delete_all() {
    return $this->db->empty_table('orders');
  }

  function insert($order) {
    return $this->db->insert('orders',
                             array('customer_id' => $order->customer_id,
                                   'order_date' => $order->order_date,
                                   'order_time' => $order->order_time,
                                   'total' => $order->total,
                                   'creditcard_number' => $order->creditcard_number,
                                   'creditcard_month' => $order->creditcard_month,
                                   'creditcard_year' => $order->creditcard_year));
  }
}
