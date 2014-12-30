<?php
/*
 *新闻类别
 *author 王建 
 *time 2014-05-18
 */
 
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Cat extends MY_Controller{
	private $category_modeldata_cache; 
	private $category_ ; 
	public  $category_type = array(
		'1'=>'频道封面',//封面频道不允许发表文章
		'2'=>'列表栏目' , 
		'3'=>'第三方跳转' , //也不允许发表文章
	);
	function Cat(){
		parent::__construct();
		$this->load->model('M_common');
		$this->category_modeldata_cache = config_item("category_modeldata_cache") ;
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data",'query_pid_by_id');
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			$this->load->view(__TEMPLET_FOLDER__."/views_cat_index");
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}elseif($action == 'query_pid_by_id'){
			$pid = $this->query_pid_by_id();
			echo $pid ;
		}		
	}
	//ajax get data
	private function ajax_data(){
		$page = intval($this->input->get_post("page"));	
		$pid = intval($this->input->get_post("pid"));		
		$this->load->library("common_page");
		if($page <=0 ){
			$page = 1 ;
		}
		$per_page = 500;//每一页显示的数量
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$where = ' where 1= 1 ';
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}extra_cat as a  {$where} ";
		$total  = $this->M_common->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql_category = "SELECT *  FROM {$this->table_}extra_cat as a {$where} order by id,disorder desc limit  {$limit}";	
		$list = $this->M_common->querylist($sql_category);
		$ids = '' ;
		if($list){
			foreach($list as $k=>$v){
				$list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';
				$ids.=$v['id'].",";
			}	
			$ids = rtrim($ids,",") ;
			$sql_count_child_article = "SELECT COUNT(*) AS num ,type FROM {$this->table_}extra_news WHERE type in ($ids) GROUP BY type ";
			$list_count = $this->M_common->querylist($sql_count_child_article);	
			$temp = array();
			$list = tree_format($list,0,0,"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");		
		}
		echo result_to_towf_new($list, 1, '成功', $page_string) ;
	}

	//添加联动模型数据
	function add(){		
		$action = $this->input->get_post("action");		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'add':$action ;	
		if($action == 'add'){	
			$pid = verify_id($this->input->get_post("pid")) ;			
			$this->load->view(__TEMPLET_FOLDER__."/views_cat_add",array('pid'=>$pid));		
		}elseif($action =='doadd'){
			$this->doadd();
		}
	}

	//处理添加
	private function doadd(){	

		$typename = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("typename" , true)))));
		$seotitle = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("seotitle" , true)))));
		$keywords = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("keywords" , true )))));
		$description = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("description" , true)))));	
		$disorder = verify_id($this->input->get_post("disorder" , true ));//排序	
		$pid = verify_id($this->input->get_post("pid" , true )) ;
		$ico = trim($this->input->get_post("ico"));	

		if($typename == "" ){
			echo result_to_towf_new('', 0, '类别名称不能为空', null);
			exit();
		}
		$data = array(
			'disorder'=>$disorder,
			'pid'=>$pid,
			'typename'=>$typename,
			'seotitle'=>$seotitle,
			'ico'=>$ico,
			'keywords'=>$keywords
		);
		$array = $this->M_common->insert_one("{$this->table_}extra_cat",$data);
		if($array['affect_num']>=1){
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加数据为{$typename}成功");
			
			echo result_to_towf_new('', 1, 'success', null);
			die();
		//	header("Location:".site_url("category_data/index")."?typeid=".$typeid);
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加数据为{$typename}失败");
			echo result_to_towf_new('', 0, '服务器繁忙', null);
			die() ;
			//showmessage("服务器繁忙","category_data/add",3,0,"?id={$pid}&type={$typeid}");
			//exit();
		}
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action");		
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;		
		if($action == 'edit'){
			$id = verify_id($this->input->get_post("id"));//数据			
			$sql_= "SELECT a.* FROM {$this->table_}extra_cat as a where a.id = '{$id}'";					
			$info_ = $this->M_common->query_one($sql_);
			if(empty($info_)){
				showmessage("参数错误","category_data/index",3,0);
				exit();
			}			
			$data = array(
					'info'=>$info_,						
					'id'=>$id		
			);				
			$this->load->view(__TEMPLET_FOLDER__."/views_cat_edit",$data);	
			
		}elseif($action == 'doedit'){
			$this->doedit();
		}

	}
	
	private function doedit(){
		$id = verify_id($this->input->get_post("id"));	
		$typename = dowith_sql(daddslashes(html_escape(strip_tags(trim($this->input->get_post("typename"))))));//
		$disorder = verify_id($this->input->get_post("disorder"));	
		$seotitle = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("seotitle")))));
		$keywords = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("keywords")))));
		$ico = trim($this->input->get_post("ico"));	
		
		if($typename == "" ){
			echo result_to_towf_new(array('id'=>$id), 0, '类别名不能为空', null) ;
			exit();
		}
		
		$time = date("Y-m-d H:i:s",time());
		$sql_edit = "UPDATE `{$this->table_}extra_cat` SET typename = '{$typename}',disorder = '{$disorder}',seotitle='{$seotitle}',keywords = '{$keywords}',ico = '{$ico}'   where id = '{$id}'";
		$num = $this->M_common->update_data($sql_edit);
		if($num>=1){
			write_action_log($sql_edit,$this->uri->uri_string(),login_name(),get_client_ip(),1,"修改类别名称为{$typename}成功");
			echo result_to_towf_new(array('id'=>$id), 1, 'success', null) ;
			
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),login_name(),get_client_ip(),0,"修改类别名称为{$typename}失败");
			echo result_to_towf_new(array('id'=>$id), 0, '服务器繁忙，或者你没有修改任何数据', null) ;
			die();
		}
	}
		
}
//file end