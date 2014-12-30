<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Search extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->is_logged_in() == FALSE) {
            redirect('auth');
        } else {
            
            $this->load->model('album_model');
            $this->load->model('image_model');
            $this->load->model('user_model');
            $this->load->model('home_model');

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

        }
    }
    public function index() {

        $this->data['url'] = "home";
        $offset = ( isset($_GET['per_page']) && is_numeric($_GET['per_page'])) ? $_GET['per_page'] : 0;
        $per_page = 10;
        $keyword = isset($_GET['keyword'])?trim($_GET['keyword']):'';
        $location = isset($_GET['location'])?trim($_GET['location']):'';
        $author = isset($_GET['author'])?trim($_GET['author']):'';

        $this->data['keyword'] = $keyword;
        $this->data['location'] = $location;
        $this->data['author'] = $author;

        $images_data = $this->image_model->search($per_page, $offset,$keyword,$location,$author);
        $total = count($this->image_model->search_all($keyword,$location,$author));

        $this->data['images'] = $images_data;
        $this->data['total'] = $total;

        $this->load->library('pagination');
        $config = array();
        $config['base_url']         = site_url('search'."?keyword={$keyword}&location={$location}&author={$author}");
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
        
        $this->data['elapsed_time'] = $this->benchmark->elapsed_time();
        $this->data['memory_usage'] = $this->benchmark->memory_usage();
        $this->load->view('search/search',$this->data);
    }

}
