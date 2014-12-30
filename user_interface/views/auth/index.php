<?php $this->load->view('inc/header_guest'); ?>
<style type="text/css">
    .page-header {
        margin: 0 auto;
        border-bottom: 1px solid #eeeeee;
        text-align: center;
    }
</style>

<div class="text-center">
    <img src="/static/logo.png">
</div>

<div class="well login">
  <div class="page-header">
    <h1 style="font-size: 20px;">账户登录</h1>
  </div>
  <?php
  echo form_open('auth/authenticate');

  if (isset($login_error)) {
        echo '<div class="alert alert-error"><strong>' . $login_error . '</strong></div>';
  }
  echo form_label('邮箱地址', 'email_address');
  echo form_input('email_address', $email);

  echo form_label('密码', 'password');
  echo form_password('password');
  ?>
  <p class="text-left">
  <?php
  echo form_button(array('id' => 'submit', 'value' => 'Login', 'name' => 'submit', 'type' => 'submit', 'content' => '登录','class' => 'btn btn-primary '));
  ?>
  </p>
  <?php
  echo form_close();
  ?>
    <p>
        <a href="<?php echo site_url('auth/forgotpassword'); ?>">忘记密码?</a>
        <a href="<?php echo site_url('auth/reg'); ?>" class="pull-right">立即注册</a>
    </p>
</div>
<?php $this->load->view('inc/footer_guest'); ?>
