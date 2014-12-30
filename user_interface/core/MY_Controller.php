<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
  public function __construct()
  {

    parent::__construct();
    $session_data = $this->session->all_userdata();
    $this->load->model('user_model');
    if ( isset($session_data['user_id']) ) {
        $user_info = $this->user_model->find_by_id($session_data['user_id']);
        $this->session->set_userdata(array("name"=>$user_info->name));
    }
    $this->session->set_userdata(array("is_admin"=>$this->is_admin()));
  }
  
  /**
   * Get user session data.
   * 
   * @return type 
   */
  protected function get_user_data()
  {
    return $this->session->all_userdata();
  }
  
  /**
   * Get logged in user id.
   * 
   * @return type 
   */
  protected function get_user_id()
  {
    $session_data = $this->session->all_userdata();
    return $session_data['user_id'];
  }
  
  /**
   * Determine if user is authenticated.
   * 
   * @return type 
   */
  protected function is_logged_in()
  {
    $session_data = $this->session->all_userdata();
    return (isset($session_data['user_id']) && $session_data['user_id'] > 0 && isset($session_data['logged_in']) && $session_data['logged_in'] == TRUE);
  }
  
  /**
   * Determine if logged in user is admin.
   * 
   * @return type 
   */
  protected function is_admin()
  {
    $session_data = $this->session->all_userdata();
    return (isset($session_data['is_admin']) && $session_data['is_admin'] == 1);
  }
  
  /**
   * Utility method for creating UUIDs.
   * 
   * @return type 
   */
  protected function create_uuid()
  {
    $uuid_query = $this->db->query('SELECT UUID()');
    $uuid_rs = $uuid_query->result_array();
    return $uuid_rs[0]['UUID()'];
  }
  
  /**
   * Utility method for sending emails.
   * 
   * @param type $to
   * @param type $subject
   * @param type $message 
   */
  protected function send_mail($to, $subject, $message)
  {
    $this->load->library('email');
    $this->email->from($this->config->item('from_email_address'));
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->message($message);
    $this->email->send();
  }
  
  /**
   * Utility method for determining if the request is a POST.
   * 
   * @return type 
   */
  protected function is_method_post()
  {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }

    public function object_array($array) {  
      
        if(is_object($array)) {  
            $array = (array)$array;  
        } if(is_array($array)) {  
            foreach($array as $key=>$value) {  
                $array[$key] = $this->object_array($value);  
            }  
        }  
        return $array;  
    }

}