<?php

/**
 * Description of printer
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="widget-body center-align-text">
    <style type="text/css">
        @media print {
            a[href]:after {
              content: none !important;
            }
            .noprint{display: none !important; }
        }
    </style>
    <button class="btn btn-primary" id="printer">Take a Print Out</button>
    <div class="clearfix"></div>
    <script type="text/javascript">
        $("#printer").click(function(){
            $("#headerInfo").css("display", "block");
            $("#timeStamp").html("<?php echo '<b>' . $printer . '</b> Print Date: ' . date("d, M Y - H:i:s A"); ?>");
            $("#addressStamp").html("<?php echo 'Address: ' . $ShopAdrs; ?>");
            $("#marketing").css("display", "block");
            $("#printable").print();
            $("#headerInfo").css("display", "none");
            $("#marketing").css("display", "none");
        });
    </script>
</div>