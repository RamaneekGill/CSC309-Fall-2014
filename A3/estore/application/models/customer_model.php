<?php
class Customer_Model extends CI_Model {

  function get_id($id) {
    $query = $this->db->get_where('customers', array('id' => $id));
    return $query->row(0, 'Customer');
  }

  function get($login, $password) {
    $query = $this->db->get_where('customers', array('login' => $login, 'password' => $password));
    return $query->row(0, 'Customer');
  }

  function delete($id) {
    return $this->db->delete('customers', array('id' => $id ));
  }

  function delete_all() {
    return $this->db->empty_table('customers');
  }

  function insert($customer) {
    return $this->db->insert('customers',
                             array('first' => $customer->first,
                                   'last' => $customer->last,
                                   'login' => $customer->login,
                                   'password' => $customer->password,
                                   'email' => $customer->email));
  }
}
