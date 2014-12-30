<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>图片分类添加</title>
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
<form action="#" method="post" class="definewidth m20" id="myform_add" style="height:330px ; overflow:auto">
<input type="hidden" value="<?php echo isset($typeid)?$typeid:'' ;?>" name="typeid">
<input type="hidden" value="<?php echo isset($pid)?$pid:'' ;?>" name="pid">
<input type="hidden" value="doadd" name="action">

<table class="table table-bordered table-hover definewidth m10" >
    <tr>
        <td width="10%" class="tableleft">类别名称</td>
        <td><input type="text" id="typename" name="typename" placeholder="类别名称" required="true"/></td>
    </tr>
     <tr>
        <td width="10%" class="tableleft">排序</td>
       
        <td><input type="text" name="disorder" placeholder="排序" value="0" id="disorder" /></td>
     
    </tr> 
    <tr>
        <td width="10%" class="tableleft">SEO标题</td>
        <td><input type="text" id="seotitle" name="seotitle" placeholder="seo标题"/></td>
    </tr>	
    <tr>
        <td width="10%" class="tableleft">关键字</td>
        <td><input type="text" id="keywords" name="keywords" placeholder="关键字"/></td>
    </tr>	
</table>
</form>
</body>
</html>
