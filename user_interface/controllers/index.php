<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Index extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('home_model');
        $this->load->model('image_model');

        $this->data = array();
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
        $this->data['cats'] = $cats;

        $hot_news = $this->home_model->get_hot_news();
        $this->data['hot_news'] = $hot_news;

    }

    public function index() {
        $data = $this->data;
        $data['url'] = "index";
        $this->load->view('index/index', $data);
    }

    public function sub($id) {
        $data = $this->data;
        if (!$id) {
            redirect('index');
        }
        else {
            $data['url'] = "{$id}";

            $uri = $this->uri->segment(5);
            $offset = (!empty($uri) && is_numeric($uri)) ? $uri : 0;
            $per_page = 5;
            $news = $this->home_model->paginate_news($id,$per_page, $offset);
            $total = count($this->home_model->fetch_all_news($id,$per_page));
            $data['news'] = $news;

            $this->load->library('pagination');
            $config = array();
            $config['base_url']         = site_url("index/sub/{$id}/page");
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
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);

            $this_cat = $this->image_model->get_this_cat($id);
            $data['this_cat'] = $this_cat;
            $this->load->view('index/blog', $data);

        }
    }

    public function single($id) {
        $data = $this->data;
        if (!$id) {
            redirect('index');
        }
        else {
            

            $single = $this->home_model->get_news($id);
            $data['single'] = $single;

            $this_cat = $this->image_model->get_this_cat($single->type);
            $data['this_cat'] = $this_cat;
            $data['url'] = $this_cat->id;

            $this->load->view('index/single', $data);
        }
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
