<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>添加新闻</title>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/static/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/style.css" />   
	<link rel="stylesheet" type="text/css" href="/static/assets/css/dpl-min.css" />   
	<script type="text/javascript" src="/static/js/DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="/static/assets/js/jquery-1.8.1.min.js"></script>
	<script type="text/javascript" src="/static/js/validate/validator.js"></script>   
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
   <a  class="btn btn-primary" id="addnew" href="<?php echo site_url("news/index");?>">新闻列表数据</a>
</div>
<form action="<?php echo site_url("news/add");?>" method="post" class="definewidth m20" id="myform" enctype="multipart/form-data">
<input type="hidden" value="doadd" name="action">
<input type="hidden" value="" name="typename" id="typename">
<input type="hidden" value="" name="fromname" id="fromname">
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td width="10%" class="tableleft">标题</td>
        <td><input type="text" name="title" placeholder="标题" required="true" style="width:300px"/></td>
    </tr>
    <tr>
        <td width="10%" class="tableleft">文档属性</td>
        <td>
			<?php 
				if(isset($this->news_attr)){
					foreach($this->news_attr as $attr_key => $attr_val){
						echo "<input type='checkbox' name='flag[]' value='{$attr_key}'>".$attr_val."&nbsp;&nbsp;" ;
					}
				}
			?>
		</td>
    </tr>
    <tr height="240px">
        <td width="10%" class="tableleft">缩略图</td>
        <td>
        <input type="file" name="image" />
        <div style="width:294px;height:184px;">

        <img src="/static/images/icon_form_upload.png" width="294px" height="184px" />

        </div>
        </td>
    </tr>	
     <tr>
        <td class="tableleft">类型</td>
        <td>
         <select name="type" style="width:300px" onchange="_typename()" id="type">
			<option value="">请选择</option>
         	<?php 
         		if(isset($category) && $category ){
         			foreach($category as $c_key=>$c_v){
         	?>
         	  <option value="<?php echo $c_v->id ; ?>" ><?php echo $c_v->typename;?></option>
         	<?php 
         		}
         	}
         	?>
         </select>
        </td>
    </tr> 	
    <!-- <tr>
        <td width="10%" class="tableleft">url</td>
        <td><input type="text" name="url" placeholder="url" style="width:300px"/></td>
    </tr> -->
     
     <tr>
        <td width="10%" class="tableleft">关键词</td>
        <td>
       <input type="text" name="keysword" placeholder="多个关键词请用逗号隔开" style="width:300px"/>
       </td>
    </tr> 
       <tr>
            <td width="10%" class="tableleft">摘要</td>
            <td>
                <textarea style="width:100%; height:150px" name="introduce" placeholder="摘要"></textarea>
            </td>
        </tr>  
       <!-- <tr>
            <td width="10%" class="tableleft">权重</td>
            <td>
           <input type="text" name="weight" placeholder="权重" value="0" style="width:300px"/>
           </td>
        </tr>  -->   
     <tr>
        <td class="tableleft">内容</td>
        <td>
          <textarea id="content" name="content" ></textarea>
        </td>
    </tr> 
     
     <tr>
        <td class="tableleft">来源</td>
        <td>
         <select name="from" id="from" onchange="_from()">
			<option value="0">不限</option>
         	<?php 
         		if(isset($from) && $from ){
         			foreach($from as $f_key=>$f_v){
         		
         	?>
         	<option value="<?php echo $f_v['id'] ; ?>"><?php echo $f_v['name'] ; ?></option>
         	<?php 
         					
         		}
         	}
         	?>
         </select>
        </td>
    </tr>   
    <tr>
        <td class="tableleft">添加日期</td>
        <td>
           <input type="text" name="create_date" id="create_date" class="Wdate" placeholder="" value="<?php echo date("Y-m-d H:i:s",time());?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',isShowClear:true,readOnly:true})"  style="width:300px" readonly>
        </td>
    </tr>
    <tr>
        <td class="tableleft">点击数量</td>
        <td>
           <input type="text" name="click" id="click" value="10">
        </td>
    </tr> 
    <tr>
        <td class="tableleft">作者</td>
        <td>
           <input type="text" name="addperson" id="addperson" value="<?php echo $this->username;?>">
        </td>
    </tr> 	
    <tr>
        <td class="tableleft">状态</td>
        <td>
            <input type="radio" name="status" value="1" checked/> 显示
           <input type="radio" name="status" value="0"/> 隐藏
        </td>
    </tr>
    	
    <tr>
        <td class="tableleft"></td>
        <td>
            <button type="submit" class="btn btn-primary" type="button" id="btnSave">保存</button> &nbsp;&nbsp;
        </td>
    </tr>
</table>
</form>
</body>
</html>
<script>
$(function () {   
	var typeid = getQueryStringValue("typeid");
	$("#type").find("option[value='"+typeid+"']").attr("selected",true);
	$("#btnSave").click(function(){		
		if($("#myform").Valid() == false || !$("#myform").Valid()) {
			return false ;
		}
	});
});
</script>
<script type="text/javascript" src="/static/js/kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="/static/js/kindeditor/lang/zh_CN.js"></script>
<script>
KindEditor.ready(function(K) {
       window.editor = K.create('#content',{
				width:'100%',
				height:'400px',
				allowFileManager:false ,
				allowUpload:false,
				afterCreate : function() {
					this.sync();
				},
				afterBlur:function(){
				      this.sync();
				},
				extraFileUploadParams:{
					'cookie':'<?php echo $_COOKIE['admin_auth'];?>'
				},
				uploadJson:"<?php echo site_url("news/index");?>?action=upload&session=<?php echo session_id();?>"
						
       });
});
function _typename(){
	$("#typename").val($.trim($("#type option:selected").text()));	
}
function _from(){
	$("#fromname").val($.trim($("#from option:selected").text()));	
}
</script>
<script type="text/javascript" src="/static/js/upload.js"></script>
<script>
$(document).ready(function () {
	$('#myform').formBeauty();
}) ;
</script>