<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>修改图片分类</title>
    <meta charset="UTF-8">
	
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
<form action="# " method="post" class="definewidth m20" id="myform_edit" style="height:420px ; overflow:auto">
<input type="hidden" value="doedit" name="action">
<input type="hidden" value="<?php echo isset($id)?$id:'' ;?>" name="id">
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td width="20%" class="tableleft">名称</td>
        <td><input type="text" id="typename" name="typename" placeholder="名称" required="true" value="<?php echo $info['typename'];?>"/></td>
    </tr>
    <tr>
        <td width="10%" class="tableleft">SEO标题</td>
        <td><input type="text" id="seotitle" name="seotitle" placeholder="seo标题" value="<?php echo $info['seotitle'];?>"/></td>
    </tr>	
    <tr>
        <td width="10%" class="tableleft">关键字</td>
        <td><input type="text" id="keywords" name="keywords" placeholder="关键字" value="<?php echo $info['keywords'];?>"/></td>
    </tr>	
    <tr>
        <td width="20%" class="tableleft">排序</td>
       
        <td><input type="text" name="disorder" placeholder="排序"  id="disorder" value="<?php echo $info['disorder'];?>"/></td>
     
    </tr> 

    <tr>
        <td width="20%" class="tableleft">图标</td>
        <td>
            <textarea name="ico" placeholder="图标"  id="ico" style="width:250px"><?php echo $info['ico'];?></textarea>
        </td>
    </tr>
  
</table>
</form>
</body>
</html>
<script>
/*
    $(function () {    
	$("#btnSave").click(function(){
			if($("#myform").Valid() == false || !$("#myform").Valid()) {
				return false ;
			}
	});
    });*/
</script>