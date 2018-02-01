<?php

/**
 * Description of stock
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> <?php echo $p_name . ' - ' . $pro_id; ?>
                </div>
            </div>
            <div class="widget-body">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center;">SL.</th>
                            <!--<th>Product</th>-->
                            <th>Branch</th>
                            <th style="text-align: center;">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($stock != FALSE) { $sl = 1; foreach($stock->result() as $stock) {   ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $sl; ?></td>
                            <!--<td><?php //echo $stock->p_name; ?></td>-->
                            <td><?php echo $stock->b_name; ?></td>
                            <td style="text-align: center;"><?php echo $stock->stock; ?></td>
                        </tr>
                        <?php $sl++; } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>