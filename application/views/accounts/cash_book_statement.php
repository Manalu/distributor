<?php

/**
 * Description of loan_statement
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
                    <?php widgetHeader(); ?> Individual Cash Book Statement
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <div class="widget-body">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">SL.</th>
                                <th style="width: 20%;">Name</th>
                                <th style="width: 15%;">User</th>
                                <th style="width: 15%;">Branch</th>
                                <th style="text-align: right; width: 20%;">Balance</th>
                                <th style="text-align: center; width: 10%;">Ledger</th>
                                <!--<th style="text-align: center; width: 10%;">Adjust</th>-->
                            </tr>
                        </thead>
                        <tbody id="loan_statement">
                            <?php if($loan_balance != FALSE) { $sl = 1; foreach($loan_balance->result() as $balance) { ?>
                            <tr>
                                <td style="text-align: center;">
                                    <?php echo $sl; ?>
                                </td>
                                <td>
                                    <?php echo $balance->u_name; ?>
                                </td>
                                <td>
                                    <?php
                                    if($balance->r_id == 1){
                                        echo 'Purchase Manager';
                                    } else if($balance->r_id == 2){
                                        echo 'Sales Manager';
                                    } else if($balance->r_id == 3){
                                        echo 'Administration';
                                    } else if($balance->r_id == 4){
                                        echo 'Loan/Investment User';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $balance->b_name; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php echo bdt() . number_format($balance->balance, 2, ".", ","); ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?php echo site_url('accounts/cashbookledger?sess_auth=' . md5('Ymshis') . '&func=loan_statement&cat=accounts&voucher=' . rand(1, 100) . '&clopier=' . rand(1, 10) . '&user=' . $balance->user_id . '&max=' . $balance->balance . '&trans_type=2'); ?>">
                                        <i class="icon-profile"></i>
                                    </a>
                                </td>
<!--                                <td style="text-align: center;">
                                    <a href="<?php //echo site_url('accounts/loanrefund?sess_auth=' . md5('Ymshis') . '&func=loan_refund&cat=accounts&voucher=' . rand(1, 100) . '&clopier=' . rand(1, 10) . '&user=' . $balance->user_id . '&max=' . $balance->balance . '&trans_type=2'); ?>">
                                        <i class="icon-adjust"></i>
                                    </a>
                                </td>-->
                            </tr>
                            <?php $sl++; } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>