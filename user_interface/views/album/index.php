<?php $this->load->view('inc/header'); ?>

<?php if (isset($flash)): ?>
<div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong><?php echo $flash; ?></strong></div>
<?php endif; ?>

<div class="page-header">
  <h1>我的相册</h1>
</div>

<?php if (isset($albums)): ?>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>名称</th>
      <?php if ($is_admin == TRUE): ?>
      <th width="120">创建者</th>
      <?php endif; ?>
      <th width="120">创建时间</th>
      <th width="120">更新时间</th>
      <th width="70">图片数量</th>
      <th width="140"><a class="btn btn-primary" href="<?php echo site_url("album/create"); ?>">创建新相册</a></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($albums as $album): ?>
    <tr>
      <td><a href="<?php echo site_url("album/images/" . $album['id']); ?>"><?php echo $album['name']; ?></a>
        <?php $images = $album['images']; ?>
        <?php if (isset($images) && ! empty($images)): ?>
        <ul class="mini-image-set">
          <?php foreach ($images as $image): ?>
          <li>
            <a href="<?php echo site_url("album/images/" . $album['id']); ?>"><img src="<?php echo site_url("imagedata/{$image->uuid}?type=small"); ?>" /></a></li>
          <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
        <?php endif; ?>
      </td>
        <?php if ($is_admin == TRUE): ?>
        <?php if ($email_address == $album['user']): ?>
            <td>我</td>
        <?php else: ?>
            <td><a href="<?php echo site_url('user/edit/' . $album['user_id']); ?>"><?php echo $album['user']; ?></a></td>
        <?php endif; ?>
      <?php endif; ?>
      <td><?php echo date(' Y 年 m 月 d', strtotime($album['created_at'])); ?></td>
      <td><?php echo date('Y 年 m 月 d', strtotime($album['updated_at'])); ?></td>
      <td><?php echo $album['total_images']; ?></td>
      <td>
        <div class="btn-group">
          <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            操作
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url("album/edit/" . $album['id']); ?>"><i class="icon-pencil"></i> 重命名 </a></li>
            <li><a href="<?php echo site_url("album/images/" . $album['id']); ?>"><i class="icon-picture"></i> 查看 </a></li>
            <?php if ($is_admin == TRUE): ?>
            <li><a href="<?php echo site_url("album/configure/" . $album['id']); ?>"><i class="icon-cog"></i> 设置 </a></li>
            <?php endif; ?>
            <li><a class="album-delete-btn" href="#album-modal" data-toggle="modal" rel="<?php echo site_url("album/remove/" . $album['id']); ?>"><i class="icon-trash"></i> 删除 </a></li>
          </ul>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>

<?php echo $this->pagination->create_links(); ?>

<div class="modal hide fade" id="album-modal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>删除相册</h3>
  </div>
  <div class="modal-body">
    <p><strong>确认删除该相册?</strong></p>
    <p>删除操作会永久删除相册下所有图片！.</p>
  </div>
  <div class="modal-footer">
    <a id="album-modal-delete-btn" href="#" class="btn btn-danger">确认删除</a>
    <a href="#" class="btn" data-dismiss="modal">返回</a>
  </div>
</div>

<script type="text/javascript">
var deleteUrl;
$(document).ready(function() {
    $('.album-delete-btn').click(function() {
    deleteUrl = $(this).attr('rel');
  });
  
  $('#album-modal').on('show', function() {
    $('#album-modal-delete-btn').attr('href', deleteUrl);
  });
});
</script>

<?php $this->load->view('inc/footer'); ?>
