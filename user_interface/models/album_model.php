<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");


class Album_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table_name = $this->db->table_pre."album";
  }
  
  /**
   * Get album by user id.
   * 
   * @param type $user_id
   * @return type 
   */
  public function fetch_by_user_id($user_id)
  {
    $this->db->select("{$this->table_name}.*, COUNT({$this->db->table_pre}image.id) as total_images, {$this->db->table_pre}user.email_address as user, {$this->db->table_pre}user.id as user_id")
             ->from($this->table_name)
             ->join("{$this->db->table_pre}image", "{$this->db->table_pre}image.album_id = {$this->db->table_pre}album.id", "left")
             ->join("{$this->db->table_pre}user", "{$this->db->table_pre}user.id = {$this->db->table_pre}album.created_by", "left")
             ->where("{$this->db->table_pre}album.created_by", $user_id)
             ->group_by("{$this->db->table_pre}album.id")
             ->order_by("updated_at", "desc"); 
    $q = $this->db->get();
    
    return $q->result();
  }
  
  /**
   * Get album by uuid.
   * 
   * @param type $uuid
   * @return type 
   */
  public function find_by_uuid($uuid)
  {
    $q = $this->db->get_where($this->table_name, array("uuid" => $uuid));
    return $q->row();
  }
  
  /**
   * Get all albums.
   * 
   * @return type 
   */
  public function fetch_all()
  {
    $this->db->select("{$this->db->table_pre}album.*, COUNT({$this->db->table_pre}image.id) as total_images, {$this->db->table_pre}user.email_address as user, {$this->db->table_pre}user.id as user_id")
             ->from($this->table_name)
             ->join("{$this->db->table_pre}image", "{$this->db->table_pre}image.album_id = {$this->db->table_pre}album.id", "left")
             ->join("{$this->db->table_pre}user", "{$this->db->table_pre}user.id = {$this->db->table_pre}album.created_by", "left")
             ->group_by("{$this->db->table_pre}album.id")
             ->order_by("updated_at", "desc"); 
    $q = $this->db->get();
    
    return $q->result();
  }
  
  /**
   * Paginate albums.
   * 
   * @param type $offset
   * @param type $limit
   * @return type 
   */
  public function paginate($limit = 10, $offset = 0)
  {
    $data = array();
    
    $this->db->select("{$this->db->table_pre}album.*, COUNT({$this->db->table_pre}image.id) as total_images, {$this->db->table_pre}user.email_address as user, {$this->db->table_pre}user.id as user_id")
             ->from($this->table_name)
             ->join("{$this->db->table_pre}image", "{$this->db->table_pre}image.album_id = {$this->db->table_pre}album.id", "left")
             ->join("{$this->db->table_pre}user", "{$this->db->table_pre}user.id = {$this->db->table_pre}album.created_by", "left")
             ->group_by("{$this->db->table_pre}album.id")
             ->limit($limit, $offset)
             ->order_by("updated_at", "desc"); 
    $q = $this->db->get();
    
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
   * Paginate albums by user id.
   * 
   * @param type $user_id
   * @param type $limit
   * @param type $offset
   * @return type 
   */
  public function paginate_by_user_id($user_id, $limit = 10, $offset = 0)
  {
    $data = array();
    
    $this->db->select("{$this->db->table_pre}album.*, COUNT({$this->db->table_pre}image.id) as total_images, {$this->db->table_pre}user.email_address as user, {$this->db->table_pre}user.id as user_id")
             ->from($this->table_name)
             ->join("{$this->db->table_pre}image", "{$this->db->table_pre}image.album_id = {$this->db->table_pre}album.id", "left")
             ->join("{$this->db->table_pre}user", "{$this->db->table_pre}user.id = {$this->db->table_pre}album.created_by", "left")
             ->group_by("{$this->db->table_pre}album.id")
             ->where("{$this->db->table_pre}album.created_by", $user_id)
             ->limit($limit, $offset)
             ->order_by("updated_at", "desc"); 
    $q = $this->db->get();
    
    if ($q->num_rows() > 0)
    {
      foreach ($q->result_array() as $row)
      {
        $data[] = $row;
      }
    }
    
    return $data;
  }
}
