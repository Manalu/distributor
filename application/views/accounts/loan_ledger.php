<?php

/**
 * Description of loan_ledger
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
                    <?php widgetHeader(); ?> Loan Statement for <?php echo $u_name; ?>
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
                                <th style="text-align: center; width: 15%;">Date</th>
                                <th style="width: 15%;">Method</th>
                                <th style="width: 20%;">Notes</th>
                                <th style="text-align: right; width: 10%;">Deposit</th>
                                <th style="text-align: right; width: 10%;">Return</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($statement != FALSE) { $sl = 1; foreach($statement->result() as $statement) {  ?>
                            <tr>
                                <td style="text-align: center;">
                                    <?php echo $sl; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo date_format(date_create($statement->trans_date), 'd-M-Y') ?>
                                </td>
                                <td>
                                   <?php echo $statement->Media; ?> 
                                </td>
                                <td>
                                   <?php echo $statement->notes; ?> 
                                </td>
                                <td style="text-align: right;">
                                    <?php
                                    if($statement->trans_type == 1 || $statement->trans_type == 0) {
                                        echo bdt() . number_format($statement->amount, 2, ".", ",");
                                    } else {
                                        echo bdt() . number_format(0, 2, ".", ",");
                                    }
                                    ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php
                                    if($statement->trans_type == 2) {
                                        echo bdt() . number_format($statement->amount, 2, ".", ",");
                                    } else {
                                        echo bdt() . number_format(0, 2, ".", ",");
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php $sl++; } } ?>
                        </tbody>
                    </table>
                </div>
                <?php include 'application/views/common/marketing.php'; ?>
            </div>
            <?php include 'application/views/common/printer.php'; ?>
            <div class="widget-body center-align-text">
                <a href="<?php echo site_url('accounts/loanstatement'); ?>" class="btn btn-default">Back To List</a>
            </div>
        </div>
    </div>
</div>