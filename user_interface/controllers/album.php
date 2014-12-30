<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Album extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    if ($this->is_logged_in() == FALSE)
    {
      redirect('auth');
    }
    else
    {
      $this->load->model('album_model');
      $this->load->model('image_model');
    }
  }
  
  /**
   * Displays list of albums for regular users. Admins can see all albums.
   */
    public function index()
    {
        $uri = $this->uri->segment(3);
    $offset = ( ! empty($uri) && is_numeric($uri)) ? $uri : 0;
    $per_page = 10;
    $this->load->model('user_model');
    if ($this->is_admin() === TRUE)
    {
      $album_data = $this->album_model->paginate($per_page, $offset);
      $total = count($this->album_model->fetch_all());
    }
    else
    {
      $album_data = $this->album_model->paginate_by_user_id($this->get_user_id(), $per_page, $offset);
      $total = count($this->album_model->fetch_by_user_id($this->get_user_id()));
    }
    
    for ($i = 0; $i < count($album_data); $i++)
    {
        $album_data[$i]['images'] = $this->image_model->get_last_ten_by_album_id($album_data[$i]['id']);
    }
    $data = array();
    $data['albums'] = $album_data;
    
    $this->load->library('pagination');
    
    $config = array();
    $config['base_url']         = site_url('album/index');
    $config['total_rows']       = $total;
    $config['per_page']         = $per_page;
    $config['full_tag_open']    = '<div class="pagination"><ul>';
    $config['full_tag_close']   = '</ul></div>';
    $config['first_link']       = '&larr; First';
    $config['last_link']        = 'Last &rarr;';
    $config['first_tag_open']   = '<li>';
    $config['first_tag_close']  = '</li>';
    $config['prev_link']        = 'Previous';
    $config['prev_tag_open']    = '<li class="prev">';
    $config['prev_tag_close']   = '</li>';
    $config['next_link']        = 'Next';
    $config['next_tag_open']    = '<li>';
    $config['next_tag_close']   = '</li>';
    $config['last_tag_open']    = '<li>';
    $config['last_tag_close']   = '</li>';
    $config['cur_tag_open']     =  '<li class="active"><a href="#">';
    $config['cur_tag_close']    = '</a></li>';
    $config['num_tag_open']     = '<li>';
    $config['num_tag_close']    = '</li>';
    $config['num_links']        = 4;
    
    $this->pagination->initialize($config);
    
    $data['user'] = $this->user_model->find_by_id($this->get_user_id());
    
    $flash_login_success = $this->session->flashdata('flash_message'); 
    
    if (isset($flash_login_success) && ! empty($flash_login_success))
    {
        $data['flash'] = $flash_login_success;
    }
    
    $data['is_admin'] = $this->is_admin();
    $session_data = $this->get_user_data();
    $data['email_address'] = $session_data['email_address'];
    
    // $this->output->enable_profiler(TRUE);
    $this->load->view('album/index', $data);
  }
  
  /**
   * View form for creation of album.
   */
  public function create()
  {
    $this->load->helper('form');
    $this->load->view('album/create');
  }
  
    /**
    * Process album addition.
    */
    public function add()
    {

        // Validate form.
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><strong>错误: </strong>', '</div>');
        $user_data = $this->session->all_userdata();
        $this->form_validation->set_rules('album_name', '相册名称', 'trim|required|max_length[45]|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
            // Form didn't validate
            $this->load->view('album/create');
        }
        else
        {
            // Success, create album & redirect
            $now = date('Y-m-d H:i:s');
            $data = array(
                       'name'       => $this->input->post('album_name'),
                        'content'       => $this->input->post('album_content'),
                       'uuid'       => $this->create_uuid(),
                       'created_by' => $user_data['user_id'],
                       'updated_by' => $user_data['user_id'],
                       'created_at' => $now,
                       'updated_at' => $now);
            $new_ablum_id = $this->album_model->create($data);

            $this->load->model('config_model');
            $this->config_model->create(array(
              'album_id' => $new_ablum_id,
              'thumb_width' => 100,
              'thumb_height' => 100,
              'crop_thumbnails' => 0
            ));

            $this->session->set_flashdata('flash_message', "相册创建成功.");
            redirect('album/images/' . $new_ablum_id);
        }

    }
  
  /**
   * Display stored album to edit.
   *
   * @param type $album_id 
   */
  public function edit($album_id)
  {
    $this->load->helper('form');
    
    $data = array();
    $data['album'] = $this->album_model->find_by_id($album_id);
    
    $this->load->view('album/edit', $data);
  }
  
    /**
    *
    * @param type $album_id 
    */
    public function update($album_id)
    {
        // Validate form.
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><strong>错误: </strong>', '</div>');

        $data = array();
        $data['album'] = $this->album_model->find_by_id($album_id);
        $user_data = $this->session->all_userdata();

        $this->form_validation->set_rules('album_name', '相册名称', 'trim|required|max_length[45]|xss_clean');
        if ($this->form_validation->run() == FALSE)
        {
          // Form didn't validate
          $this->load->view('album/create', $data);
        }
        else
        {
          // Success, create album & redirect
          $now = date('Y-m-d H:i:s');
          $data = array(
                       'name' => $this->input->post('album_name'),
                       'content'       => $this->input->post('album_content'), 
                       'created_by' => $user_data['user_id'],
                       'updated_by' => $user_data['user_id'],
                       'created_at' => $now,
                       'updated_at' => $now);
          $this->album_model->update($data, $album_id);
          $this->session->set_flashdata('flash_message', "相册更新成功.");
          redirect('album');
        }
    }
  
  /**
   * Deletes album, according image records and files.
   *
   * @param type $album_id 
   */
  public function remove($album_id)
  {
    // Delete all photos with this album id
    $rs = $this->image_model->get_images_by_album_id($album_id);
    if ( ! empty($rs))
    {
      foreach ($rs as $image)
      {
        $file_name = $image->path . $image->file_name;
        $thumbnail_name = $image->path . $image->raw_name . '_thumb' . $image->file_ext;
        if (file_exists($file_name))
        {
          unlink($file_name);
        }
        if (file_exists($thumbnail_name))
        {
          unlink($thumbnail_name);
        }
      }
    }
    // Delete image records
    $this->image_model->delete_by_album_id($album_id);
    // Delete album record
    $this->album_model->delete($album_id);
    // Delete album config
    $this->load->model('config_model');
    $this->config_model->delete_by_album_id($album_id);
    // Delete feeds
    $this->load->model('feed_model');
    $this->feed_model->delete_albums_by_album_id($album_id);
    
    $this->session->set_flashdata('flash_message', "删除相册成功.");
    redirect('album');
  }
  
  /**
   * Displays images for selected album. 
   *
   * @param type $album_id 
   */
  public function images($album_id)
  {
    
    $this->load->model('config_model');
    $data = array();
    $data['config']    = $this->config_model->get_by_album_id($album_id);
    $data['album']     = $this->album_model->find_by_id($album_id);
    $data['user_id']   = $this->get_user_id();

    $offset = ( isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;
    $per_page = 20;
    $tmp_images = $this->image_model->get_images_by_album_id($album_id,$per_page,$offset);
    $total_images = $this->image_model->get_allimages_by_album_id($album_id);
    $total = count( $total_images );
    $total_file_size = '';
    foreach ($total_images as $key => $value) {
        $total_file_size += $value->file_size; 
    }

    $this->load->library('pagination');
    $config = array();
    $config['base_url']         = site_url("album/images/{$album_id}"."?offset=0");
    $config['total_rows']       = $total;
    $config['per_page']         = $per_page;
    $config['full_tag_open']    = '<div class="pagination"><ul>';
    $config['full_tag_close']   = '</ul></div>';
    $config['first_link']       = '&larr; 第一页';
    $config['last_link']        = '最后 &rarr;';
    $config['first_tag_open']   = '<li>';
    $config['first_tag_close']  = '</li>';
    $config['prev_link']        = '向前';
    $config['prev_tag_open']    = '<li class="prev">';
    $config['prev_tag_close']   = '</li>';
    $config['next_link']        = '下一页';
    $config['next_tag_open']    = '<li>';
    $config['next_tag_close']   = '</li>';
    $config['last_tag_open']    = '<li>';
    $config['last_tag_close']   = '</li>';
    $config['cur_tag_open']     =  '<li class="active"><a href="#">';
    $config['cur_tag_close']    = '</a></li>';
    $config['num_tag_open']     = '<li>';
    $config['num_tag_close']    = '</li>';
    $config['num_links']        = 10;
    $config['enable_query_strings'] = TRUE;
    $config['page_query_string'] = TRUE;
    
    $this->pagination->initialize($config);

    // $this->_auto_resize($album_id);

    $flash_login_success = $this->session->flashdata('flash_message'); 
    
    if (isset($flash_login_success) && ! empty($flash_login_success))
    {
        $data['flash'] = $flash_login_success;
    }

    $cat_array = '';
    foreach ($tmp_images as $key => $value) {
        $cats_name = '';
        if ($value->cats) {
            $ids = explode(",", $value->cats);
            foreach ($ids as $id) {
                if ($id) {
                    $this_cat = $this->image_model->get_this_cat($id);
                    if ( !empty($this_cat) ) {
                        $cats_name = $cats_name.$this_cat->typename.",";
                    }
                }
            }
            
        }
        
        if ( $cats_name ) {
            $cats_name = rtrim($cats_name,',');
        }else {
            $cats_name = "暂无分类";
        }

        $cat_array[$value->id] = $cats_name;
    }
    $data['total'] = $total;
    $data['total_file_size'] = $total_file_size;
    $data['cat_array'] = $cat_array;
    $data['images'] = $tmp_images;

    $this->load->view('album/images', $data);
  }
  
  /**
   * Displays configuration options for album, also processes form.
   *
   * @param type $album_id
   * @return type 
   */
  public function configure($album_id)
  {
    $this->load->model('config_model');
    $this->load->helper('form');
    
    $thumb_width = $this->input->post('thumb_width');
    
    if (isset($thumb_width) && ! empty($thumb_width))
    {
      $this->load->library('form_validation');
      $this->form_validation->set_error_delimiters('<div class="alert alert-error"><strong>Error: </strong>', '</div>');
      $this->form_validation->set_rules('thumb_width', 'Thumbnail width', 'trim|required|max_length[4]|less_than[1500]|greater_than[0]|is_natural|xss_clean');
      $this->form_validation->set_rules('thumb_height', 'Thumbnail height', 'trim|required|max_length[4]|less_than[1500]|greater_than[0]|is_natural|xss_clean');

      if ($this->form_validation->run() != FALSE)
      {
        $this->config_model->update_by_album_id(array(
            'album_id'        => $album_id,
            'thumb_width'     => $this->input->post('thumb_width'),
            'thumb_height'    => $this->input->post('thumb_height'),
            'crop_thumbnails' => $this->input->post('crop_thumbnails'),
            'auto_publish'    => $this->input->post('auto_publish')
        ), $album_id);
        
        // Update all album's thumbnails
        $images = $this->image_model->get_images_by_album_id($album_id);
        if ( ! empty($images))
        {
          $this->load->library('image_lib');
          $config = array();
          foreach ($images as $image)
          {
            $config['image_library']   = 'gd2';
            $config['source_image']    = './uploads/' . $image->file_name;
            $config['create_thumb']    = TRUE;
            $config['maintain_ratio']  = TRUE;
            $config['width']           = $this->input->post('thumb_width');
            $config['height']          = $this->input->post('thumb_height');
            $config['thumb_marker']    = '_thumb';
            // TODO Handle cropping
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->image_lib->clear();
            $config = array();
          }
        }
        
        $now = date('Y-m-d H:i:s');
        $this->album_model->update(array('updated_at' => $now), $album_id);
        
        redirect("album/images/$album_id");
        return;
      }
    }
    
    $data = array();
    $data['config'] = $this->config_model->get_by_album_id($album_id);
    $data['album'] = $this->album_model->find_by_id($album_id);
    
    $this->load->view('album/config', $data);
  }
  
  /**
   * Handles resizing of images per album.
   *
   * @param type $filename 
   */
    public function resize($album_id, $image_id)
    {   
        $image = $this->image_model->find_by_id($image_id);
        $success = FALSE;
        if (isset($image))
        {
            $this->load->library('image_lib');
            $session_data = $this->session->all_userdata();
            $album_data = $this->album_model->find_by_id($album_id);
            $small_dir = iconv("UTF-8","GB2312//IGNORE",$this->config->item('thumbnail_small_dir').$session_data['user_id'].'/'.$album_data->name.'/');
            $medium_dir = iconv("UTF-8","GB2312//IGNORE",$this->config->item('thumbnail_medium_dir').$session_data['user_id'].'/'.$album_data->name.'/');
            $large_dir = iconv("UTF-8","GB2312//IGNORE",$this->config->item('thumbnail_large_dir').$session_data['user_id'].'/'.$album_data->name.'/');

            if ( !file_exists( $small_dir ) ) {
                mkdir(  $small_dir , 0777,true);
            }
            if ( !file_exists( $medium_dir ) ) {
                mkdir(  $medium_dir , 0777,true);
            }
            if ( !file_exists( $large_dir ) ) {
                mkdir(  $large_dir , 0777,true);
            }

            $config = array();
            $config['image_library']   = 'gd2';
            $config['source_image']    = iconv("UTF-8","GB2312//IGNORE",$image->path.$image->file_name);
            $config['create_thumb']    = TRUE;
            $config['maintain_ratio']  = TRUE;
            
            $config['new_image'] = $small_dir;
            $config['width']           = $this->config->item('thumbnail_small_width');
            $config['height']          = $this->config->item('thumbnail_small_height');
            $config['thumb_marker']    = '_thumbsmall';
            if ( !file_exists( $config['new_image'].$image->raw_name.$config['thumb_marker'].$image->file_ext ) ) {
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();
                // $this->warter_mark($config['new_image'].$image->raw_name.$config['thumb_marker'].$image->file_ext,"small");
            }

            $config['new_image'] = $medium_dir;
            $config['width']           = $this->config->item('thumbnail_medium_width');
            $config['height']          = $this->config->item('thumbnail_medium_height');
            $config['thumb_marker']    = '_thumbmedium';
            if ( !file_exists( $config['new_image'].$image->raw_name.$config['thumb_marker'].$image->file_ext ) ) {
                $this->image_lib->initialize($config);
                $this->image_lib->resize();
                $this->image_lib->clear();

                $this->warter_mark($config['new_image'].$image->raw_name.$config['thumb_marker'].$image->file_ext,"medium");
            }

            $config['new_image'] = $large_dir;
            $config['width']           = $this->config->item('thumbnail_large_width');
            $config['height']          = $this->config->item('thumbnail_large_height');
            $config['thumb_marker']    = '_thumblarge';
            if ( !file_exists( $config['new_image'].$image->raw_name.$config['thumb_marker'].$image->file_ext ) ) {
                $this->image_lib->initialize($config);
                $success = $this->image_lib->resize();
                $this->image_lib->clear();

                $this->warter_mark($config['new_image'].$image->raw_name.$config['thumb_marker'].$image->file_ext,"large");
            }

        }

        if ($success == TRUE)
        {

            echo site_url("imagedata/{$image->uuid}?type=small");

        } else {

            echo 'failure';
            
        }
    }
  
    /**
    * Handles reordering of images.
    */
    public function reorder()
    {
        // Reorder images with incoming AJAX request
        if( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
          foreach ($this->input->get('order_num', TRUE) as $position => $image_id)
          {
            $this->image_model->reorder($image_id, $position + 1);
          }
          echo 'success';
        }
    }

    private function warter_mark($path,$type){
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path;
        $config['wm_type'] = 'overlay';
        $config['dynamic_output'] = FALSE;

        $config['wm_overlay_path'] =  $this->config->item('water_mark_'.$type);
        $config['wm_opacity'] = '20';
        $config['wm_vrt_alignment'] = 'bottom';
        $config['wm_hor_alignment'] = 'right';

        $this->image_lib->initialize($config);
        $this->image_lib->watermark();
        $this->image_lib->clear();

    }

    private function _auto_resize($album_id)
    {   

        $this->load->library('image_lib');
        $session_data = $this->session->all_userdata();
        $album_data = $this->album_model->find_by_id($album_id);
        $images = $this->image_model->get_images_by_album_id($album_id);
        
        foreach ($images as $image) {
            $con = $this->resize($image->album_id,$image->id);
        }

    }

}
