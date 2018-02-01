<?php

/**
 * Description of client_ledger
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
                    <?php widgetHeader(); ?> <?php echo $c_name . ' ' . $printer; ?>
                </div>
            </div>
            <div id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <div class="widget-body">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">SL.</th>
                                <th style="text-align: center; width: 15%;">Date</th>
                                <th style="text-align: left; width: 15%;">Ledger</th>
                                <th style="text-align: left; width: 20%;">Notes</th>
                                <th style="text-align: right; width: 15%;">Credit</th>
                                <th style="text-align: right; width: 15%;">Debit</th>
                                <th style="text-align: right; width: 15%;">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($ledger != FALSE) { $sl = 1; foreach($ledger->result() as $voucher) { ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $sl; ?></td>
                                <td style="text-align: center;"><?php echo date_format(date_create($voucher->ledger_date), 'd-M-Y'); ?></td>
                                <td style="text-align: left;"><?php echo $voucher->ledger; ?></td>
                                <td style="text-align: left;">
                                    <?php echo $voucher->notes; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php //if($voucher->ledger_id == 1 && $balance_type == "Payable") {
//                                    echo bdt() . number_format($voucher->amount, 2, ".", ",");
//                                    } else {
//                                        if($voucher->ledger_id == 2) {
//                                            echo bdt() . number_format($voucher->amount, 2, ".", ",");
//                                        } else {
//                                            echo bdt() . number_format(0, 2, ".", ",");
//                                        }
//                                    } ?>
                                    <?php if($voucher->ledger_type == 1) { echo bdt() . number_format($voucher->amount, 2, ".", ","); } else { echo bdt() . number_format(0, 2, ".", ","); } ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php //if($voucher->ledger_id == 1 && $balance_type == "Receivable") {
//                                    echo bdt() . number_format($voucher->amount, 2, ".", ",");    
//                                    } else {
//                                        if($voucher->ledger_id == 3 || $voucher->ledger_id == 4 || $voucher->ledger_id == 5) {
//                                            echo bdt() . number_format($voucher->amount, 2, ".", ",");
//                                        } else {
//                                            echo bdt() . number_format(0, 2, ".", ",");
//                                        }
//                                    } ?>
                                    <?php if($voucher->ledger_type == 2) { echo bdt() . number_format($voucher->amount, 2, ".", ","); } else { echo bdt() . number_format(0, 2, ".", ","); } ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php echo bdt() . number_format($voucher->balance, 2, ".", ",");     ?>
                                </td>
                            </tr>
                            <?php $sl++; } } else { ?>
                            <tr>
                                <td style="text-align: center;" colspan="7">
                                    <?php echo errormessage('No data found!!') ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php include 'application/views/common/marketing.php'; ?>
            </div>
            <?php include 'application/views/common/printer.php'; ?>
            <div class="widget-body center-align-text">
                <a href="<?php echo site_url($back_link); ?>" class="btn btn-default">Back to List</a>
            </div>
        </div>
    </div>
</div>