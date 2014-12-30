<?php 
/*
 *后台首页文件
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Admin extends MY_Controller {
	function Admin(){
		parent::__construct();
		$this->load->model('M_common');
	}
	//后台框架首页
	function index(){
		$list = $this->M_common->querylist("SELECT name from {$this->table_}common_admin_nav where pid = 0 and status = 1   order by disorder,id desc ");	
		$sql_login_log = "SELECT * FROM {$this->table_}common_adminloginlog WHERE username = '{$this->username}' order by id desc limit 2 " ;
		$login_info = $this->M_common->querylist($sql_login_log);
		$data = array(
			'list'=>$list,
			'username'=>$this->username,
			'group_name'=>"<font color='red'>".$this->group_name."</font>",
			'login_info'=>$login_info
		);
		$this->load->view(__TEMPLET_FOLDER__."/views_index",$data);
	}
	
}
