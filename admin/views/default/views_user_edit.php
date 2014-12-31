<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>用户编辑__<?php echo $info['username'];?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/style.css" />   
	<script type="text/javascript" src="/static/assets/js/jquery-1.8.1.min.js"></script> 	
	<script type="text/javascript" src="/static/assets/js/bui-min.js"></script>
	<script type="text/javascript" src="/static/js/validate/validator.js"></script>
	<link href="/static/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
    <link href="/static/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
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
   <a  class="btn btn-primary" id="addnew" href="<?php echo site_url("user/index");?>">网站用户管理</a>
</div>
<form action="<?php echo site_url("user/edit");?>" method="post" name="">
<input type="hidden" name="action" value="doedit">
<input type="hidden" name="id" value="<?php echo $user['id'];?>">
<table class="table table-bordered table-hover m10">
    <?php
    echo form_fieldset('用户信息');

    echo form_label('邮箱地址 <span class="red">*</span>', 'email_address');
    echo form_input(array('name' => 'email_address', 'id' => 'email_address', 'value' => $user['email_address']));
    echo form_error('email_address');

    echo form_label('密码 (留空则不修改)', 'password');
    echo form_password('password');
    echo form_error('password');

    echo form_label('再输一遍', 'password_conf');
    echo form_password('password_conf');
    echo form_error('password_conf');

    echo form_label('姓名 <span class="red">*</span>', 'name');
    echo form_input(array('name' => 'name', 'id' => 'name', 'value' => $user['name']));
    echo form_error('name');

    echo form_label('联系方式 <span class="red">*</span>', 'tel');
    echo form_input(array('name' => 'tel', 'id' => 'tel', 'value' => $user['tel']));
    echo form_error('tel');

    echo form_label('单位（或通讯地址）', 'address');
    echo form_input(array('name' => 'address', 'id' => 'address', 'value' => $user['address']));
    echo form_error('address');

    echo form_label('启用', 'is_active');
    echo form_checkbox('is_active', '1', $user['is_active']);

    echo form_fieldset_close(); 

    echo form_button(array('id' => 'submit', 'value' => 'Update', 'name' => 'submit', 'type' => 'submit', 'content' => '更新','class' => 'btn btn-primary'));
    ?>
	  
</table>
</form>	   
</body>
</html>
<!-- script start-->
<script type="text/javascript">
	var Calendar = BUI.Calendar
	var datepicker = new Calendar.DatePicker({
	trigger:'#expire',
	showTime:true,
	autoRender : true
	});
</script>
<!-- script end -->
