<!DOCTYPE html>
  <!--[if lt IE 7]>
    <html class="lt-ie9 lt-ie8 lt-ie7" lang="en">
  <![endif]-->

  <!--[if IE 7]>
    <html class="lt-ie9 lt-ie8" lang="en">
  <![endif]-->

  <!--[if IE 8]>
    <html class="lt-ie9" lang="en">
  <![endif]-->

  <!--[if gt IE 8]>
    <!-->
    <html lang="en">
    <!--
  <![endif]-->

  <head>
    <meta charset="utf-8">
    <title>Gulf Pharmacy Limited</title>
    <meta name="author" content="Mousum Nandy (mousumaiub10@gmail.com)">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <script src="<?php echo $js;?>html5-trunk.js"></script>
    <link href="<?php echo $icomoon;?>style.css" rel="stylesheet">
    <!--[if lte IE 7]>
    <script src="<?php echo $css;?>icomoon-font/lte-ie7.js"></script>
    <![endif]-->
    <!-- bootstrap css -->
    <link href="<?php echo $css;?>main.css" rel="stylesheet">
  </head>
<body>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span4 offset4">
                <div class="signin">
                    <h2 class="center-align-text" style="color:#337ead"><?php echo $ShopName;?> &#0153</h2>
                    <?php echo $this->session->flashdata('errorData'); ?>
                    <form action="<?php echo site_url('login/activate');?>" class="signin-wrapper" method="post">
                        <div class="content">
                            <input type="text" name="activator" id="activator" class="input input-block-level" placeholder="Activation Code" autocomplete="off" />
                        </div>
                        <div class="actions">
                            <input type="hidden" name="trigger" value="activation" />
                            <input class="btn btn-info pull-right" type="submit" value="Activate" />
                            <span class="checkbox-wrapper">
                                <a href="<?php echo site_url('login')?>" class="pull-left">Back to Login</a>
                            </span>
                            <div class="clearfix"></div>
                            <span  class ="center-align-text"><?php echo date('Y',  time())?> &COPY; All rights <?php echo $ShopName;?>&#0153;.Powered By -<a href="http://exploriasolution.com/">Exploria Solution</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo $js;?>jquery.min.js"></script>
    <script src="<?php echo $js?>bootstrap.js"></script>
</body>
</html>