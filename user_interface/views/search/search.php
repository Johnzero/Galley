<?php $this->load->view('inc/header'); ?>
<link href="/static/home/css/thin-admin.css" rel="stylesheet" media="screen" />
<link rel="stylesheet" type="text/css" href="/static/home/css/component.css" />
<link href="/static/search/css/search.css" rel="stylesheet">
<link href="/static/search/css/bootstrap-override.css" rel="stylesheet">

<div id="wrapper"  class="wrapper">
    <div class="mainpanel">
        <div class="pageheader">
            <h2><i class="icon-search"></i> 搜索 <span>输入关键词查找...</span></h2>
        </div>
        <div class="contentpanel">
            
                <div class="col-sm-4 col-md-3 content-left">
                    <form action="" method="GET">

                    <h4 class="subtitle mb5">关键词</h4>
                    <input type="text" value="<?php echo $keyword;?>" class="form-control" name="keyword" placeholder="关键词，标题，作者，地点等...">
                    
                    <div class="mb20"></div>
                    
                    <h4 class="subtitle mb5">拍摄地点</h4>
                    <input type="text" value="<?php echo $location;?>"  class="form-control" name="location">
                    
                    <div class="mb20"></div>
                    
                    <h4 class="subtitle mb5">拍摄作者</h4>
                    <input type="text" value="<?php echo $author;?>"  class="form-control" name="author">

                    <div class="mb20"></div>
                    <input type="submit" class="btn btn-primary" value="搜索">
<!--                     <h4 class="subtitle mb5">文件大小</h4>
                    <div id="slider"> </div>
                    
                    <div class="mb20"></div> -->
                    
                    <!-- <h4 class="subtitle mb5">文件类型</h4>
                    <ul class="nav nav-sr">
                        <li><a href=""><i class="glyphicon glyphicon-file"></i> JPG</a></li>
                    </ul>
                    <div class="mb20"></div> -->
                    
                    <!-- <h4 class="subtitle mb5">Date Created</h4>
                    <div class="input-group">
                        <input type="text" class="form-control hasDatepicker" placeholder="mm/dd/yyyy" id="datepicker">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div> -->
                    <br>
                    </form>
                    
                </div><!-- col-sm-4 -->
                <div class="col-sm-8 col-md-9 content-right">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <ul class="pagination nomargin pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </ul>
                            <h4 class="panel-title">搜索 <?php if ($keyword) {?>“<?php echo $keyword;?>”<?php }?> <?php if ($location) {?>“<?php echo $location;?>” <?php }?>的结果：</h4>
                            <p> 共 <?php echo $total;?> 结果 (<?php echo $elapsed_time;?> 秒 <?php echo $memory_usage;?> 内存)</p>
                        </div><!-- panel-heading -->
                            <div class="panel-body">
                                
                                <div class="results-list">
                                    <?php foreach ($images as $key => $image): ?>
                                    <div class="media">
                                        <a class="album-images img-fancy thumbnail pull-left" href="<?php echo site_url("imagedata/{$image['uuid']}?type=large"); ?>" title="<?php echo $image['name']; ?>">
                                            <img src="<?php echo site_url("imagedata/{$image['uuid']}"); ?>" data-link="<?php echo site_url("home/zip_load/{$image['uuid']}"); ?>" class="media-object">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="filename text-primary"><?php echo $image['name']; ?></h4>
                                            <small class="text-muted">作&nbsp;&nbsp;者: <?php echo $image['author']; ?> </small><br>
                                            <small class="text-muted">类&nbsp;&nbsp;型: <?php echo ltrim($image['file_ext'],"."); ?> 图片</small><br>
                                            <small class="text-muted">标&nbsp;&nbsp;签: <?php echo $image['tags']; ?> </small><br>
                                            <small class="text-muted">大&nbsp;&nbsp;小: <?php echo round($image['file_size'] / 1024, 2); ?> MB </small><br>
                                            <small class="text-muted">拍摄地点: <?php echo $image['location']; ?> </small><br>
                                            <small class="text-muted">创建日期: <?php echo date(' Y 年 m 月 d 日', strtotime($image['created_at'])); ?> </small><br>
                                        </div>
                                        <a class="more icon-large icon-picture pull-right" href="<?php echo site_url("home/detail/{$image['id']}"); ?>" target="_blank"> </a><br>
                                    </div>
                                    <?php endforeach ?>
                                    
                                </div><!-- results-list -->
                                    
                            </div><!-- panel-body -->
                    </div><!-- panel -->
                </div><!-- col-sm-8 -->
                                    
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('a.img-fancy').fancybox();
    })
</script>
<?php $this->load->view('inc/footer'); ?>