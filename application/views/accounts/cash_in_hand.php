<?php

/**
 * Description of cash_in_hand
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
                    <?php widgetHeader(); ?> Branchwise Cash In Hand
                </div>
            </div>
            <div class="widget-body">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center;">
                                SL.
                            </th>
                            <th>
                               Branch 
                            </th>
                            <th style="text-align: right;">
                                Amount
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($balance != FALSE) { $sl = 1; foreach($balance->result() as $balance) { ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php echo $sl; ?>
                            </td>
                            <td>
                                <?php echo $balance->b_name; ?>
                            </td>
                            <td style="text-align: right;">
                                <?php echo bdt() . number_format($balance->balance, 2, ".", ","); ?>
                            </td>
                        </tr>
                        <?php $sl++; } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>