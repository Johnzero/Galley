<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Import extends MY_Controller {
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

        set_time_limit(0);
        set_include_path('./user_interface/libraries/PHPExcel');
        include  'PHPExcel.php';
        include 'PHPExcel/IOFactory.php';
        include 'PHPExcel/Reader/Excel5.php';

        $filePath = "./import.xlsx";
        $reader = new PHPExcel_Reader_Excel2007(); 
        if(!$reader->canRead($filePath)){ 
            $reader = new PHPExcel_Reader_Excel5(); 
            if(!$reader->canRead($filePath)){ 
                echo 'no Excel'; 
                return ; 
            } 
        } 

        $reader->setReadDataOnly(true);
        $excel = $reader->load($filePath); //excel的路径
        echo "<pre>";
        $data=$excel->getActiveSheet()->toArray();
        $new_data = array();
        $n = 0;
        array_shift($data);
        foreach ($data as $value) {
            $keys = $value[0];
            // array_shift($value);
            // $new_data[$key] = $value;
            if ( file_exists ( iconv("UTF-8","GB2312//IGNORE","E:/作者/一/".$keys.".jpg") ) ) {
                $image_id = $this->upload($value);
                if ($image_id) {
                    echo $keys."----";
                    echo $image_id."<br/>";
                    echo "<pre>";
                }

            }
        }
    }

    public function upload($value,$album_id="17")
    {
        $keys = $value[0];
        $file = "E:/作者/一/".$keys.".jpg";
        $this->load->model('album_model');
        $this->load->model('image_model');
        $this->load->model('config_model');

        $session_data = $this->session->all_userdata();
        $album_data = $this->album_model->find_by_id($album_id);
        
        $config = array();
        $config['upload_path']    = './uploads/'.$session_data['user_id'].'/'.iconv("UTF-8","GB2312//IGNORE",$album_data->name).'/';

        if (!file_exists( $config['upload_path'] )) 
        { 
            if ( !mkdir(  $config['upload_path'] , 0777) ) {
                $config['upload_path']    = './uploads/'.$session_data['user_id'].'/';
            }
        } 
        $file_size = round(filesize( iconv("UTF-8","GB2312//IGNORE",$file) )/1024,2);
        $album_config = $this->config_model->get_by_album_id($album_id);
        // Insert file information into database
        $now = date('Y-m-d H:i:s');
        $order_num = $this->image_model->get_last_order_num($album_id);
        if (empty($order_num))
        {
            $order_num = 0;
        }
        $order_num++;
        $image_data = array(
            'album_id'       => $album_id,
            'uuid'           => $this->create_uuid(),
            'name'           => $value[1]?$value[1]:$keys,
            'order_num'      => $order_num,
            'cats'           => $value[8] ? ",".$value[8] : '',
            'caption'        => $value[2],
            'raw_name'       => $keys,

            'author'       => $value[3],
            'author_tel'       => $value[6],
            'author_address'       => $value[4],
            'location'       => $value[7],

            'file_type'      => "application/octet-stream",
            'file_name'      => $keys.".JPG",
            'file_ext'       => ".JPG",
            'file_size'      => $file_size,
            'path'           => iconv('GB2312', 'UTF-8', $config['upload_path']),
            'full_path'      =>  __ROOT__.ltrim($config['upload_path'],'.').$keys.".JPG",
            'thumbnail_small_dir'    =>  iconv("UTF-8","GB2312//IGNORE",$this->config->item('thumbnail_small_dir')),
            'thumbnail_medium_dir'   =>  iconv("UTF-8","GB2312//IGNORE",$this->config->item('thumbnail_medium_dir')),
            'thumbnail_large_dir'    =>  iconv("UTF-8","GB2312//IGNORE",$this->config->item('thumbnail_large_dir')),
            'published'      => $album_config->auto_publish,
            'created_at'     => $now,
            'updated_at'     => $now,
            'created_by'     => $album_data->created_by
        );

        $image_id = $this->image_model->create($image_data);
        $this->album_model->update(array('updated_at' => $now), $album_id);

        return $image_id;

    }

}
