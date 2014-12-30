<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Imagedata extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if ( $this->is_logged_in() == FALSE ) {
            redirect('auth');
        } else {

            $this->load->model('image_model');
            $this->load->model('album_model');

        }

    }
    public function index($uuuid) {

        if (!$uuuid) {

            redirect('home');

        }else {
            $type = trim($this->input->get('type'));

            if ( !in_array($type, array("small","medium","large","premium") )) {
                $type = "medium";
            }

            $this->load->helper('file');
            $session_data = $this->session->all_userdata();
            $image = $this->image_model->find_by_uuid($uuuid);
            if ( empty($image) ) {
                redirect('home');
            }
            $album_id = $image->album_id;
            $album_data = $this->album_model->find_by_id($album_id);
            if ( empty($album_data) ) {
                redirect('home');
            }

            if ($type == 'premium') {
                
                // if ( $session_data['user_id'] != $album_data->created_by) {
                //     echo "error owner";
                //     exit;
                // }

                $imagedata = read_file( iconv("UTF-8","GB2312//IGNORE",$image->full_path) );

            }else {

                $thumbnail_type = $image->{'thumbnail_'.$type.'_dir'};
                $file_dir = iconv("UTF-8","GB2312//IGNORE",$thumbnail_type.$image->created_by.'/'.$album_data->name.'/');
                
                $imagedata = read_file( $file_dir.$image->raw_name.'_thumb'.$type.$image->file_ext );

            }

            echo $imagedata;

            header('content-type:image');

        }
    }

    function _remap($parameter){
        $this->index($parameter);
    }

}

