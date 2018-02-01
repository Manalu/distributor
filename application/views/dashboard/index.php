<?php

/**
 * Description of index
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
                    <?php widgetHeader(); ?> Pending Orders
                </div>
            </div>
            <div class="widget-body">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%;">SL.</th>
                            <th style="width: 20%;">Supplier</th>
                            <th style="text-align: center; width: 10%;">Placed</th>
                            <th style="text-align: center; width: 5%;">Item</th>
                            <th style="text-align: right; width: 15%;">Billed</th>
                            <th style="text-align: right; width: 15%;">Paid</th>
                            <th style="text-align: right; width: 15%;">Due</th>
                            <th style="text-align: center; width: 5%;">Status</th>
                            <th style="text-align: center; width: 5%;">View</th>
                            <th style="text-align: center; width: 5%;">Receive</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($pending_list != FALSE) { $sl = 1; $billed = 0; $paid = 0; $due = 0; foreach($pending_list->result() as $pending) {   ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $sl; ?></td>
                            <td><?php echo $pending->Supplier; ?></td>
                            <td style="text-align: center;"><?php echo date_format(date_create($pending->or_date), 'd-M-Y'); ?></td>
                            <td style="text-align: center;"><?php echo $pending->Item; ?></td>
                            <td style="text-align: right;">
                                <?php $billed = $billed + $pending->Billed; ?>
                                <?php echo bdt() . number_format($pending->Billed, 2, ".", ","); ?>
                            </td>
                            <td style="text-align: right;">
                                <?php $paid = $paid + $pending->Paid; ?>
                                <?php echo bdt() . number_format($pending->Paid, 2, ".", ","); ?>
                            </td>
                            <td style="text-align: right;">
                                <?php $current = $pending->Billed - $pending->Paid; ?>
                                <?php $due = $due + $current; ?>
                                <?php echo bdt() . number_format($current, 2, ".", ","); ?>
                            </td>
                            <td style="text-align: center;">
                                <?php // if($orders->Paid < $orders->Billed) { ?>
                                <!--<a href="<?php // echo site_url('order/payment/' . $orders->or_id); ?>" class="btn btn-mini btn-success btn-block">Pay</a>-->
                                <?php // } else if($orders->Paid > $orders->Billed) { ?>
                                <!--<a href="<?php // echo site_url('order/adjust/' . $orders->or_id . '/' . abs($current) . '/' . $orders->Company); ?>" class="btn btn-mini btn-warning btn-block">Adjust</a>-->
                                <?php // } else { ?>
                                <!--<a class="btn btn-mini btn-inverse btn-block">Pay</a>-->
                                <?php // } ?>
                                <?php if($pending->Status == 1) {    ?>
                                <b style="color: blue;">Placed</b>
                                <?php } else if($pending->Status == 2) { ?>
                                <b style="color: green;">Received</b>
                                <?php } else if($pending->Status == 3) { ?>
                                <b style="color: red;">Canceled</b>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo site_url('order/details/' . $pending->or_id); ?>">
                                    <i class="icon-profile"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <?php if($pending->Status == 1) { ?>
                                <a href="<?php echo site_url('order/receive/' . $pending->or_id); ?>">
                                    <i class="icon-edit"></i>
                                </a>
                                <?php } else { ?>
                                <i class="icon-edit"></i>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php $sl++; } ?>
                        <tr>
                            <th colspan="4" style="text-align: right;">Total</th>
                            <th style="text-align: right;">
                                <?php echo bdt() . number_format($billed, 2, ".", ","); ?>
                            </th>
                            <th style="text-align: right;">
                                <?php echo bdt() . number_format($paid, 2, ".", ","); ?>
                            </th>
                            <th style="text-align: right;">
                                <?php echo bdt() . number_format($due, 2, ".", ","); ?>
                            </th>
                            <th colspan="3"></th>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td style="text-align: center;" colspan="10">
                                <?php echo errormessage('No orders found!!') ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Latest Placed Orders
                </div>
            </div>
            <div class="widget-body">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%;">SL.</th>
                            <th style="width: 20%;">Supplier</th>
                            <th style="text-align: center; width: 10%;">Placed</th>
                            <th style="text-align: center; width: 5%;">Item</th>
                            <th style="text-align: right; width: 15%;">Billed</th>
                            <th style="text-align: right; width: 15%;">Paid</th>
                            <th style="text-align: right; width: 15%;">Due</th>
                            <th style="text-align: center; width: 5%;">Status</th>
                            <th style="text-align: center; width: 5%;">View</th>
                            <th style="text-align: center; width: 5%;">Receive</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($order_list != FALSE) { $sl = 1; $billed = 0; $paid = 0; $due = 0; foreach($order_list->result() as $orders) {   ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $sl; ?></td>
                            <td><?php echo $orders->Supplier; ?></td>
                            <td style="text-align: center;"><?php echo date_format(date_create($orders->or_date), 'd-M-Y'); ?></td>
                            <td style="text-align: center;"><?php echo $orders->Item; ?></td>
                            <td style="text-align: right;">
                                <?php $billed = $billed + $orders->Billed; ?>
                                <?php echo bdt() . number_format($orders->Billed, 2, ".", ","); ?>
                            </td>
                            <td style="text-align: right;">
                                <?php $paid = $paid + $orders->Paid; ?>
                                <?php echo bdt() . number_format($orders->Paid, 2, ".", ","); ?>
                            </td>
                            <td style="text-align: right;">
                                <?php $current = $orders->Billed - $orders->Paid; ?>
                                <?php $due = $due + $current; ?>
                                <?php echo bdt() . number_format($current, 2, ".", ","); ?>
                            </td>
                            <td style="text-align: center;">
                                <?php // if($orders->Paid < $orders->Billed) { ?>
                                <!--<a href="<?php // echo site_url('order/payment/' . $orders->or_id); ?>" class="btn btn-mini btn-success btn-block">Pay</a>-->
                                <?php // } else if($orders->Paid > $orders->Billed) { ?>
                                <!--<a href="<?php // echo site_url('order/adjust/' . $orders->or_id . '/' . abs($current) . '/' . $orders->Company); ?>" class="btn btn-mini btn-warning btn-block">Adjust</a>-->
                                <?php // } else { ?>
                                <!--<a class="btn btn-mini btn-inverse btn-block">Pay</a>-->
                                <?php // } ?>
                                <?php if($orders->Status == 1) {    ?>
                                <b style="color: blue;">Placed</b>
                                <?php } else if($orders->Status == 2) { ?>
                                <b style="color: green;">Received</b>
                                <?php } else if($orders->Status == 3) { ?>
                                <b style="color: red;">Canceled</b>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo site_url('order/details/' . $orders->or_id); ?>">
                                    <i class="icon-profile"></i>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <?php if($orders->Status == 1) { ?>
                                <a href="<?php echo site_url('order/receive/' . $orders->or_id); ?>">
                                    <i class="icon-edit"></i>
                                </a>
                                <?php } else { ?>
                                <i class="icon-edit"></i>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php $sl++; } ?>
                        <tr>
                            <th colspan="4" style="text-align: right;">Total</th>
                            <th style="text-align: right;">
                                <?php echo bdt() . number_format($billed, 2, ".", ","); ?>
                            </th>
                            <th style="text-align: right;">
                                <?php echo bdt() . number_format($paid, 2, ".", ","); ?>
                            </th>
                            <th style="text-align: right;">
                                <?php echo bdt() . number_format($due, 2, ".", ","); ?>
                            </th>
                            <th colspan="3"></th>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td style="text-align: center;" colspan="10">
                                <?php echo errormessage('No orders found!!') ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Current Due Invoice List
                </div>
            </div>
            <div class="widget-body">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%;">SL.</th>
                            <th style="width: 8%; text-align: center;">Invoice</th>
                            <th style="width: 8%; text-align: center;">Date</th>
                            <th style="width: 11%;">DSR/Customer</th>
                            <th style="width: 11%;">Branch</th>
                            <th style="width: 14%; text-align: right;">Billed</th>
                            <th style="width: 14%; text-align: right;">Paid</th>
                            <th style="width: 14%; text-align: right;">Due</th>
                            <th style="width: 4%; text-align: center;" class="noprint">Pay</th>
                            <th style="width: 4%; text-align: center;" class="noprint">View</th>
                            <th style="width: 5%; text-align: center;" class="noprint">Edit</th>
                        </tr>
                    </thead>
                    <tbody id="invoice_list">
                        <?php if($invoices != FALSE) { $sl = 1; foreach($invoices->result() as $invoices) {  ?>
                        <tr>
                            <td style="text-align: center; width: 5%;">
                                <?php echo $sl; ?>
                            </td>
                            <td style="text-align: center;">
                                <?php echo $invoices->inv_id; ?>
                            </td>
                            <td style="text-align: center;">
                                <?php echo date_format(date_create($invoices->sale_date), 'd-M-Y'); ?>
                            </td>
                            <td>
                                <?php echo $invoices->Customer; ?>
                            </td>
                            <td>
                                <?php echo $invoices->Branch; ?>
                            </td>
                            <td style="text-align: right;">
                                <?php echo bdt() . number_format($invoices->Billed, 2, ".", ","); ?>
                            </td>
                            <td style="text-align: right;">
                                <?php echo bdt() . number_format($invoices->Paid, 2, ".", ","); ?>
                            </td>
                            <td style="text-align: right;">
                                <?php echo bdt() . number_format(($invoices->Billed - $invoices->Paid), 2, ".", ","); ?>
                            </td>
                            <td style="text-align: center;" class="noprint">
                                <?php if($invoices->status == 1) { if($invoices->Paid == NULL) { $total_paid = 0; } else { $total_paid = $invoices->Paid; } ?>
                                <a class="btn btn-mini btn-success" href="#paymentModal" role="button" data-toggle="modal"
                                   onclick="set_modal_value('<?php echo $invoices->Billed; ?>',
                                                            '<?php echo $total_paid; ?>',
                                                            '<?php echo $invoices->inv_id; ?>',
                                                            '<?php echo $invoices->branch_id; ?>',
                                                            '<?php echo $invoices->client_id; ?>',
                                                            '<?php echo $invoices->sale_date; ?>',
                                                            '<?php echo $invoices->Billed - $invoices->Paid; ?>')">
                                    Pay
                                </a>    
                                <?php } else if($invoices->status == 2) {   ?>
                                <button type="button" class="btn btn-mini btn-inverse">Paid</button>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;" class="noprint">
                                <a href="<?php echo site_url('sales/details?func=details&cat=sales&mod=admin&sess_auth=' . md5(date('Ymdhis')) . '&remote=' . md5($memb) . '&invoice=' . $invoices->inv_id . '&customer=' . $invoices->client_id); ?>">
                                    <i class="icon-profile"></i>
                                </a>
                            </td>
                            <td style="text-align: center;" class="noprint">
                                <?php if($invoices->status == 1 && $invoices->branch_id == $b_id) {  ?>
                                <a href="<?php echo site_url('sales/update?func=update&cat=sales&mod=admin&sess_auth=' . md5(date('Ymdhis')) . '&remote=' . md5($memb) . '&invoice=' . $invoices->inv_id . '&customer=' . $invoices->client_id); ?>">
                                    <i class="icon-edit"></i>
                                </a>
                                <?php } else {  ?>
                                <i class="icon-edit"></i>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php $sl++; } } else { ?>
                        <tr>
                            <td colspan="11" class="center-align-text">
                                <?php echo errormessage('No Data Found!!'); ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>