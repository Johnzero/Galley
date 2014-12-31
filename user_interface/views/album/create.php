<?php $this->load->view('inc/header'); ?>

<h1>创建</h1>

<div class="well">
<?php
echo form_open('album/add');

echo form_fieldset('相册信息');

echo form_label('标题', 'album_name');
echo form_input( array('name' => 'album_name', 'value'=>set_value('album_name')) );
echo form_error('album_name');

echo form_label('相册说明', 'album_content');
echo form_textarea( array('name'=> 'album_content','id'=> 'album_content', 'value'=>set_value('album_content') ));
echo form_error('album_content');

echo form_fieldset_close(); 

echo form_button(array('id' => 'submit', 'value' => 'Add', 'name' => 'submit', 'type' => 'submit','style'=>'margin-top: 20px;', 'content' => '添加','class' => 'btn btn-primary'));
?>

<a href="<?php echo site_url('album'); ?>" class="btn" style="margin-top: 20px;">取消</a>

<?php
echo form_close();
?>

</div>

<script type="text/javascript">
$(document).ready(function() {
	$('form:not(.filter) :input:visible:first').focus();
});
</script>
<script type="text/javascript" src="/static/ueditor/ueditor_config.js"></script>
<script type="text/javascript" src="/static/ueditor/ueditor_all.js"></script>
<link rel="stylesheet" href="/static/ueditor/themes/default/css/ueditor.css"/>
<script type="text/javascript">
    var editor = new baidu.editor.ui.Editor({initialFrameHeight:400,initialFrameWidth:'80%' });
    editor.render("album_content");
</script>

<?php $this->load->view('inc/footer'); ?>
