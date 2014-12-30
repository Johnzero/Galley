<?php $this->load->view('inc/header'); ?>

<h1>编辑</h1>

<div class="well">
<?php
echo form_open("album/update/$album->id");

echo form_fieldset('相册');

echo form_label('名称', 'album_name');
echo form_input(array('name' => 'album_name', 'id' => 'album_name', 'value' => $album->name));
echo form_error('album_name');

echo form_label('说明', 'album_content');
echo form_textarea(array('name'=> 'album_content','id'=> 'album_content','value' => $album->content));
echo form_error('album_content');

echo form_fieldset_close(); 

echo form_button(array('id' => 'submit', 'value' => 'Update', 'name' => 'submit','style'=>'margin-top: 20px;', 'type' => 'submit', 'content' => '更新','class' => 'btn btn-primary'));
?>
 <a href="<?php echo site_url('album'); ?>" class="btn" style="margin-top: 20px;">取消</a>
<?php
echo form_close();
?>
</div>

<script type="text/javascript" src="/static/ueditor/ueditor_config.js"></script>
<script type="text/javascript" src="/static/ueditor/ueditor_all.js"></script>
<link rel="stylesheet" href="/static/ueditor/themes/default/css/ueditor.css"/>
<script type="text/javascript">
    var editor = new baidu.editor.ui.Editor({initialFrameHeight:400,initialFrameWidth:'90%' });
    editor.render("album_content");
</script>

<?php $this->load->view('inc/footer'); ?>
