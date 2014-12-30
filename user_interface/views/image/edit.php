<?php $this->load->view('inc/header'); ?>
<link href="/static/select2/select2.css" rel="stylesheet"/>
<link href="/static/bootstrap-switch/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
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
	.bootstrap-switch {
		margin-bottom: 10px
	}
	.bootstrap-switch > div {
	    white-space: nowrap;
	}
	.bootstrap-switch > div > span,
	.bootstrap-switch > div > label {
	    width: 100px;
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
	echo form_label('标题 <span class="red">*</span>', 'name');
	echo form_input(array('name' => 'name', 'id' => 'name', 'value' => $image->name));
?>

<label for="self">作者 <span class="red">*</span></label>
<div class="switch">
    <input type="checkbox" name="self" checked="checked"/>
</div>
<div id="others" style="display:none">
<?php
	echo form_label('拍摄作者', 'author');
	echo form_input(array('name' => 'author', 'id' => 'author', 'value' => $image->author));
?>
<?php
	echo form_label('单位（或通讯地址）', 'author_address');
	echo form_input(array('name' => 'author_address', 'id' => 'author_address', 'value' => $image->author_address));
?>
<?php
	echo form_label('联系方式', 'author_tel');
	echo form_input(array('name' => 'author_tel', 'id' => 'author_tel', 'value' => $image->author_tel));
?>
</div>
<?php echo form_label('分类 <span class="red">*</span>', 'maincat');?>
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

<select id="cats_front" multiple="multiple" style="width: 40%;">
	<?php if (!empty($cat_array)) { ?>
		<?php foreach ($cat_array as $key => $value): ?>
			<option value="<?php echo $value->id;?>" selected="selected"><?php echo $value->typename;?></option>
		<?php endforeach ?>
	<?php } ?>
</select>

<select id="cats_back" name="cats[]" multiple="multiple" style="display:none;">
	<?php if (!empty($cat_array)) { ?>
		<?php foreach ($cat_array as $key => $value): ?>
			<option value="<?php echo $value->id;?>" selected="selected"><?php echo $value->typename;?></option>
		<?php endforeach ?>
	<?php } ?>
</select>
    
<?php
	echo form_label('拍摄地点 <span class="red">*</span>', 'location');
	echo form_input(array('name' => 'location', 'id' => 'location', 'value' => $image->location));
?>

<?php
	echo form_label('自定义标签', 'tag');
	echo form_input(array('name' => 'tag', 'id' => 'tags', 'value' => $image->tags));
?>

<input type="hidden" name="published" value="1" checked="checked">

<?php 
	echo form_label('详细说明', 'caption');
	echo form_textarea(array('name' => 'caption', 'id' => 'caption', 'value' => $image->caption));
	echo form_fieldset_close(); 
?>

<div id="img"><img src="<?php echo site_url("imagedata/{$image->uuid}?type=premium"); ?>" alt="<?php echo $image->name; ?>" /></div>

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
<script type="text/javascript" src="/static/bootstrap-switch/js/bootstrap-switch.js"></script>
<link rel="stylesheet" href="/static/ueditor/themes/default/css/ueditor.css"/>
<script type="text/javascript">
	$(document).ready(function() { 
		$("#maincat").select2({
			placeholder: "选择一级分类",
			width:160,
  			allowClear: true,
		}).on("change", function(e) {
			$.post("<?php echo site_url('image/select_cat/');?>",{pid:e.val},function(result){
			    $("#cats_front").html(result);
			});
		});

		$("#cats_front").select2({
			maximumSelectionSize: 8
		}).on("change", function(e) { 

			if (e.added) {
				$("#cats_back").append("<option value='"+e.added.id+"' selected></option>");
			}else if (e.removed) {
				$("#cats_back option[value='"+e.removed.id+"']").remove();
			}

		});
		
	});
	$('.switch input').bootstrapSwitch({
		size : 'large',
		animate : true,
		onText : '自己',
		offText : '其他',
		onSwitchChange : function(event, state) {
			if ( state ) {
				$("#others").hide();
			}else {
				$("#others").show();
			}
		}
	});
	<?php if ($image->is_self == 0) { ?>
		$('.switch input').bootstrapSwitch('state', false, false);
	<?php } ?>

    var editor = new baidu.editor.ui.Editor({initialFrameHeight:300,initialFrameWidth:'80%' });
    editor.render("caption");
</script>

<?php $this->load->view('inc/footer'); ?>