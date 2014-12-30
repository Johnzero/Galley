<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $this->config->item('site_title'); ?></title>
        <link rel="stylesheet" href="/static/css/index.css">
        <link rel="stylesheet" href="/static/css/bootstrap.css" />
        <link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css">
        <link rel="shortcut icon" href="/static/images/favicon.ico">
        <link href="/static/home/css/font-awesome.css" rel="stylesheet" media="screen" />
        <script type="text/javascript" src="/static/js/jquery.js"></script>
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
                    <a class="brand" href="<?php echo site_url('index'); ?>">
                        <?php echo $this->config->item('site_title'); ?>
                    </a>
                    <div class="nav-collapse">
                        <p class="navbar-text pull-right"><i class="icon-male"></i>&nbsp;&nbsp;<?php echo $this->session->userdata('name'); ?>&nbsp;&nbsp;<a href="<?php echo site_url("auth/logout"); ?>">登出</a></p>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">