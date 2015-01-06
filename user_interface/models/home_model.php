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

    public function fetch_all_news($id)
    {
        $this->db->from("{$this->db->table_pre}extra_news")
                 ->where("type",$id)
                 ->order_by("create_date", "desc");
        $q = $this->db->get();
        return $q->result();
    }

    public function paginate_news($id,$limit = 10, $offset = 0)
    {
        $data = array();

        $this->db->from("{$this->db->table_pre}extra_news")
        ->where("type",$id)
                 ->limit($limit, $offset)
                 ->order_by("create_date", "desc"); 
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

    public function get_news($id)
    {
        $this->db->select("*")
             ->from("{$this->db->table_pre}extra_news")
             ->where("id", $id);
        $q = $this->db->get();
        return $q->row();
    }

    public function get_hot_news()
    {
        $this->db->select("*")
             ->from("{$this->db->table_pre}extra_news")
             ->where("image IS NOT NULL")
             ->limit(4, 0);
        $q = $this->db->get();
        return $q->result();
    }


}
