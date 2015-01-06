<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>
        <meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;" />
        <title><?php echo $this->config->item('site_title'); ?></title>
        <link rel="shortcut icon" href="/static/images/favicon.ico">
        <link rel="stylesheet" href="/static/css/bootstrap.css" />
        <link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="/static/index/css/index.css">
        <link href="/static/home/css/font-awesome.css" rel="stylesheet" media="screen" />
        <link href="/static/index/css/prettyPhoto.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="/static/js/jquery.js"></script>
        
        <!--[if lt IE 9]>
        <script src="/static/js/html5shiv.js"></script>
        <script src="/static/js/respond.min.js"></script>
        <link href="/static/index/css/ie.css" type="text/css" rel="stylesheet"/>
        <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                    <!-- <a class="brand" href="<?php echo site_url('index'); ?>">
                        <?php echo $this->config->item('site_title'); ?>
                    </a> -->
                    <div class="nav-collapse">

                        <p class="navbar-text pull-right">
                            <i class="icon-phone"></i> 400-84084-842 &nbsp;&nbsp;
                            <?php if ($this->session->userdata('name')) { ?>
                            <i class="icon-male"></i>&nbsp;&nbsp;<a href="<?php echo site_url("home"); ?>" ><?php echo $this->session->userdata('name'); ?> </a> &nbsp;&nbsp;

                            <i class="icon-signout"></i>&nbsp;<a href="<?php echo site_url("auth/logout"); ?>">登出</a> &nbsp;&nbsp;
                            <?php }else { ?>

                            <i class="icon-signin"></i>&nbsp;<a href="<?php echo site_url("auth"); ?>">登陆</a> &nbsp;&nbsp;

                            <i class="icon-user"></i>&nbsp;<a href="<?php echo site_url("auth/reg"); ?>">注册</a> &nbsp;&nbsp;

                            <?php }?>
                        </p>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">

            <!-- header -->
            <header id="header">
                <div class="container">
                    <div class="row">
                        <div class="span2 logo">
                            <a href="<?php echo site_url('index'); ?>"><img src="/static/logo.png" alt="logo" /></a>
                        </div>
                        <div class="span10 hidden-phone pull-right" style="width: auto;">
                            <nav id="menu">

                                <ul class="clearfix">

                                    <li <?php if ($url == "index" )  echo 'class="current"';?> >
                                        <a href="<?php echo site_url('index'); ?>" <?php if ($url == "index" )  echo 'class="current"';?> >
                                            首页
                                        </a>
                                    </li>
                                    <?php foreach ($cats as $key => $value): ?>
                                        <li <?php if ($url == $value['id'] )  echo 'class="current"';?> >
                                            <a <?php if ($url == $value['id'] )  echo 'class="current"';?>  href="<?php echo site_url("index/sub/{$value['id']}"); ?>">
                                                <?php echo $value['ico'];?>
                                                <?php echo $value['typename'];?> 
                                                <i class="arrow icon-angle-left"></i>
                                            </a>
                                        </li>
                                    <?php endforeach ?>

                                </ul>

                            </nav>
                        </div>
                    </div>
                </div>
            </header>