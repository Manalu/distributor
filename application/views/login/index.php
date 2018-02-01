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
      <title><?php echo $title; ?></title>
      <meta name="author" content="Exploria Solutions">
      <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
      <meta name="description" content="Complete Automated Pharmaceutical Solutions. Integrated Accounting system to monitor every single in and out of your business.">
      <meta name="keywords" content="Complete Automated Pharmaceutical Solutions. Integrated Accounting system to monitor every single in and out of your business.">
      <link rel="icon" type="image/ico" href="<?php echo $img; ?>distributor.ico">
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
                <div class="span4 offset4 top_margin">
                    <?php if($warning == TRUE) { ?>
                    <div class="alert alert-block alert-warning fade in">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <h4 class="alert-heading">Warning!!</h4>
                        <p>You must pay the bill within 4th of this month and collect the activation key from Exploria Solution to keep your subscription alive.</p>
                        <p>contact: sales@exploriasolution.com</p>
                    </div>
                    <?php } ?>
                    <div class="signin">
                        <h2 class="center-align-text" style="color:#337ead">
                            <img src="<?php echo base_url() . 'img/distributor.png' ?>" width="" height="" title="<?php echo $ShopName; ?>" />
                        </h2>
                        <h4 class="center-align-text"><?php echo $ShopName; ?></h4>
                        <?php echo $this->session->flashdata('errorData'); ?>
                        <?php if($locked == FALSE) { ?>
                        <form action="<?php echo site_url('login');?>" class="signin-wrapper" method="post">
                            <div class="content">
                                <input class="input input-block-level" placeholder="Your Email" type="text" name="uid" autofocus="on" required="required" />
                                <input class="input input-block-level" placeholder="Password" type="password" name="password" required="required" />
                            </div>
                            <div class="actions">
                                <input type="hidden" name="trigger" value="hit">
                                <input class="btn btn-info pull-right" type="submit" value="Login">
                                <span class="checkbox-wrapper">
                                    <a href="<?php echo site_url('forgot')?>" class="pull-left">Forgot Password</a><br>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                            <span  class="center-align-text"><?php echo date('Y',  time())?> &COPY; All rights <?php echo $ShopName;?>&#0153;.Powered By - <a class="loginlink" href="http://exploriasolution.com/">Exploria Solution</a></span>
                        </form>
                        <?php } elseif($locked == TRUE) { ?>
                        <div class="alert alert-block alert-error fade in">
                            <button data-dismiss="alert" class="close" type="button"> × </button>
                            <h4 class="alert-heading">Sorry!!</h4>
                            <p>Please pay the bill to login, If you have paid the bill then please submit the activation key.</p>
                        </div>
                        <hr />
                        <span class="span12 center-align-text"><a href="<?php echo site_url('login/activate'); ?>" class="btn btn-success">Activate</a></span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    
    <script src="<?php echo $js;?>jquery.min.js"></script>
    <script src="<?php echo $js?>bootstrap.js"></script>
    
   
  </body>
</html>