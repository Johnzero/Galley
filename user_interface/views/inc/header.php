<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->config->item('site_title'); ?></title>
    <link rel="stylesheet" href="/static/css/main.css">
    <link rel="stylesheet" href="/static/css/bootstrap.css" />
    <link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css">
    <?php if (isset($css)): ?>
    <?php foreach ($css as $stylesheet): ?>
    <link rel="stylesheet" href="/static/css/<?php echo $stylesheet; ?>">
    <?php endforeach; ?>
    <?php endif; ?>
    <link rel="shortcut icon" href="/static/images/favicon.ico">
    <link rel="stylesheet" href="/static/css/fancybox/jquery.fancybox-1.3.4.css">
    <link href="/static/home/css/font-awesome.css" rel="stylesheet" media="screen" />
    
    <script type="text/javascript" src="/static/js/jquery.js"></script>
    <?php if (isset($js)): ?>
    <?php foreach ($js as $script): ?>
    <script type="text/javascript" src="/static/js/<?php echo $script; ?>"></script>
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/static/js/html5shiv.js"></script>
    <script src="/static/js/respond.min.js"></script>
    <![endif]-->
    
</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
          <a class="brand" href="<?php echo site_url('index'); ?>"><?php echo $this->config->item('site_title'); ?></a>
          <div class="nav-collapse">
            <ul class="nav">

                <li<?php if ($this->uri->segment(1) == "home") echo ' class="active"'; ?>><a href="<?php echo site_url("home"); ?>">&nbsp;&nbsp;全部图片&nbsp;&nbsp;</a></li>

                <li<?php if ($this->uri->segment(1) == "album") echo ' class="active"'; ?>><a href="<?php echo site_url("album"); ?>">&nbsp;&nbsp;个人相册&nbsp;&nbsp;</a></li>
                <!-- <li<?php if ($this->uri->segment(1) == "feed") echo ' class="active"'; ?>><a href="<?php echo site_url("feed"); ?>">Feeds</a></li> -->
                <li<?php if ($this->uri->segment(1) == "user") echo ' class="active"'; ?>><a href="<?php echo site_url("user"); ?>">&nbsp;&nbsp;用户中心&nbsp;&nbsp;</a></li>
                <li<?php if ($this->uri->segment(1) == "search") echo ' class="active"'; ?>><a href="<?php echo site_url("search"); ?>">&nbsp;&nbsp;详细搜索&nbsp;&nbsp;</a></li>
            </ul>
            <p class="navbar-text pull-right">

            <i class="icon-phone"></i> 400-84084-842 &nbsp;&nbsp;

            <i class="icon-male"></i>&nbsp;&nbsp;<?php echo $this->session->userdata('name'); ?>&nbsp;&nbsp;
            
            <i class="icon-signout"></i>&nbsp;<a href="<?php echo site_url("auth/logout"); ?>">登出</a>

            </p>
          </div><!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container-fluid">
