<?php $this->load->view('inc/header'); ?>

<h1>添加用户</h1>

<div class="well">
<?php
echo form_open('user/add');

echo form_fieldset('用户信息');

echo form_error('email_address');
echo form_label('邮箱地址', 'email_address');
echo form_input( array('name' => 'email_address', 'value'=>set_value('email_address')) );

echo form_error('password');
echo form_label('密码', 'password');
echo form_password( array('name' => 'password', 'value'=>set_value('password')) );

echo form_error('password_conf');
echo form_label('重新键入密码', 'password_conf');
echo form_password( array('name' => 'password_conf', 'value'=>set_value('password_conf')) );

echo form_label('激活?', 'is_active');
echo form_checkbox('is_active', '1', TRUE);

echo form_label('管理员?', 'is_admin');
echo form_checkbox('is_admin', '1', FALSE);

echo form_fieldset_close();

echo form_button(array('id' => 'submit', 'value' => 'Add', 'name' => 'submit', 'type' => 'submit', 'content' => '添加','class' => 'btn btn-primary'));
?>
 <a href="<?php echo site_url('user'); ?>" class="btn">取消</a>
<?php
echo form_close();
?>
</div>

<?php $this->load->view('inc/footer'); ?>
