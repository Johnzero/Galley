<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="/static/css/bootstrap3.css" />
  <link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css">
  <link rel="stylesheet" href="/static/css/main.css">
	<link href="/static/home/css/thin-admin.css" rel="stylesheet" media="screen" />
  <link rel="shortcut icon" href="/static/images/favicon.ico">
  <script type="text/javascript" src="/static/js/jquery.js"></script>
  <script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
</head>
<body>
  
<div class="container-fluid">

<style type="text/css">
    .page-header {
        margin: 0 auto;
        border-bottom: 1px solid #eeeeee;
        text-align: center;
    }
</style>

<div class="text-center">
    <img src="/static/logo.png">
</div>

<div class="widget-404" style="margin-top: 50px;">
<div class="row">
  <div class="col-md-5">
      <h1 class="text-align-center">404</h1>
  </div>
  <div class="col-md-7">
      <div class="description">
          <h3>页面不存在</h3>
          <p><?php echo $message; ?><br>
		<strong><a href="/home">返回首页</a></strong></p>
      </div>
  </div>
</div>
</div>

</div><!--/.fluid-container-->

<div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 525px; width: 1903px; z-index: -999999; position: fixed;"></div>
<script type="text/javascript" src="/static/js/jquery.backstretch.min.js"></script>
<script type="text/javascript">
    $.backstretch([
        "/static/images/bg/1.jpg",
        "/static/images/bg/2.jpg",
        "/static/images/bg/3.jpg",
        "/static/images/bg/4.jpg"
        ], {
            fade: 1000,
            duration: 2000
    });
</script>
</body>
</html>
