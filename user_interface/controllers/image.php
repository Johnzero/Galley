<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Image extends MY_Controller
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
      $this->load->model('image_model');
      $this->load->model('album_model');
    }
  }
  
  /**
   * Displays image edit form, processes form submission.
   *
   * @param type $album_id
   * @param type $image_id
   * @return type 
   */
  public function edit($album_id, $image_id)
  {
    
    $this->load->helper('form');
    $this->load->model('config_model');
    $album = $this->album_model->find_by_id($album_id);
    $album_config = $this->config_model->get_by_album_id($album_id);
    $image = $this->image_model->find_by_id($image_id);

    if ($image->cats) {
        $ids = explode(",", $image->cats);
        foreach ($ids as $id) {
            if ($id) {
                $this_cat = $this->image_model->get_this_cat($id);
                $cat_array[] = $this_cat;
            }
        }
    }else {
        $cat_array = "";
    }

    $data = array();
    $data['image'] = $image;
    $data['album'] = $album;
    $main_category = $this->image_model->get_main_cats();
    $data['m_c'] = $main_category;
    $data['cat_array'] = $cat_array;

    if ($this->is_method_post() == TRUE)
    {
        
        $maincat = $this->input->post('maincat');
        $cats = $this->input->post('cats');
        $title = trim($this->input->post('name'));
        $location = $this->input->post('location');

        if (!$title) {
            $data['flash'] = "请填写标题！";
        }

        if ( empty($cats) ) {
            $data['flash'] = "请选择分类！";
        }

        if (!$location) {
            $data['flash'] = "请填写拍摄地点！";
        }

        if (! $this->input->post('self') ) {
            if ( ! $this->input->post('author') ) {
                $data['flash'] = "请填写拍摄作者！";
            }else {
                $self = 0;
                $author = trim( $this->input->post('author') );
                $author_tel = $this->input->post('author_tel');
                $author_address = trim( $this->input->post('author_address') );
            }
        }else {
            $session_data = $this->session->all_userdata();
            $this->load->model('user_model');
            if ( isset($session_data['user_id']) ) {
                $user_info = $this->user_model->find_by_id($session_data['user_id']);
                $self = 1;
                $author = $user_info->name;
                $author_tel = $user_info->tel;
                $author_address = $user_info->address;
            }
        }


        if ( isset($data['flash']) )
        {
            $this->load->view('image/edit', $data);
            return;
        }else {
            $cats = array_unique($cats);
            $now = date('Y-m-d H:i:s');
            $image_data = array(
                'name'           => $title,
                'caption'        => $this->input->post('caption'),
                'published'      => $this->input->post('published'),
                'tags'      => $this->input->post('tag'),
                'is_self'      => $self,
                'author'      => $author,
                'author_tel'      => $author_tel,
                'author_address'      => $author_address,
                'location'       => $location,
                'cats' => ','.implode(",", $cats),
                'updated_at'     => $now,
                'updated_by'     => $this->input->post('user_id')
              );
            $this->image_model->update($image_data, $image_id);
            
            $this->album_model->update(array('updated_at' => $now), $album_id);
            
            $this->session->set_flashdata('flash_message', "编辑图片成功！");
            
            redirect('album/images/' . $album->id);
            return;
        }
        
    }
    
    $this->load->view('image/edit', $data);
  }
  
  /**
   * Downloads selected image.
   *
   * @param type $image_id 
   */
  public function download($image_id)
  {
    $image = $this->image_model->find_by_id($image_id);
    if ( ! empty($image))
    {
      header('Content-Type: ' . $image->file_type);
      header('Content-Length: ' . ($image->file_size * 1024)); // KB -> B
      header('Content-Disposition: attachment; filename="' . $image->file_name . '"');
      $open = fopen($image->path . $image->file_name, 'r');
      fpassthru($open);
      fclose($open);
    }
    echo 'image not found';
  }
  
  /**
   * Deletes image file and record.
   *
   * @param type $album_id
   * @param type $image_id 
   */
  public function remove($album_id, $image_id)
  {
    // Delete all photos with this album id
    $image = $this->image_model->find_by_id($image_id);
    if ( ! empty($image))
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
    // Delete image records
    $this->image_model->delete($image_id);
    
    $now = date('Y-m-d H:i:s');
    $this->album_model->update(array('updated_at' => $now), $album_id);
    // Delete album record
    $this->session->set_flashdata('flash_message', "删除图片成功.");
    redirect("album/images/$album_id");
  }
  
  /**
   * Publishes an image.
   *
   * @param type $album_id
   * @param type $image_id 
   */
  public function publish($album_id, $image_id)
  {
    $this->image_model->update(array('published' => 1), $image_id);
    $this->session->set_flashdata('flash_message', "发布成功.");
    redirect("album/images/$album_id");
  }
  
    /**
    * Un-publishes an image.
    *
    * @param type $album_id
    * @param type $image_id 
    */
    public function unpublish($album_id, $image_id)
    {
        $this->image_model->update(array('published' => 0), $image_id);
        $this->session->set_flashdata('flash_message', "取消发布成功.");
        redirect("album/images/$album_id");
    }
  
    /**
    * TODO
    *
    * @param type $album_id
    * @param type $image_id 
    */
    public function comments($album_id, $image_id)
    {
        // TODO
        $this->load->view('image/comments');
    }
      
    public function select_cat()
    {
        
        $main_category_id = $this->input->post('pid');
        $return_options = '';

        if ( $main_category_id ) {
            $sub_cat = $this->image_model->get_cats($main_category_id);
            $this_cat = $this->image_model->get_this_cat($main_category_id);
            foreach ($sub_cat as $key => $value) {
                $three_cat = $this->image_model->get_cats($value->id);
                if (!empty($three_cat)) {
                    $return_options .= "<optgroup label='{$value->typename}'>";
                    foreach ($three_cat as $k => $v) {
                        $return_options .= "<option value='{$v->id}'>{$v->typename}</option>";
                    }
                    $return_options .= "</optgroup>";
                }else {
                    $return_options .= "<option value='{$value->id}'>{$value->typename}</option>";
                }
            }
            echo $return_options;
        }else {
            echo "<option>请重新登录。</option>";
        }

        exit;

    }
  
}