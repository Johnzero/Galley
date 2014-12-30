<?php $this->load->view('inc/header'); ?>
<link href="/static/select2/select2.css" rel="stylesheet"/>
<style type="text/css">
	input {
		width: 50%;
	}
	#caption {
		margin-bottom: 10px;
	}
	#img {
		margin-bottom: 20px;
	}
</style>

<h1>编辑</h1>

<?php if (isset($flash)): ?>
<div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong><?php echo $flash; ?></strong></div>
<?php endif; ?>

<div class="well">
<?php
echo form_open_multipart("image/edit/$album->id/$image->id");
if (isset($error)) {
  echo '<div class="alert alert-error"><strong>' . $error . '</strong></div>';
}
echo form_fieldset('图片信息');
?>

<?php
	echo form_label('标题', 'name');
	echo form_input(array('name' => 'name', 'id' => 'name', 'value' => $image->name));
?>

<?php echo form_label('分类', 'maincat');?>
<select id="maincat" name='maincat'>
	<?php if (!empty($m_c)) { ?>
		<option value="">选择分类</option>
		<?php foreach ($m_c as $key => $value): ?>
			<option value="<?php echo $value->id;?>"><?php echo $value->typename;?></option>
		<?php endforeach ?>
	<?php } else { ?>
		<option value="">暂无分类</option>
	<?php } ?>
</select>
<select name="cats[]" id="cats" multiple="multiple" style="width: 40%;">

</select>
<!-- <input type="hidden" id="cats" name="cats[]" style="width: 40%;"> -->

<input type="hidden" name="published" value="1" checked="checked">

<?php 
	echo form_label('详细说明', 'caption');
	echo form_textarea(array('name' => 'caption', 'id' => 'caption', 'value' => $image->caption));
	echo form_fieldset_close(); 
?>

<div id="img"><img src="<?php echo ltrim($image->path . $image->raw_name. $image->file_ext,'.'); ?>" alt="<?php echo $image->name; ?>" /></div>

<?php 
	echo form_button(array('id' => 'submit', 'value' => 'Update', 'name' => 'submit', 'type' => 'submit', 'content' => '更新','class' => 'btn btn-primary'));
?>
<a href="<?php echo site_url('album/images/' . $album->id); ?>" class="btn">取消</a>
<?php
	echo form_close();
?>
</div>

<script type="text/javascript" src="/static/select2/select2.js"></script>
<script type="text/javascript" src="/static/select2/select2_locale_zh-CN.js"></script>
<script type="text/javascript" src="/static/ueditor/ueditor_config.js"></script>
<script type="text/javascript" src="/static/ueditor/ueditor_all.js"></script>
<link rel="stylesheet" href="/static/ueditor/themes/default/css/ueditor.css"/>
<script type="text/javascript">
	$(document).ready(function() { 

		$("#cats").select2({
			maximumSelectionSize: 8
		});

		$("#maincat").select2({
			placeholder: "选择一级分类",
			width:160,
  			allowClear: true,
		}).on("change", function(e) {
		    $("#cats").select2({
		    	query:function(query){
				    var data = {results: []};
				    data.results.push({id:1,text:"asdfasdf"});
				    query.callback(data);
				}
			});
		});
		
	});
    var editor = new baidu.editor.ui.Editor({initialFrameHeight:300,initialFrameWidth:'80%' });
    editor.render("caption");
</script>

<?php $this->load->view('inc/footer'); ?>