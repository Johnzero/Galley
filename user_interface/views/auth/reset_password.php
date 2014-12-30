<?php $this->load->view('inc/header_guest'); ?>

<div class="text-center">
    <img src="/static/logo.png">
</div>


<div class="well login">
  <div class="page-header text-center">
    <h1 style="font-size: 20px;">重置密码</h1>
  </div>

<?php
if (isset($error)) {
  echo '<div class="alert alert-error"><strong>' . $error . '</strong></div>';
} else {
  echo form_open("auth/resetpassword/$uuid");
  
  echo form_error('password');
  echo form_label('新密码', 'password');
  echo form_password('password');
  
  echo form_error('password_conf');
  echo form_label('再输一次', 'password_conf');
  echo form_password('password_conf');
  
  echo form_fieldset_close(); 
  
  echo form_button(array('id' => 'submit', 'value' => 'Save New Password', 'name' => 'submit', 'type' => 'submit', 'content' => '保存新密码','class' => 'btn btn-primary'));
  
  echo form_close();
}
?>
    <p>
        <a href="<?php echo site_url('auth'); ?>">返回登录</a>
        <a href="<?php echo site_url('auth/forgotpassword'); ?>" class="pull-right">立即注册</a>
    </p>
</div>

<?php $this->load->view('inc/footer_guest'); ?>
