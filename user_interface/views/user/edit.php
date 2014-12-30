<?php $this->load->view('inc/header'); ?>

<h1>更新</h1>

<div class="well">
<?php
echo form_open("user/update/$user->id");

echo form_fieldset('用户信息');

echo form_label('邮箱地址 <span class="red">*</span>', 'email_address');
echo form_input(array('name' => 'email_address', 'id' => 'email_address', 'value' => $user->email_address));
echo form_error('email_address');

echo form_label('密码 (留空则不修改)', 'password');
echo form_password('password');
echo form_error('password');

echo form_label('再输一遍', 'password_conf');
echo form_password('password_conf');
echo form_error('password_conf');

echo form_label('姓名 <span class="red">*</span>', 'name');
echo form_input(array('name' => 'name', 'id' => 'name', 'value' => $user->name));
echo form_error('name');

echo form_label('联系方式 <span class="red">*</span>', 'tel');
echo form_input(array('name' => 'tel', 'id' => 'tel', 'value' => $user->tel));
echo form_error('tel');

echo form_label('单位（或通讯地址）', 'address');
echo form_input(array('name' => 'address', 'id' => 'address', 'value' => $user->address));
echo form_error('address');

if ($this->session->userdata('is_admin') == 1) {
	
echo form_label('启用', 'is_active');
echo form_checkbox('is_active', '1', $user->is_active);

echo form_label('管理员', 'is_admin');
echo form_checkbox('is_admin', '1', $user->is_admin);

}

echo form_fieldset_close(); 

echo form_button(array('id' => 'submit', 'value' => 'Update', 'name' => 'submit', 'type' => 'submit', 'content' => '更新','class' => 'btn btn-primary'));
?>
 <a href="<?php echo site_url('user'); ?>" class="btn">取消</a>
<?php
echo form_close();
?>
</div>

<?php $this->load->view('inc/footer'); ?>
