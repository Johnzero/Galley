<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Home_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function get_cats () {

    $this->db->select("*")
             ->from("{$this->db->table_pre}extra_cat")
             ->where("{$this->db->table_pre}extra_cat.pid", 0);
    $q = $this->db->get();
    return $q->result();

  }


}
