<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Auth extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('user_model');
  }
  
  /**
   * Display login form.
   */
  public function index()
  {
    $this->load->helper('form');
    
    $data = array();

    $data['email'] = '';

    if ( $this->session->flashdata('flash_message') ) {
        $data['login_error'] = $this->session->flashdata('flash_message');
    }

    if ($this->_is_logged_in() == TRUE)
    {
      redirect('home');
    }

    $this->load->view('auth/index', $data);

  }
  
    /**
    * Process user authentication.
    */
    public function authenticate()
    {
        // Authenticate user.
        $this->load->helper('form');
        $userData = array('email_address' => $this->input->post('email_address'), 'password' => $this->input->post('password'));
        $user_id = $this->user_model->authenticate($userData);
        if ($user_id > 0)
        {
            // Create session var
            $user = $this->user_model->find_by_id($user_id);
            if ( $user->is_active != 1 ) {
                $data = array();
                $data['login_error'] = '账号未审核，请联系管理员进行审核！';
                $data['email'] = $this->input->post('email_address');
                $this->load->view('auth/index', $data);
            }else {
                $this->create_login_session($user);
                $this->session->set_flashdata('flash_message', '登陆成功！');
                redirect('home');
            }
        }
        else
        {
            $data = array();
            $data['login_error'] = '账户或密码错误！';
            $data['email'] = $this->input->post('email_address');
            $this->load->view('auth/index', $data);
        }
    }

    /**
    * Process user reg.
    */
    public function reg()
    {
        $this->load->helper('form');
        if ( $this->is_method_post() == TRUE ) {
                
            $this->load->model('user_model');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><strong>错误: </strong>', '</div>');
            $this->form_validation->set_rules('email_address', '邮箱地址', 'trim|required|valid_email|is_unique[galley_user.email_address]|xss_clean');
            $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[5]|matches[password_conf]|sha1');
            
            $this->form_validation->set_rules('name', '姓名', 'trim|required');
            $this->form_validation->set_rules('tel', '联系方式', 'trim|required');
            $this->form_validation->set_rules('address', '通讯地址', 'trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                // Form didn't validate
                $this->load->view('auth/reg');
            }
            else
            {
                
                // Success, create user & redirect
                $now = date('Y-m-d H:i:s');
                $user_data = array(
                    'email_address'   => $this->input->post('email_address'), 
                    'password'        => $this->input->post('password'),
                    'name' => trim($this->input->post('name')), 
                    'tel' => trim($this->input->post('tel')), 
                    'address' => trim($this->input->post('address')), 
                    'is_active'       => 0,
                    'created_at'      => $now,
                    'uuid'            => $this->create_uuid(),
                    'updated_at'      => $now
                );
                $id = $this->user_model->create($user_data);
                $user = $this->user_model->find_by_id($id);
                if ($id) {
                    $this->session->set_flashdata('flash_message', '注册成功！请联系管理员进行审核！');
                    redirect('auth');
                }

            }

        }else {
            $this->load->view('auth/reg');
        }


    }
  
  /**
   * Process user logout.
   */
  public function logout()
  {
    $this->session->sess_destroy();
    redirect('auth');
  }
  
  /**
   * Display forgot password view. Processes forgot password form.
   *
   * @return type 
   */
  public function forgotpassword()
  {
    $this->load->helper('form');
    $email_address = $this->input->post('email_address');
    
    $data = array();
    $data['email_address'] = $email_address;
    
    if (isset($email_address))
    {
      // Validate form
      $this->load->library('form_validation');
      $this->form_validation->set_error_delimiters('<div class="alert alert-error"><strong>错误: </strong>', '</div>');
      $this->form_validation->set_rules('email_address', '邮箱地址', 'trim|required|valid_email|xss_clean');
      if ($this->form_validation->run() == TRUE)
      {
        $user = $this->user_model->get_by_email_address($email_address);
        // No user found
        if (empty($user))
        {
          $data['error'] = '该邮箱不存在！';
        }
        else
        {
          
            $this->load->model('ticket_model');
            $ticket_id = $this->ticket_model->create(array('user_id' => $user->id, 'uuid' => $this->create_uuid()));
            $ticket = $this->ticket_model->find_by_id($ticket_id);

            // Send email
            $subject = $this->config->item('site_title') . ' - 忘记密码';
            $reset_pw_url = base_url('auth/resetpassword/' . $ticket->uuid);
            $message = "你申请的重置密码操作.\r\n 请点击重置密码链接: $reset_pw_url";

            $this->load->library('email');
            $this->email->from($this->email->smtp_user, $this->config->item('site_title'));
            // $this->email->to($user->email_address); 
            $this->email->to("419484794@qq.com"); 

            $this->email->subject($subject);
            $this->email->message($message); 

            $this->email->send();

            $this->load->view('auth/forgot_password_success');
            return;

        }
      }
    }
    $this->load->view('auth/forgot_password', $data);
  }
  
  /**
   * Displays reset password view. Processes password reset.
   *
   * @param type $uuid 
   */
  public function resetpassword($uuid)
  {
    $this->load->model('ticket_model', 'ticket_model');
    
    $data = array();
    // Check for ticket
    $ticket = $this->ticket_model->get_by_uuid($uuid);
    if (empty($ticket))
    {
      $data['error'] = '链接已失效.';
    }
    else
    {
      $user = $this->user_model->find_by_id($ticket->user_id);
      $data['uuid'] = $uuid;

      $new_password = $this->input->post('password');
      if (isset($new_password))
      {
        // Validate new password
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><strong>错误: </strong>', '</div>');
        $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[5]|matches[password_conf]|sha1');
        if ($this->form_validation->run() == TRUE)
        {
          // Save new password
          $this->user_model->update_password($this->input->post('password'), $user->id);
          // Delete ticket
          $this->ticket_model->delete($ticket->id);
          // Authenticate user
          $user_id = $this->user_model->authenticate(array('email_address' => $user->email_address, 'password' => $new_password));
          if ($user_id > 0)
          {
            $this->create_login_session($user);
          }
          // Redirect
          redirect('home');
        }
      }
    }
    $this->load->view('auth/reset_password', $data);
  }
  
  /**
   * Creates session data for logged in user.
   *
   * @param type $user 
   */
  protected function create_login_session($user)
  {
    $session_data = array(
        'email_address'  => $user->email_address,
        'user_id'        => $user->id,
        'logged_in'      => TRUE,
        'is_admin'       => $user->is_admin,
        'ip'             => $this->input->ip_address()
    );
    $this->session->set_userdata($session_data);
  }

  private function _is_logged_in()
  {
    $session_data = $this->session->all_userdata();
    return (isset($session_data['user_id']) && $session_data['user_id'] > 0 && $session_data['logged_in'] == TRUE);
  }

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
