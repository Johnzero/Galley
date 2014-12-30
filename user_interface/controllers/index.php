<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('home_model');
        $this->load->model('image_model');

    }

    public function index() {
        $data = array();

        $cats = $this->home_model->get_cats();
        $cats = $this->object_array($cats);
        
        foreach ($cats as $key => $value) {
            $sub_cat = $this->image_model->get_cats($value['id']);
            $sub_cat = $this->object_array($sub_cat);
            if (!empty($sub_cat)) {
                $cats[$key]["sub_cat"] = $sub_cat;
            }else {
                $cats[$key]["sub_cat"] = '';
            }
        }
        $data['cats'] = $cats;
        $data['url'] = "index";
        $this->load->view('index/index', $data);
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
