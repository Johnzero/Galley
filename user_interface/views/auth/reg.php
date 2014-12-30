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
        <h1 style="font-size: 20px;">账户注册</h1>
    </div>
    <?php
        echo form_open('auth/reg');

        if (isset($login_error)) {

            echo '<div class="alert alert-error"><strong>' . $login_error . '</strong></div>';

        }

        echo form_error('email_address');
        echo form_label('邮箱地址', 'email_address');
        echo form_input('email_address');

        echo form_error('name');
        echo form_label('姓名 <span class="red">*</span>', 'name');
        echo form_input(array('name' => 'name', 'id' => 'name'));

        echo form_error('tel');
        echo form_label('联系方式 <span class="red">*</span>', 'tel');
        echo form_input(array('name' => 'tel', 'id' => 'tel'));

        echo form_error('address');
        echo form_label('单位（或通讯地址）<span class="red">*</span>', 'address');
        echo form_input(array('name' => 'address', 'id' => 'address'));

        echo form_error('password');
        echo form_label('密码 <span class="red">*</span>', 'password');
        echo form_password('password');

        echo form_error('password_conf');
        echo form_label('重新键入密码 <span class="red">*</span>', 'password_conf');
        echo form_password('password_conf');

        echo form_fieldset_close();

        echo form_button(array('id' => 'submit', 'value' => 'Add', 'name' => 'submit', 'type' => 'submit', 'content' => '注册','class' => 'btn btn-primary'));
        echo form_close();
    ?>
    
    <p>
        <a href="<?php echo site_url('auth/'); ?>">返回登录</a>
        <a href="<?php echo site_url('auth/forgotpassword'); ?>" class="pull-right">忘记密码?</a>
    </p>
</div>
<?php $this->load->view('inc/footer_guest'); ?>
