<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Image_model extends MY_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->table_name = $this->db->table_pre."image";
  }
  
  /**
   * Get images by album id.
   * 
   * @param type $album_id
   * @return type 
   */
  public function get_images_by_album_id($album_id,$limit = 20, $offset = 0)
  {

    $this->db->select("{$this->db->table_pre}image.*, COUNT({$this->db->table_pre}image_comment.id) as comments")
             ->from($this->table_name)
             ->join("{$this->db->table_pre}image_comment", "{$this->db->table_pre}image_comment.image_id = {$this->db->table_pre}image.id", "left")
             ->order_by("{$this->db->table_pre}image.order_num", "asc")
             ->group_by("{$this->db->table_pre}image.id")
             ->where("{$this->db->table_pre}image.album_id", $album_id)
             ->limit($limit, $offset);
             
    $q = $this->db->get();
    
    return $q->result();

  }

  public function get_allimages_by_album_id($album_id)
  {
    $this->db->select("{$this->db->table_pre}image.*, COUNT({$this->db->table_pre}image_comment.id) as comments")
             ->from($this->table_name)
             ->join("{$this->db->table_pre}image_comment", "{$this->db->table_pre}image_comment.image_id = {$this->db->table_pre}image.id", "left")
             ->order_by("{$this->db->table_pre}image.order_num", "asc")
             ->group_by("{$this->db->table_pre}image.id")
             ->where("{$this->db->table_pre}image.album_id", $album_id);
    $q = $this->db->get();
    
    return $q->result();
  }
  
  /**
   * Gets ten images from album
   * 
   * @param type $album_id 
   * @return type
   */
  public function get_last_ten_by_album_id($album_id)
  {
    $this->db->from($this->table_name)
             ->where(array("album_id" => $album_id))
             ->order_by("order_num", "asc")
             ->limit(10);
    $q = $this->db->get();
    return $q->result();
  }

    public function fetch_all()
    {
        $this->db->from($this->table_name)
                 ->order_by("created_at", "asc");
        $q = $this->db->get();
        return $q->result();
    }

    public function paginate($limit = 10, $offset = 0)
    {
        $data = array();

        $this->db->from($this->table_name)
                 ->limit($limit, $offset)
                 ->order_by("created_at", "desc"); 
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

    public function cats_data($id_array, $limit = 10, $offset = 0)
    {
        $data = array();
        $where_string = '';
        foreach ($id_array as $value) {
           $where_string = $where_string."cats LIKE "."'%,{$value}%' OR ";
        }
        $where_string = rtrim($where_string,"OR ");
        $this->db->from($this->table_name)
                 ->limit($limit, $offset)
                 ->where($where_string)
                 ->order_by("created_at", "desc"); 
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

    public function cats_data_all($id_array)
    {
        $where_string = '';
        foreach ($id_array as $value) {
           $where_string = $where_string."cats LIKE "."'%,{$value}%' OR ";
        }
        $where_string = rtrim($where_string,"OR ");
        
        $this->db->from($this->table_name)
                ->where($where_string)
                ->order_by("created_at", "asc");
        $q = $this->db->get();
        return $q->result();
    }


    public function get_main_cats()
    {
        $this->db->select("*")
             ->from($this->db->table_pre.'extra_cat')
             ->order_by("disorder", "asc")
             ->where("pid", 0);
        $q = $this->db->get();
        return $q->result();
    }

    public function get_this_cat($pid)
    {
        $this->db->select("*")
             ->from($this->db->table_pre.'extra_cat')
             ->order_by("disorder", "asc")
             ->where("id", $pid);
        $q = $this->db->get();
        return $q->row();
    }

    public function get_cats($pid=0)
    {
        $this->db->select("*")
             ->from($this->db->table_pre.'extra_cat')
             ->order_by("disorder", "asc")
             ->where("pid", $pid);
        $q = $this->db->get();
        return $q->result();
    }

  
  /**
   * Delete images by album id.
   * 
   * @param type $album_id
   * @return type 
   */
  public function delete_by_album_id($album_id)
  {
    $this->db->delete($this->table_name, array("album_id" => $album_id));
    
    return $album_id;
  }
  
  /**
   * Get image by uud.
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
   * Reorder images.
   * 
   * @param type $image_id
   * @param type $position
   * @return type 
   */
  public function reorder($image_id, $position)
  {
    $this->db->update($this->table_name, array("order_num" => $position), array("id" => $image_id));
    
    return $image_id;
  }
  
  /**
   * Get greatest order num for a given album.
   * 
   * @param type $album_id
   * @return int 
   */
  public function get_last_order_num($album_id)
  {
    $this->db->from($this->table_name)
              ->order_by("order_num", "desc")
              ->where("album_id", $album_id)
              ->limit(1);
    $q = $this->db->get();
    $result = $q->row();
    if (!empty($result))
    {
      return $result->order_num;
    }
    return 0;
  }
  
  /**
   * Return image set for xml/json output.
   * 
   * @param type $album_id
   * @return type 
   */
  public function get_feed($album_id)
  {
    $this->db->select("id, name as title, caption, file_name, raw_name, file_ext, path, created_at")
             ->from($this->table_name)
             ->where("published", 1)
             ->where("album_id", $album_id)
             ->order_by("order_num", "asc");
    $q = $this->db->get();
    
    return $q->result();
  }
  
    /**
    * Update image by user id.
    * 
    * @param array $data
    * @param type $id 
    */
    public function update_by_user_id(array $data, $user_id)
    {
        $this->db->update($this->table_name, $data, array("created_by" => $user_id));
    }

    public function qsearch($limit = 10, $offset = 0,$keyword='')
    {
        $data = array();
        $where_string = '';
        $where_string = "name LIKE "."'%{$keyword}%' OR author LIKE "."'%{$keyword}%' OR author_address LIKE "."'%{$keyword}%' OR location LIKE "."'%{$keyword}%' OR caption LIKE "."'%{$keyword}%' OR tags LIKE "."'%{$keyword}%'";
        $this->db->from($this->table_name)
                 ->limit($limit, $offset)
                 ->where($where_string)
                 ->order_by("created_at", "desc"); 
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

    public function qsearch_all($keyword='')
    {   
        $where_string = '';
        $where_string = "name LIKE "."'%{$keyword}%' OR author LIKE "."'%{$keyword}%' OR author_address LIKE "."'%{$keyword}%' OR location LIKE "."'%{$keyword}%' OR caption LIKE "."'%{$keyword}%' OR tags LIKE "."'%{$keyword}%'";
        $this->db->from($this->table_name)->where($where_string)->order_by("created_at", "asc");
        $q = $this->db->get();
        return $q->result();
    }

    public function search($limit = 10, $offset = 0,$keyword='',$location='',$author='')
    {
        $data = array();
        $where_string = '';
        if ($keyword) {
            $where_string = "name LIKE "."'%{$keyword}%' OR author LIKE "."'%{$keyword}%' OR author_address LIKE "."'%{$keyword}%' OR location LIKE "."'%{$keyword}%' OR caption LIKE "."'%{$keyword}%' OR tags LIKE "."'%{$keyword}%'";
        }
        if ($location) {
            if ($where_string) {
                $where_string .= "AND location LIKE"."'%{$location}%'";
            }else {
                $where_string .= "location LIKE"."'%{$location}%'";
            }
        }

        if ($author) {
            if ($where_string) {
                $where_string .= "AND author LIKE"."'%{$author}%'";
            }else {
                $where_string .= "author LIKE"."'%{$author}%'";
            }
        }
        
        if ($where_string) {
            $this->db->from($this->table_name)
                 ->limit($limit, $offset)
                 ->where($where_string)
                 ->order_by("created_at", "desc"); 
        }else {
            $this->db->from($this->table_name)
                 ->limit($limit, $offset)
                 ->order_by("created_at", "desc"); 
        }

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

    public function search_all($keyword='',$location='',$author='')
    {   
        $where_string = '';
        
        if ($keyword) {
            $where_string = "name LIKE "."'%{$keyword}%' OR author LIKE "."'%{$keyword}%' OR author_address LIKE "."'%{$keyword}%' OR location LIKE "."'%{$keyword}%' OR caption LIKE "."'%{$keyword}%' OR tags LIKE "."'%{$keyword}%'";
        }

        if ($location) {
            if ($where_string) {
                $where_string .= "AND location LIKE"."'%{$location}%'";
            }else {
                $where_string .= "location LIKE"."'%{$location}%'";
            }
        }

        if ($author) {
            if ($where_string) {
                $where_string .= "AND author LIKE"."'%{$author}%'";
            }else {
                $where_string .= "author LIKE"."'%{$author}%'";
            }
        }

        if ($where_string) {
            $this->db->from($this->table_name)->where($where_string)->order_by("created_at", "asc");
        }else {
            $this->db->from($this->table_name)->order_by("created_at", "asc");
        }
        $q = $this->db->get();
        return $q->result();
    }

}
