<?php $this->load->view('inc/header_guest'); ?>


<div class="text-center">
    <img src="/static/logo.png">
</div>


<div class="well login">
	<div class="page-header text-center">
		<h1 style="font-size: 20px;">邮件已送达</h1>
	</div>


	<p>邮件已经发送到您的邮箱。</p>
	<p>请登录邮箱后修改密码！</p>

    <p style="margin-top: 40px">
        <a href="<?php echo site_url('auth'); ?>">返回登录</a>
        <a href="<?php echo site_url('auth/forgotpassword'); ?>" class="pull-right">立即注册</a>
    </p>
</div>

<?php $this->load->view('inc/footer_guest'); ?>
