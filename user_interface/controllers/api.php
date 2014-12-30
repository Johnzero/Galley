<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Api extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('feed_model');
    $this->load->model('album_model');
    $this->load->model('image_model');
    $this->load->model('config_model');
  }
  
  /**
   * Handles image uploads.
   *
   * @param type $album_id 
   */
  public function upload($album_id)
  {
    $session_data = $this->session->all_userdata();
    $album_data = $this->album_model->find_by_id($album_id);
    
    $config = array();
    $config['upload_path']    = './uploads/'.$session_data['user_id'].'/'.iconv("UTF-8","GB2312//IGNORE",$album_data->name).'/';
    $config['allowed_types']  = $this->config->item('allowed_types');
    $config['max_size']       = '406900'; // 400MB
    $config['remove_spaces']  = TRUE;
    $config['encrypt_name']   = TRUE;
    $config['overwrite']      = FALSE;

    if (!file_exists( $config['upload_path'] )) 
    { 
        if ( !mkdir(  $config['upload_path'] , 0777) ) {
            $config['upload_path']    = './uploads/'.$session_data['user_id'].'/';
        }
    } 

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('Filedata') )
    {
      header('HTTP/1.1 500 Internal Server Error');
      exit();
    }
    else
    {
        $upload_info = $this->upload->data();
        $album_config = $this->config_model->get_by_album_id($album_id);
        // Insert file information into database
        $now = date('Y-m-d H:i:s');
        $order_num = $this->image_model->get_last_order_num($album_id);
        if (empty($order_num))
        {
        $order_num = 0;
        }
        $order_num++;
        $image_data = array(
            'album_id'       => $album_id,
            'uuid'           => $this->create_uuid(),
            'name'           => '',
            'order_num'      => $order_num,
            'caption'        => '',
            'raw_name'       => $upload_info['raw_name'],
            'file_type'      => $upload_info['file_type'],
            'file_name'      => $upload_info['file_name'],
            'file_ext'       => $upload_info['file_ext'],
            'file_size'      => $upload_info['file_size'],
            'path'           =>  iconv('GB2312', 'UTF-8', $config['upload_path']),
            'full_path'      =>  iconv('GB2312', 'UTF-8', $upload_info['full_path']),
            'thumbnail_small_dir'    =>  iconv("UTF-8","GB2312//IGNORE",$this->config->item('thumbnail_small_dir')),
            'thumbnail_medium_dir'   =>  iconv("UTF-8","GB2312//IGNORE",$this->config->item('thumbnail_medium_dir')),
            'thumbnail_large_dir'    =>  iconv("UTF-8","GB2312//IGNORE",$this->config->item('thumbnail_large_dir')),
            'published'      => $album_config->auto_publish,
            'created_at'     => $now,
            'updated_at'     => $now,
            'created_by'     => $this->input->post('user_id')
        );

        $image_id = $this->image_model->create($image_data);
        $this->album_model->update(array('updated_at' => $now), $album_id);

        echo $image_id;

    }
  }
  
  /**
   * Displays json/xml feed for grouped feeds.
   *
   * @param type $type
   * @param type $feed_uuid 
   * @throws Exception 
   */
  public function myfeed($type, $feed_uuid)
  {
    header('Access-Control-Allow-Origin: *');
    switch (strtolower($type))
    {
      case 'json':
        header('Content-Type: text/javascript; charset=utf8');
        $this->output_my_json_feed($feed_uuid);
        break;
      case 'xml':
        header("Content-Type: application/xhtml+xml; charset=utf-8");
        $this->output_my_xml_feed($feed_uuid);
        break;
      default:
        throw new Exception('This option is not supported.');
        break;
    }
  }
  
  /**
   * Displays json/xml feed for singular albums.
   *
   * @param type $type
   * @param type $album_uuid
   * @throws Exception 
   */
  public function feed($type, $album_uuid)
  {
    header('Access-Control-Allow-Origin: *');
    switch (strtolower($type))
    {
      case 'json':
        header('Content-Type: text/javascript; charset=utf8');
        $this->output_json_feed($album_uuid);
        break;
      case 'xml':
        header("Content-Type: application/xhtml+xml; charset=utf-8");
        $this->output_xml_feed($album_uuid);
        break;
      default:
        throw new Exception('This option is not supported.');
        break;
    }
  }
  
  /**
   *
   * @param type $album_uuid 
   */
  protected function output_json_feed($album_uuid)
  {
    echo json_encode($this->get_feed($album_uuid));
  }
  
  /**
   *
   * @param type $feed_uuid 
   */
  protected function output_my_json_feed($feed_uuid)
  {
    echo json_encode($this->get_my_feed($feed_uuid));
  }
  
  /**
   *
   * @param type $album_uuid 
   */
  protected function output_xml_feed($album_uuid)
  {
    $data = array();
    $data['album'] = $this->get_feed($album_uuid);
    
    $this->load->view('api/xml_album', $data);
  }
  
  /**
   *
   * @param type $feed_uuid 
   */
  protected function output_my_xml_feed($feed_uuid)
  {
    $data = array();
    $data['feed'] = $this->get_my_feed($feed_uuid);
    
    $this->load->view('api/xml_feed', $data);
  }
  
  /**
   *
   * @param type $album_uuid
   * @return type 
   */
  protected function get_feed($album_uuid)
  {
    $album = $this->album_model->find_by_uuid($album_uuid);
    if (empty($album))
    {
      return array();
    }
    $image_data = $this->image_model->get_feed($album->id);
    
    foreach ($image_data as $image)
    {
      $image->url = base_url() . 'uploads/' . $image->file_name;
      $image->thumb = base_url() . 'uploads/' . $image->raw_name . '_thumb' . $image->file_ext;
    }
    $album->images = $image_data;
    
    return $album;
  }
  
  /**
   *
   * @param type $feed_uuid 
   * @return type
   */
  protected function get_my_feed($feed_uuid)
  {
    $feed = $this->feed_model->find_by_uuid($feed_uuid);
    if (empty($feed))
    {
      return array();
    }
    $feed_albums = $this->feed_model->get_feed_albums($feed->id);
    
    $albums = array();
    foreach ($feed_albums as $feed_album)
    {
      $album = $this->album_model->find_by_id($feed_album->album_id);
      $image_data = $this->image_model->get_feed($album->id);
      foreach ($image_data as $image)
      {
        $image->url = base_url() . 'uploads/' . $image->file_name;
        $image->thumb = base_url() . 'uploads/' . $image->raw_name . '_thumb' . $image->file_ext;
      }
      $album->images = $image_data;
      array_push($albums, $album);
    }
    $feed->albums = $albums;
    
    
    return $feed;
  }
  
}
  