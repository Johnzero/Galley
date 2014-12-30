<?php
$includes = array(
    'js' => array('jquery-ui.min.js', 'jquery.cookie.js','swfobject.js', 'jquery.uploadify.v2.1.4.min.js', 'fancybox/jquery.fancybox-1.3.4.pack.js'), 
    'css' => array('uploadify.css', 'fancybox/jquery.fancybox-1.3.4.css'));
?>
<?php $this->load->view('inc/header', $includes); ?>
<style type="text/css">
    .pagination {text-align: center;}

</style>
<?php if (isset($flash)): ?>
<div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong><?php echo $flash; ?></strong></div>
<?php endif; ?>

<div class="w100" style="margin-bottom: 10px;">
  
    <ul class="pager">
        <li class="previous">
            <a href="<?php echo site_url('album'); ?>">返回我的相册</a>
        </li>
    </ul>
  
  <div class="well">
    <h4 style="margin-bottom: 10px;">上传文件到 : <?php echo $album->name; ?></h4>
    <input id="file_upload" type="file" name="file_upload" />
    <p id="upload-btn" style="margin:10px 0;">
      <a href="javascript:$('#file_upload').uploadifyUpload()" class="btn btn-primary btn-large">上传</a>
    </p>
    <div id="new-images">
      <h4>已上传图片：</h4>
      <p><a class="btn" href="<?php echo site_url("album/images/$album->id"); ?>" style="margin: 10px 0;"><i class="icon-refresh"></i> 刷新 </a></p>
      <ul id="new-image-list"></ul>
      <div class="clear"></div>
    </div>
  </div>
</div>

<div id="reorder-feedback" class="alert alert-success" style="display: none;"></div>

<div class="alert alert-success">
    <a id="close_re"  class="close" data-dismiss="alert">x</a>
    <strong>请将完善图片明细信息！</strong>
</div>

<span class="left w75">
<?php 
    $img_url = '';
?>
  <?php if (isset($images)): ?>
  <ul id="sortable">
    <?php foreach ($images as $image): ?>
    <li id="image_<?php echo $image->id; ?>" class="ui-state-default" style="height: <?php echo $config->thumb_height + 10; ?>px">
      <div class="drag-handle" style="height: <?php echo $config->thumb_height + 5; ?>px"></div>
      <div class="image-container">
        <a class="album-images img-fancy thumbnail" href="<?php echo site_url("imagedata/{$image->uuid}?type=large"); ?>" title="<?php echo $image->name; ?>">
          <img  data-link="<?php echo site_url("home/zip_load/{$image->uuid}"); ?>" src="<?php echo site_url("imagedata/{$image->uuid}?type=small"); ?>" alt="<?php echo $image->name; ?>" style="max-height: 100px"/>
        </a>
      </div>
      <div class="info" style="left: <?php echo $config->thumb_width + 50; ?>px">
        标&nbsp;题：&nbsp;&nbsp;<span class="sub-text-color"><?php echo $image->name; ?> </span> <br />
        标&nbsp;签：&nbsp;&nbsp;<span class="sub-text-color"><?php echo $image->tags; ?> </span> <br />
        分&nbsp;类：&nbsp;&nbsp;<span class="sub-text-color"><?php echo $image->id; ?> </span> <br />
        作&nbsp;者：&nbsp;&nbsp;<span class="sub-text-color"><?php echo $image->author; ?> </span> <br />
        <?php /* Comments: <?php echo $image->comments; ?><br /> */ ?>
        大&nbsp;小：&nbsp;&nbsp;<span class="sub-text-color"><?php echo round($image->file_size / 1024, 2); ?> MB </span><br />

      </div>
      <div class="btn-group">

        <?php if ( $image->author && $image->cats && $image->location )  { ?>
            <a href="<?php echo site_url("image/edit/$album->id/$image->id"); ?>" class="btn" title="编辑" rel="tooltip" data-original-title="编辑"><i class="icon-pencil"></i></a>
        <?php }else { ?>
            <a href="<?php echo site_url("image/edit/$album->id/$image->id"); ?>" class="btn btn-danger" title="编辑" rel="tooltip" data-original-title="编辑"><i class="icon-pencil icon-white"></i></a>
        <?php } ?>

        <a href="<?php echo site_url("imagedata/{$image->uuid}?type=large"); ?>" class="btn img-fancy" rel="tooltip" data-original-title="预览"><i class="icon-zoom-in"></i></a>

        <a href="<?php echo site_url("home/zip_load/{$image->uuid}"); ?>" class="btn" title="下载" rel="tooltip" data-original-title="下载"><i class="icon-download-alt"></i></a>
        <?php /* <a href="<?php echo site_url("image/comments/$album->id/$image->id"); ?>" class="btn" title="Comments" rel="tooltip" data-original-title="Comments"><i class="icon-comment"></i></a> */ ?>
<!--         <?php if ($image->published == 1): ?>
        <a href="<?php echo site_url("image/unpublish/$album->id/$image->id"); ?>" class="btn btn-success" title="发布" rel="tooltip" data-original-title="发布"><i class="icon-ok icon-white"></i></a>
        <?php else: ?>
        <a href="<?php echo site_url("image/publish/$album->id/$image->id"); ?>" class="btn" title="取消发布" rel="tooltip" data-original-title="取消发布"><i class="icon-ok"></i></a>
        <?php endif; ?> -->
        <a href="#image-modal" class="btn btn-danger image-delete-btn" title="删除" rel="tooltip" action="<?php echo site_url("image/remove/$album->id/$image->id"); ?>" data-toggle="modal" data-original-title="删除"><i class="icon-remove icon-white"></i></a>
      </div>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php endif; ?>
</span>
<span class="right w20">
  <div class="well sidebar-nav">
    <ul class="nav nav-list">
      <li class="nav-header"><?php echo $album->name; ?></li>
      <li><a href="<?php echo site_url("album/edit/$album->id"); ?>"><i class="icon-pencil"></i>重命名</a></li>
      <li><a href="<?php echo site_url("album/configure/$album->id"); ?>"><i class="icon-cog"></i>配置</a></li>
      <li><a href="<?php echo site_url("api/feed/json/$album->uuid"); ?>" target="_blank"><i class="icon-book"></i>JSON 源</a></li>
      <li><a href="<?php echo site_url("api/feed/xml/$album->uuid"); ?>" target="_blank"><i class="icon-book"></i>XML 源</a></li>
      <li class="nav-header">明细</li>
      <li>数量: <?php echo $total; ?> 张</li>
      <?php if ( round($total_file_size / 1024, 2) > 1000 ) {$total_file_size = round($total_file_size / 1024 / 1024, 2)." GB";}else {$total_file_size = round($total_file_size / 1024, 2)." MB";} ?>
      <li>大小: <?php echo $total_file_size; ?> </li>
    </ul>
  </div>
</span>
<div class="clear"></div>

<?php echo $this->pagination->create_links(); ?>

<div class="modal hide fade" id="image-modal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>删除图片</h3>
  </div>
  <div class="modal-body">
    <p><strong>确定删除该张图片？</strong></p>
  </div>
  <div class="modal-footer">
    <a id="image-modal-delete-btn" href="#" class="btn btn-danger">确认删除</a>
    <a href="#" class="btn" data-dismiss="modal">取消</a>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('.btn-group > a').tooltip();
  $('#upload-btn').hide();
  $('#new-images').hide();
    
    $("#close_re").click(function () {
        $.cookie('pic_detail', '1', { expires: 0.3 });
    })

    if ( $.cookie('pic_detail') == 1 ) {
        $("#close_re").parent().hide();
    }

    $('a.img-fancy').fancybox();

    $('.image-delete-btn').click(function() {
        deleteUrl = $(this).attr('action');
    });
  
    $('#image-modal').on('show', function() {
        $('#image-modal-delete-btn').attr('href', deleteUrl);
    });
  
  $("#sortable").sortable({
    handle : '.drag-handle',
    update : function () { 
      var order = $('#sortable').sortable('serialize', { key : 'order_num[]' }); 
      $.ajax({
        url          : '<?php echo base_url(); ?>album/reorder?' + order,
        type         : 'GET',
        cache        : false,
        success      : function(response) {
          $('#reorder-feedback').show();
          $('#reorder-feedback').html('<a class="close" data-dismiss="alert">x</a><strong>图片顺序改变。</strong>');
        },
        error        : function(jqXHR, textStatus, errorThrown) {
          alert('An error occured when ordering the images.');
        }
      });
    }
  });
  $( "#sortable" ).disableSelection();
  $('#file_upload').uploadify({
    'uploader'       : '/static/flash/uploadify.swf',
    'script'         : '<?php echo base_url(); ?>api/upload/<?php echo $album->id; ?>',
    'cancelImg'      : '/static/images/cancel.png',
    'folder'         : '/uploads',
    'auto'           : false,
    'multi'          : true,
    'scriptData'     : { 'user_id' : '<?php echo $user_id; ?>' },
    'fileExt'        : '*.jpg;*.jpeg;*.gif;*.png',
    'fileDesc'       : 'Image files',
    'buttonText'     :'批量选择',
    'width'          : 110,  
    'sizeLimit'      : 209715200, // 200MB
    'wmode'          : 'opaque',
    'onSelect'       : function(event, ID, fileObj) {
      $('#upload-btn').show();
    },
    'onCancel'       : function(event, ID, fileObj) {
      $('#upload-btn').hide();
    },
    'onError'        : function(event, ID, fileObj, errorObj) {
      
    },
    'onComplete'     : function(event, ID, fileObj, response, data) {
      var fileName = response;
      $('#upload-btn').hide();
      $('#new-images').show();
      $.ajax({
        url          : '<?php echo base_url(); ?>album/resize/<?php echo $album->id; ?>/' + response,
        type         : 'POST',
        cache        : false,
        success      : function(response) {
          if (response !== 'failure') {
            var new_image = '<li><img src="' + response + '" /><br />' + response + '</li>';
            $('#new-image-list').append(new_image);
          } else {
            var fail_message = '<li>创建缩略图失败: ' + fileObj.name + '</li>';
            $('#new-image-list').append(fail_message);
          }
        },
        error        : function(jqXHR, textStatus, errorThrown) {
          alert('创建缩略图失败');
        }
      });
    }
  });
  
});
</script>

<?php $this->load->view('inc/footer'); ?>
