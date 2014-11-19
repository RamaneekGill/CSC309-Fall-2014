<?php
class Order_Model extends CI_Model {

  function get($id) {
    $this->db->trans_start();
    $query = $this->db->get_where('orders', array('id' => $id));
    $this->db->trans_complete();

    return $query->row(0, 'Order');
  }

  function getAll() {
    $this->db->trans_start();
    $query = $this->db->get('orders');
    $this->db->trans_complete();

    return $query->result('Order');
  }

  function delete($id) {
    $this->db->trans_start();
    $result = $this->db->delete('orders', array('id' => $id));
    $this->db->trans_complete();

    return $result;
  }

  function delete_all() {
    $this->db->trans_start();
    $result = $this->db->empty_table('orders');
    $this->db->trans_complete();

    return $result;
  }

  function insert($order) {
    $this->db->trans_start();
    $result = $this->db->insert('orders',
                                array(
                                 'customer_id'       => $order->customer_id,
                                 'order_date'        => $order->order_date,
                                 'order_time'        => $order->order_time,
                                 'total'             => $order->total,
                                 'creditcard_number' => $order->creditcard_number,
                                 'creditcard_month'  => $order->creditcard_month,
                                 'creditcard_year'   => $order->creditcard_year
                                ));
    $this->db->trans_complete();

    return $result;
  }

}
