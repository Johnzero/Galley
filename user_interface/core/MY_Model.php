<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class MY_Model extends CI_Model
{
  public $table_name;

  public function __construct()
  {
    parent::__construct();
  }
  
  /**
   * Fetch all records.
   * 
   * @return type 
   */
  public function fetch_all()
  {
    $q = $this->db->get($this->table_name);
    return $q->result();
  }
  
  /**
   * Paginate results.
   * 
   * @param type $offset
   * @param type $limit
   * @return type 
   */
  public function paginate($limit = 10, $offset = 0)
  {
    $data = array();
    $this->db->limit($limit, $offset);
    $q = $this->db->get($this->table_name);
    
    if ($q->num_rows() > 0)
    {
      foreach ($q->result_array() as $row)
      {
        $data[] = $row;
      }
    }
    
    return $data;
  }
  
  /**
   * Find record by id.
   * 
   * @param type $id
   * @return type 
   */
  public function find_by_id($id)
  {
    $q = $this->db->get_where($this->table_name, array('id' => $id));
    return $q->row();
  }
  
  /**
   * Abstract record creation.
   * 
   * @param array $data
   * @return type 
   */
  public function create(array $data)
  {
    $this->db->insert($this->table_name, $data);
    return $this->db->insert_id();
  }
  
  /**
   * Abstract recort update.
   * 
   * @param array $data
   * @param type $id 
   */
  public function update(array $data, $id)
  {
    $this->db->update($this->table_name, $data, array('id' => $id));
  }
  
  /**
   * Abstract record deletion.
   * 
   * @param type $id 
   */
  public function delete($id)
  {
    $this->db->delete($this->table_name, array('id' => $id));
  }
  
  /**
   * Utiltiy method to create a UUID.
   * 
   * @return type 
   */
  protected function create_uuid()
  {
    $uuid_query = $this->db->query('SELECT UUID()');
    $uuid_rs = $uuid_query->result_array();
    return $uuid_rs[0]['UUID()'];
  }

}