<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        $data = array();
        
        $this->load->view('index/index', $data);
    }
    
}
