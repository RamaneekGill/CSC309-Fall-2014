<?php
class Customer_Model extends CI_Model {

  function get_id($id) {
    $this->db->trans_start();
    $query = $this->db->get_where('customers', array('id' => $id));
    $this->db->trans_complete();

    return $query->row(0, 'Customer');
  }

  function get($login, $password) {
    $this->db->trans_start();
    $query = $this->db->get_where('customers', array('login' => $login, 'password' => $password));
    $this->db->trans_complete();

    return $query->row(0, 'Customer');
  }

  function getAll() {
    $this->db->trans_start();
    $query = $this->db->get_where('customers', array('login !=' => 'admin'));
    $this->db->trans_complete();

    return $query->result('Customer');
  }

  function delete($id) {
    $this->db->trans_start();
    $result = $this->db->delete('customers', array('id' => $id));
    $this->db->trans_complete();

    return $result;
  }

  function delete_all() {
    $this->db->trans_start();
    $result = $this->db->empty_table('customers');
    $this->db->trans_complete();

    return $result;
  }

  function insert($customer) {
    $this->db->trans_start();
    $result = $this->db->insert('customers',
                                array('first' => $customer->first,
                                      'last' => $customer->last,
                                      'login' => $customer->login,
                                      'password' => $customer->password,
                                      'email' => $customer->email));
    $this->db->trans_complete();

    return $result;
  }
}
