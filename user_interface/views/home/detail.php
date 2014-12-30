<?php $this->load->view('inc/header'); ?>

<link href="/static/home/css/thin-admin.css" rel="stylesheet" media="screen" />
<link rel="stylesheet" type="text/css" href="/static/home/css/component.css" />

<style type="text/css">
    .wrapper {
        margin: -20px -20px 0px -20px;
    }
    .bottom-nav {
        padding: 0;
        height: 50px;
        line-height: 50px;
        text-align: center;
    }
</style>

<div id="wrapper"  class="wrapper">
    <?php $this->load->view('inc/leftnav'); ?>
    <div class="page-content">
        <div class="content container">
            <div class="row">
                <section class="grid-wrap">
                    <div class="well" style="color:#333333">
                        <legend class="text-center"><?php echo $image->name?$image->name:'图片信息';?> <a href="<?php echo site_url("home/zip_load/{$image->uuid}"); ?>" class="pull-right"><i class="icon-large icon-download-alt"></i></a> </legend>
                        
                        <div class="navbar">
                            <div class="navbar-inner">
                                <a class="brand">标签：</a>
                                <ul class="nav">
                                    <li><a><?php echo $image->tags; ?></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="navbar">
                            <div class="navbar-inner">
                                <a class="brand">系统分类：</a>
                                <ul class="nav">
                                    <?php if (!empty($cat_array)) { ?>
                                        <?php foreach ($cat_array as $key => $value): ?>
                                            <li><a><?php echo $value->typename;?></a></li>
                                        <?php endforeach ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                        <div class="navbar">
                            <div class="navbar-inner">
                                <a class="brand">作者：</a>
                                <ul class="nav">
                                    <li><a><?php echo $image->author; ?></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="navbar">
                            <div class="navbar-inner">
                                <a class="brand">单位（或通讯地址）：</a>
                                <ul class="nav">
                                    <li><a><?php echo $image->author_address; ?></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="navbar">
                            <div class="navbar-inner">
                                <a class="brand">拍摄地点：</a>
                                <ul class="nav">
                                    <li><a><?php echo $image->location; ?></a></li>
                                </ul>
                            </div>
                        </div>

                        <div id="img">
                            <img src="<?php echo site_url("imagedata/{$image->uuid}?type=premium"); ?>" alt="<?php echo $image->name; ?>" />
                        </div>

                        <div class="widget">
                            <div class="widget-header">
                                <h3>详细说明：</h3>
                            </div>
                            <div class="widget-content">
                                <?php echo $image->caption; ?>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function () { 
       
    });
</script>

<?php $this->load->view('inc/footer'); ?>



