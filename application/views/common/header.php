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
    <title><?php echo $title;?></title>
    <meta name="author" content="Exploria Solutions">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=no" name="viewport">
    <meta name="description" content="Complete Automated Pharmaceutical Solutions. Integrated Accounting system to monitor every single in and out of your business.">
    <meta name="keywords" content="Complete Automated Pharmaceutical Solutions. Integrated Accounting system to monitor every single in and out of your business.">
    <link rel="icon" type="image/ico" href="<?php echo $img; ?>distributor.ico">
    <script src="<?php echo $js;?>html5-trunk.js"></script>
    <link rel="stylesheet" href="<?php echo $icomoon?>style.css" />
    <!--[if lte IE 7]>
    <script src="<?php echo $css;?>icomoon-font/lte-ie7.js"></script>
    <![endif]-->
    
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="<?php echo $css;?>main.css" />
    
    <link href="<?php echo $css;?>wysiwyg/bootstrap-wysihtml5.css" rel="stylesheet" />
    <link href="<?php echo $css;?>wysiwyg/wysiwyg-color.css" rel="stylesheet" />
    <link href="<?php echo $css;?>timepicker.css" rel="stylesheet" />
    <link href="<?php echo $css;?>bootstrap-editable.css" rel="stylesheet" />
    <link href="<?php echo $css;?>select2.css" rel="stylesheet" />

    <!-- NVD graphs css -->
    <link rel="stylesheet" href="<?php echo $css;?>nvd-charts.css" />
    
    <!-- fullcalendar css -->
    <link rel='stylesheet' href='<?php echo $css;?>fullcalendar/fullcalendar.css' />
    <link rel='stylesheet' href='<?php echo $css;?>fullcalendar/fullcalendar.print.css' media='print' />
    <link href="<?php echo $css;?>listnav.css" rel="stylesheet">
    
    <script src="<?php echo $js;?>jquery-2.0.0.js"></script>
    <script src="<?php echo $js;?>jQuery.print.js"></script>
    <script src="<?php echo $js;?>jquery-ui.js"></script>
    <script src="<?php echo $js;?>wysiwyg/wysihtml5-0.3.0.js"></script>
    <script src="<?php echo $js;?>bootstrap.js"></script>
    <script src="<?php echo $js;?>moment.js"></script>
    <script src="<?php echo $js;?>dashboard.js"></script>
    
    <script src="<?php echo $js;?>jquery.tablesorter.min.js"></script>
    
    <link rel="stylesheet" href="<?php echo $css;?>jquery-ui.css" />
    <link rel="stylesheet" href="<?php echo $css;?>custom.css" />
  </head>
  <body>
    <header>
        <a href="<?php echo base_url(); ?>" class="logo"><?php echo $ShopName . ' - ' . get_branch_name($b_id); ?></a>
        <div id="mini-nav">
            <ul class="hidden-phone">
                <li>
                    <div class="welcome-text">
                        <a style="color: #fff; margin-right: 5px; margin-left: 5px;" class="name">Mr. <?php echo $name?></a>
                    </div>
                </li>
                <li>
                    <a data-original-title="Logout" href="<?php echo site_url('logout')?>"><span class="fs1" aria-hidden="true"  data-icon="&#xe0b1;"></span></a>
                </li>
            </ul>
        </div>
   </header>
      <noscript><meta http-equiv="refresh" content="0; url=<?php echo site_url('test/noscript'); ?>" /></noscript>