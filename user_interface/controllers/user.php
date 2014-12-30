<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class User extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    if ($this->is_logged_in() == FALSE)
    {
      redirect('album');
    }
    else
    {
      $this->load->model('user_model');
    }
  }
  
  /**
   * Displays list of users.
   */
  public function index()
  {
    $data = array();
    
    
    if ( $this->session->userdata('is_admin') === TRUE ) {
        $data['users'] = $this->user_model->fetch_all();
    }else {

        $data['users'] = $this->user_model->fetch_self();
    }
    $flash_login_success = $this->session->flashdata('flash_message');
    
    if (isset($flash_login_success) && ! empty($flash_login_success))
    {
      $data['flash'] = $flash_login_success;
    }
    
    $data['user_data'] = $this->get_user_data();
    $this->load->view('user/index', $data);
  }
  
  /**
   * Displays form for new user creation.
   */
  public function create()
  {
    if ($this->is_admin() != TRUE)
    {
      redirect('user');
      exit();
    }
    $this->load->helper('form');
    $this->load->view('user/create');
  }
  
  /**
   * Handles new user creation.
   */
  public function add()
  {
    if ($this->is_admin() != TRUE)
    {
        redirect('user');
        exit();
    }

    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<div class="alert alert-error"><strong>错误: </strong>', '</div>');
    $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|is_unique[galley_user.email_address]|xss_clean');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|matches[password_conf]|sha1');
    if ($this->form_validation->run() == FALSE)
    {
        // Form didn't validate
        $this->load->view('user/create');
    }
    else
    {
      // Success, create user & redirect
      $now = date('Y-m-d H:i:s');
      $user_data = array(
                   'email_address'   => $this->input->post('email_address'), 
                   'password'        => $this->input->post('password'),
                   'is_active'       => $this->input->post('is_active'),
                   'is_admin'        => $this->input->post('is_admin'),
                   'created_at'      => $now,
                   'uuid'            => $this->create_uuid(),
                   'updated_at'      => $now);
      $this->user_model->create($user_data);
      $this->session->set_flashdata('flash_message', "User successfully created.");
      redirect('user/index');
    }
  }
  
  /**
   * Display form for editing an existing user.
   *
   * @param type $user_id 
   */
  public function edit($user_id)
  {
    $user_data = $this->get_user_data();
    if ($user_data['user_id'] != $user_id && $user_data['is_admin'] != 1 )
    {
       redirect('user');
       exit();
    }
    $this->load->helper('form');
    
    $data = array();
    $data['user'] = $this->user_model->find_by_id($user_id);
    
    $this->load->view('user/edit', $data);
  }
  
  /**
   * Process editing user.
   *
   * @param type $user_id 
   */
  public function update($user_id)
  {
    $user_data = $this->get_user_data();
    if ($user_data['user_id'] == $user_id)
    {
      redirect('user');
      exit();
    }
    // Validate form.
    $this->load->helper('form');
    $user = $this->user_model->find_by_id($user_id);
    
    $data = array();
    $data['user'] = $user;
    
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<div class="alert alert-error"><strong>错误: </strong>', '</div>');

    $email_address = $this->input->post('email_address');
    // Can set a new email address or keep the same.
    if ($email_address !== $user->email_address)
    {
      $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|is_unique[galley_user.email_address]|xss_clean');
    }
    $this->form_validation->set_rules('password', 'Password', 'trim|min_length[5]|matches[password_conf]|sha1');
    
    $this->form_validation->set_rules('name', 'name', 'trim|required');
    $this->form_validation->set_rules('tel', 'tel', 'trim|required');

    if ($this->form_validation->run() == FALSE)
    {
        // Form didn't validate

        $this->load->view('user/edit', $data);
    }
    else
    {
      // Success, create user & redirect
      $now = date('Y-m-d H:i:s');
      $user_data = array(
                   'email_address' => $this->input->post('email_address'), 
                   'name' => $this->input->post('name'), 
                   'tel' => $this->input->post('tel'), 
                   'address' => $this->input->post('address'), 
                   'is_active' => $this->input->post('is_active'),
                   'is_admin' => $this->input->post('is_admin'),
                   'created_at' => $now,
                   'updated_at' => $now);
      // Password can be optionally changed.
      $password = $this->input->post('password');
      if (isset($password) && ! empty($password))
      {
        $user_data['password'] = $password;
      }
      $this->user_model->update($user_data, $user_id);
      $this->session->set_flashdata('flash_message', "用户更新成功.");
      redirect("user");
    }
  }
  
  /**
   * activates user and user's images.
   *
   * @param type $user_id 
   */
    public function activate($user_id)
    {
        $user_data = $this->get_user_data();
        
        $this->user_model->update(array('is_active' => 1), $user_id);
        $this->session->set_flashdata('flash_message', "激活用户成功！");
        redirect("user");
    }

  public function deactivate($user_id)
  {
    $user_data = $this->get_user_data();
    if ($user_data['user_id'] == $user_id || $this->is_admin() != TRUE)
    {
      redirect('user');
      exit();
    }
    // Unpublish user's images.
    $this->load->model('image_model');
    $this->image_model->update_by_user_id(array('published' => 0), $user_id);
    
    $this->user_model->update(array('is_active' => 0), $user_id);
    $this->session->set_flashdata('flash_message', "已取消激活该用户！");
    redirect("user");
  }
  
  /**
   * Deletes user, user's albums, images.
   *
   * @param type $user_id 
   */
  public function remove($user_id)
  {
    $user_data = $this->get_user_data();
    if ($user_data['user_id'] == $user_id || $this->is_admin() != TRUE)
    {
      redirect('user');
      exit();
    }
    $this->load->model('album_model');
    $this->load->model('image_model');
    $this->load->model('config_model');
    // Remove user's images and albums
    
    $albums = $this->album_model->fetch_by_user_id($user_id);
    if ( ! empty($albums))
    {
      foreach ($albums as $album)
      {
        // Delete all photos with this album id
        $rs = $this->image_model->get_images_by_album_id($album->id);
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
        $this->image_model->delete_by_album_id($album->id);
        // Delete album record
        $this->album_model->delete($album->id);
        // Delete album config
        $this->config_model->delete_by_album_id($album->id);
      }
    }
    
    $this->user_model->delete($user_id);
    
    $this->session->set_flashdata('flash_message', "删除用户成功. Albums and images belonging this data have been erased.");
    redirect('user');
  }
  
}