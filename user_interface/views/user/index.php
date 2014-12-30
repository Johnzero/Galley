<?php $this->load->view('inc/header'); ?>

<?php if (isset($flash)): ?>
<div class="alert alert-success"><a class="close" data-dismiss="alert">x</a><strong><?php echo $flash; ?></strong></div>
<?php endif; ?>

<div class="page-header">
  <h1>用户</h1>
</div>

<?php if (isset($users)): ?>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>邮箱地址</th>
      <th>是否管理员</th>
      <th>是否激活</th>
      <th>创建时间</th>
      <th>上次登录时间</th>
      <th>相册数量</th>
      <th>上次登录地址</th>
      <th>
        <?php if ($user_data['is_admin'] == 1): ?>
        <a class="btn btn-primary" href="<?php echo site_url("user/create"); ?>">创建新用户</a>
        <?php endif; ?>
      </th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $user): ?>
    <tr>
      <td><?php echo $user->email_address; ?></td>
      <td><?php echo (($user->is_admin == 1) ? '是' : '否'); ?></td>
      <td><?php echo (($user->is_active == 1) ? '是' : '否'); ?></td>
      <td><?php echo date(' Y 年 m 月 d', strtotime($user->created_at)); ?></td>
      <td><?php
      if (isset($user->last_logged_in)):
        echo date(' Y 年 m 月 d', strtotime($user->last_logged_in));
      endif;
      ?></td>
      <td><?php echo $user->total_albums; ?></td>
      <td><?php echo $user->last_ip; ?></td>
      <td>
        <div class="btn-group">
          <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            操作
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo site_url("user/edit/$user->id"); ?>"><i class="icon-pencil"></i> 编辑</a></li>
            <?php if ($user_data['is_admin'] == 1): ?>
                <?php if ($user->is_active == 1) {?>
                    <li><a href="<?php echo site_url("user/deactivate/$user->id"); ?>"><i class="icon-ban-circle"></i> 取消激活</a></li>
                <?php }else { ?>
                    <li><a href="<?php echo site_url("user/activate/$user->id"); ?>"><i class="icon-ban-circle"></i> 激活</a></li>
                <?php }; ?>
            <li><a class="user-delete-btn" href="#user-modal" data-toggle="modal" rel="<?php echo site_url("user/remove/$user->id"); ?>">
                <i class="icon-trash"></i> 删除</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>

<div class="modal hide fade" id="user-modal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Delete User</h3>
  </div>
  <div class="modal-body">
    <p><strong>确认删除用户?</strong></p>
    <p>该操作将会删除全部用户数据.</p>
  </div>
  <div class="modal-footer">
    <a id="user-modal-delete-btn" href="#" class="btn btn-danger">删除</a>
    <a href="#" class="btn" data-dismiss="modal">取消</a>
  </div>
</div>

<script type="text/javascript">
var deleteUrl;
$(document).ready(function() {
  $('.user-delete-btn').click(function() {
    deleteUrl = $(this).attr('rel');
  });
  
  $('#user-modal').on('show', function() {
    $('#user-modal-delete-btn').attr('href', deleteUrl);
  });
});
</script>

<?php $this->load->view('inc/footer'); ?>
