<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Feed_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table_name = $this->db->table_pre."feed";
    $this->join_table_name = $this->db->table_pre."feed_album";
  }
  
  /**
   * Get feeds by user id.
   * 
   * @param type $user_id
   * @return type 
   */
  public function fetch_by_user_id($user_id)
  {
    $q = $this->db->from($this->table_name)
                  ->where("created_by", $user_id)
                  ->get();
    return $q->result();
  }
  
  /**
   * Get feed by uuid.
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
   * Get feed albums by feed id.
   * 
   * @param type $feed_id
   * @return type 
   */
  public function get_feed_albums($feed_id)
  {
    $q = $this->db->select("{$this->db->table_pre}feed_album.*, {$this->db->table_pre}album.name, {$this->db->table_pre}album.id as album_id")
                  ->from($this->join_table_name)
                  ->where("feed_id", $feed_id)
                  ->join("{$this->db->table_pre}album", "{$this->db->table_pre}album.id = {$this->db->table_pre}feed_album.album_id", "left")
                  ->order_by("order_num", "asc")
                  ->get();
    return $q->result();
  }
  
  /**
   * Delete feed_album join table records by feed id.
   * 
   * @param type $feed_id 
   */
  public function delete_albums_by_feed_id($feed_id)
  {
    $this->db->delete($this->join_table_name, array("feed_id" => $feed_id));
  }
  
  /**
   * Delete feed_album join tables records by album id.
   * 
   * @param type $album_id 
   */
  public function delete_albums_by_album_id($album_id)
  {
    $this->db->delete($this->join_table_name, array("album_id" => $album_id));
  }
  
  /**
   * Create feed_album join table record.
   * 
   * @param array $data
   * @return type 
   */
  public function create_feed_album(array $data)
  {
    $this->db->insert($this->join_table_name, $data);
    return $this->db->insert_id();
  }
}
