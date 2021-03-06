<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>新闻管理</title>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/static/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/style.css" />   
	<link rel="stylesheet" type="text/css" href="/static/assets/css/dpl-min.css" />   
	<script type="text/javascript" src="/static/js/DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="/static/assets/js/jquery-1.8.1.min.js"></script>
    <link href="/static/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
   <link href="/static/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/static/js/admin.js"></script>
     <script type="text/javascript" src="/static/assets/js/bui-min.js"></script>
      <script type="text/javascript" src="/static/js/admin.js"></script>
   <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }


    </style>
</head>
<body>
<div class="form-inline definewidth m20" >  
<table cellpadding="10">
	<tr>
		<td>
			标题：<input type="text" name="" id="title">
		    新闻类别：
			  <select id="type">
				<option value="">请选择</option>
				<?php 
					if(isset($list) && $list){
						foreach($list as $k=>$v){
						
				?>
				<option value="<?php echo isset($v['id'])?$v['id']:'' ;?>"> <?php echo $v['html']; ?><?php echo isset($v['typename'])?$v['typename']:'' ;?></option>
				<?php 
					}
				}	
				?>
		 	</select>  
			来源：
			 <select id="from">
				<option value="">请选择</option>
				<?php 
					if(isset($from) && $from){
						foreach($from as $f_k=>$f_v){
						
				?>
				<option value="<?php echo isset($f_v)?$f_v['id']:'' ;?>"><?php echo isset($f_v)?$f_v['name']:'' ;?></option>
				<?php 
					}
				}	
				?>
		 	</select>
		 	&nbsp;&nbsp;&nbsp;
		 	<a href="javascript:void(0)" onclick="more_search() ;">更多条件搜索</a> 	
		 	<button type="submit" class="btn btn-primary" onclick="search_()">查询数据</button>&nbsp;&nbsp; <a  class="btn btn-success" id="addnew" href="javascript:void(0)" onclick="add_news()">添加新闻<span class="glyphicon glyphicon-plus"></span></a>				
		</td>
	</tr>
	<tr id="more_search" style="display:none">
		<td>
	属性：
	 <select id="attr">
		<option value="">请选择</option>
		<?php 
			if(config_item("content_att")){
				foreach(config_item("content_att") as $c_k=>$c_v){
				
		?>
		<option value="<?php echo $c_k ;?>"><?php echo $c_v;?></option>
		<?php 
			}
		}	
		?>
 	</select> 	
 	日期:
 	<input id="beginDate" class="Wdate" type="text" readonly="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'%y-%M-%d',isShowClear:true,readOnly:true})" value="" placeholder="" name="">
   ~~~ 结束时间：
<input id="enddate" class="Wdate" type="text" readonly="" onclick="WdatePicker({dateFmt:'yyyy-MM-dd',maxDate:'%y-%M-%d',isShowClear:true,readOnly:true})" value="" placeholder="" name="">
    
		</td>
	</tr>
</table>

 	
</div>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
        <th></th>
        <th>title</th>  
       <th>添加日期</th>
       <th>修改日期</th>
       <th>状态</th>
       <th>添加者</th>  
       <th>类型</th>  
       <th>来源</th>  
       <th>操作</th>  
    </tr>
    </thead>
	<tbody id="result_">


	</tbody> 
	<tr>
		<td colspan="11">
		全选：<input type="checkbox" id="selAll" onclick="selectAll()">
		反选：<input type="checkbox" id="inverse" onclick="inverse();">
			<button class="button button-small" type="button" onclick="del()">
			<i class="icon-remove"></i>
			删除
			</button>
			<button class="button button-small" type="button" onclick="change_status(0)">
			<i class="icon-off"></i>
			设为隐藏
			</button>
			<button class="button button-small" type="button" onclick="change_status(1)">
			<i class="icon-eye-open"></i>
			设为显示
			</button>
		</td>
	</tr>
</table>
<div id="page_string" class="form-inline definewidth m10">
  
</div>

</body>
</html>
<script>
var page = 1 ; 
$(function () {	
	var typeid = parseInt(getQueryStringValue("typeid"));
	if(typeid >0 ){
		$("#type").val(typeid) ;
	}
	common_request();
});
function common_request(){
	var url="<?php echo site_url("news/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data',
		'type':$("#type").val(),
		'from':$("#from").val(),
		'title':$("#title").val(),
		'attr':$("#attr").val(),
		'beginDate':$("#beginDate").val(),
		'enddate':$("#enddate").val()
	} ;
	$.ajax({
		   type: "POST",
		   url: url ,
		   data: data_,
		   cache:false,
		   dataType:"json",
		 //  async:false,
		   success: function(msg){
			var shtml = '' ;
			var list = msg.resultinfo.list;
			if(msg.resultcode<0){
				BUI.Message.Alert("你没权限执行此操作" ,'error');
				return false ;
			}else if(msg.resultcode == 0 ){
				BUI.Message.Alert(msg.resultinfo.errmsg ,'error');
				return false ;				
			}else{
				if(list.length>0){
					for(var i in list){
						
						shtml+='<tr>';
						shtml+='<td width="20px"><input type="checkbox" name="checkAll[]" onclick="setSelectAll();" value="'+list[i]['id']+'"></td>';
						// shtml+='<td ><a href="#">'+list[i]['title']+'</a>'+list[i]['flag']+'</td>';	
						shtml+='<td ><a href="#">'+list[i]['title']+'</a></td>';				
						shtml+='<td>'+list[i]['create_date']+'</td>';
						shtml+='<td>'+list[i]['modify_date']+'</td>';
						shtml+='<td>'+list[i]['status']+'</td>';
						shtml+='<td>'+list[i]['addperson']+'</td>';
						shtml+='<td>'+list[i]['typename']+'</td>';
						shtml+='<td>'+list[i]['fromname']+'</td>';
						shtml+='<td><a href="<?php echo site_url("news/edit") ; ?>?id='+list[i].id+'" class="icon-edit" title="编辑文章"></a>&nbsp;&nbsp;<a href="<?php echo site_url("news/index") ; ?>?id='+list[i].id+'&action=preview">查看</a></td>';
						shtml+='</tr>';
					}
					$("#result_").html(shtml);				
					$("#page_string").html(msg.resultinfo.obj);
				}else{
					$("#result_").html("暂无数据");	
					$("#page_string").html("");	
				}

			}
		   },
		   beforeSend:function(){
			  $("#result_").html('<font color="red"><img src="<?php echo base_url();?>/<?php echo APPPATH?>/views/static/Images/progressbar_microsoft.gif"></font>');
		   },
		   error:function(){
			   BUI.Message.Alert('服务器繁忙请稍后' ,'error');
		   }
		  
		});		
	

}
function ajax_data(p){
	page = p ;
	common_request();	
}

	

//查询
function search_(){
	page = 1 ;
	common_request(1);	
}

function del(){
	var selectCount = 0;
	var data = [] ; 	
	var o = select_data() ;
	selectCount = o.selectCount ; 
	data = o.data ;
	if(selectCount == 0 ){
		BUI.Message.Alert('请选择进行删除','error');
		return false ;
	}
	BUI.Message.Confirm('此操作不可恢复,是否确定此操作',function(){
		$.ajax({
			   type: "POST",
			   url: "<?php echo site_url('news/del');?>" ,
			   data: {"ids":data},
			   cache:false,
			   dataType:"json",
			 //  async:false,
			   success: function(msg){
				   if(msg.resultcode<0){
					   BUI.Message.Alert('没有权限执行此操作','error');
					   return false ; 
					}else if(msg.resultcode == 0 ){
						BUI.Message.Alert(msg.resultinfo.errmsg ,'error');
						common_request();
						return false ;				
					}else{
						common_request();
					}
			   },
			   beforeSend:function(){
				  $("#result_").html('<font color="red"><img src="<?php echo base_url();?>/<?php echo APPPATH?>/views/static/Images/progressbar_microsoft.gif"></font>');
			   },
			   error:function(){
				   BUI.Message.Alert('服务器繁忙请稍后','error');
			   }
			  
			});		
	},'question');

}
function select_data(){
	var obj=document.getElementsByName("checkAll[]");
	var count = obj.length;
	var selectCount = 0;
	var data = [] ; 
	for(var i = 0; i < count; i++)
	{
		if(obj[i].checked == true)
		{
			selectCount++;
			data.push(obj[i].value);
		}
	}
	var o = {
		'selectCount':selectCount , 
		'data':data
	} ;
	return o ;
}
//设置状态
function change_status(status){
	var selectCount = 0;
	var data = [] ; 	
	var o = select_data() ;
	selectCount = o.selectCount ; 
	data = o.data ;
	if(selectCount == 0 ){
		BUI.Message.Alert('请选择进行修改状态','error');
		return false ;
	}
	$.ajax({
			   type: "POST",
			   url: "<?php echo site_url('news/edit');?>" ,
			   data: {"ids":data,"action":'dostatus',"status":status},
			   cache:false,
			   dataType:"json",
			 //  async:false,
			   success: function(msg){
				   if(msg.resultcode<0){
					   BUI.Message.Alert('没有权限执行此操作','error');
					   return false ; 
					}else if(msg.resultcode == 0 ){
						BUI.Message.Alert(msg.resultinfo.errmsg ,'error');
						common_request();
						return false ;				
					}else{
						common_request();
					}
			   },
			   beforeSend:function(){
				  $("#result_").html('<font color="red"><img src="<?php echo base_url();?>/<?php echo APPPATH?>/views/static/Images/progressbar_microsoft.gif"></font>');
			   },
			   error:function(){
				   BUI.Message.Alert('服务器繁忙请稍后','error');
			   }
			  
	});		
	
}
function more_search(){
	$("#more_search").toggle();
}
//添加新闻
function add_news(){
	 top.topManager.openPage({
		 id : '#',
		 href  : '<?php echo site_url('news/add');?> ' ,
		 title : '添加新闻' ,
		 reload:true
		// isClose:true
	});
	// top.topManager.closePage('87'); //关闭已经打开的	
}
</script>



