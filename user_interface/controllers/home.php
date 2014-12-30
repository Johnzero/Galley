<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller {
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
        $uri = $this->uri->segment(3);
        $offset = (!empty($uri) && is_numeric($uri)) ? $uri : 0;
        $per_page = 30;
        $images_data = $this->image_model->paginate($per_page, $offset);
        $total = count($this->image_model->fetch_all($per_page));

        $this->data['images'] = $images_data;

        $this->load->library('pagination');
    
        $config = array();
        $config['base_url']         = site_url('home/index');
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
        
        $this->pagination->initialize($config);
        
        $this->load->view('home/index',$this->data);
    }

    public function cat($id) {

        if (!$id) {

            redirect('home');

        }else {

            $uri = $this->uri->segment(5);
            $offset = (!empty($uri) && is_numeric($uri)) ? $uri : 0;
            $cats = $this->home_model->get_cats();
            $cats = $this->object_array($cats);
            $this->data['url'] = $id;

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

            $per_page = 30;
            $this_sub_cat = $this->image_model->get_cats($id);
            foreach ($this_sub_cat as $key => $value) {
                $this_sub_cat_array[] = $value->id;
            }
            $this_sub_cat_array[] = $id;
            $images_data = $this->image_model->cats_data($this_sub_cat_array,$per_page, $offset);
            $total = count($this->image_model->cats_data_all($this_sub_cat_array));

            $this->data['images'] = $images_data;

            $this->load->library('pagination');
        
            $config = array();
            $config['base_url']         = site_url("home/cat/{$id}/page");
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
            
            $this->load->view('home/index',$this->data);


        }

    }

    public function zip_load($uuuid) {

        if (!$uuuid) {

            redirect('home');

        }else {

            $this->load->model('image_model');
            $this->load->library('zip');

            $image = $this->image_model->find_by_uuid($uuuid);
            if ( empty($image) ) {
                redirect('home');exit;
            }

            $cache_time = time();

            $this->load->library('zip');
            
            $this->zip->read_file(iconv("UTF-8","GB2312//IGNORE",'版权声明.txt'));
            $this->zip->archive("/data/cache/tmpzip/{$cache_time}.zip");

            $this->zip->read_file(iconv("UTF-8","GB2312//IGNORE",'访问图片库.url'));
            $this->zip->archive("/data/cache/tmpzip/{$cache_time}.zip");
            
            $path = iconv("UTF-8","GB2312//IGNORE",$image->path.$image->file_name);
            $this->zip->read_file($path);
            $this->zip->download("{$cache_time}.zip");

        }

    }

    public function detail($id) {

        if (!$id) {

            redirect('home');

        }else {

            $cats = $this->home_model->get_cats();
            $cats = $this->object_array($cats);
            $this->data['url'] = "home";
            
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

            $image = $this->image_model->find_by_id($id);

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
            $this->data['image'] = $image;
            $this->data['cat_array'] = $cat_array;

            $this->load->view('home/detail',$this->data);
        }

    }

    public function quick_search() {

        $this->data['url'] = "search";

        if (!$_POST['keyword']) { redirect('home'); }

        $keyword = trim($_POST['keyword']);
        $uri = $this->uri->segment(3);
        $offset = (!empty($uri) && is_numeric($uri)) ? $uri : 0;
        $per_page = 30;

        $images_data = $this->image_model->qsearch($per_page, $offset,$keyword);
        $total = count($this->image_model->qsearch_all($per_page,$keyword));

        $this->data['images'] = $images_data;
        $this->load->library('pagination');
        $config = array();
        $config['base_url']         = site_url('home/index');
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
        
        $this->pagination->initialize($config);

        $this->load->view('home/index',$this->data);

    }

}
