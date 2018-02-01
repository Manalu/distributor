    
    
    
<form action="<?php echo site_url('order/adjust'); ?>" method="post">
    <div class="row-fluid">
        <div class="span6">
            <div class="widget no-margin">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Payment Information
                    </div>
                </div>
                <div class="widget-body">
                    <?php notification(); ?>
                </div>
                <div id="printable">
                    <div class="widget-body">
                        <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                            <thead>
                                <tr>
                                    <th style="width: 5%;text-align:center;">SL.</th>
                                    <th style="width: 25%;">Date</th>
                                    <th style="width: 15%; text-align: right;">Amount</th>
                                    <th style="width: 15%; text-align: center;">
                                        Adjust
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($payments != FALSE) { $i = 1; foreach ($payments->result() as $item) {  ?>
                                <tr>
                                    <td style="text-align:center;"><?php echo $i;?></td>
                                    <td style=""><?php echo date_format(date_create($item->op_date), 'd-M-Y');?></td>
                                    <td style="text-align: right;">
                                        <?php echo bdt() . number_format($item->op_amount, 2, ".", ",");?>
                                    </td>
                                    <td style="text-align: center; cursor: pointer;">
                                        <?php if($item->op_amount > $amount) {  ?>
                                        <input type="radio" name="adjust" value="<?php echo $item->op_id; ?>"
                                               onclick="set_payment_info('<?php echo $item->op_id ?>', '<?php echo $item->op_amount; ?>',
                                                       '<?php echo $item->op_vchr_id; ?>', '<?php echo $amount; ?>')" />
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php $i++; } } ?>        
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="span6">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Adjustment
                    </div>
                </div>
                <div class="widget-body">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 6%;">SL.</th>
                                <th style="text-align: center; width: 15%;">Date</th>
                                <th style="text-align: right; width: 23%;">Bill</th>
                                <th style="text-align: right; width: 23%;">Paid</th>
                                <th style="text-align: right; width: 23%;">Due</th>
                                <th class="center-align-text" style="width: 10%;">Adjust</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($order_list != FALSE) { $sl = 1; $billed = 0; $paid = 0; $due = 0; foreach($order_list->result() as $orders) { if($orders->Paid < $orders->Billed && $orders->or_id != $disorid) {  ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $sl; ?></td>
                                <td style="text-align: center;"><?php echo date_format(date_create($orders->or_date), 'd-M-Y'); ?></td>
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
                                    <?php if($current > $amount) { ?>
                                    <input type="radio" name="op_orid" value="<?php echo $orders->or_id; ?>" onclick="set_new_order_id('<?php echo $orders->or_id; ?>', '<?php echo $orders->Company; ?>')" />
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php $sl++; } } ?>
                            <tr>
                                <th colspan="2" style="text-align: right;">Total</th>
                                <th style="text-align: right;">
                                    <?php echo bdt() . number_format($billed, 2, ".", ","); ?>
                                </th>
                                <th style="text-align: right;">
                                    <?php echo bdt() . number_format($paid, 2, ".", ","); ?>
                                </th>
                                <th style="text-align: right;">
                                    <?php echo bdt() . number_format($due, 2, ".", ","); ?>
                                </th>
                                <th colspan=""></th>
                            </tr>
                            <?php } else { ?>
                            <tr>
                                <td style="text-align: center;" colspan="6">
                                    <?php echo errormessage('No orders found!!') ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="widget-body form-horizontal">
                    <script>
                    $(function() {
                            $("#op_date").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, startDate: '<?php echo date('Y-m-d'); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">Payment Date</label>
                        <div class="controls">
                            <input name="op_date" id="op_date" class="span12" value="<?php echo date('Y-m-d'); ?>" type="text" autocomplete="off" readonly="readonly" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="payment_method" value="1" />
                        <input type="hidden" name="order_payment_id" id="order_payment_id"  />
                        <input type="hidden" name="order_payment_value" id="order_payment_value" />
                        <input type="hidden" name="order_payment_voucher" id="order_payment_voucher" />
                        <input type="hidden" name="order_payment_adjust" id="order_payment_adjust" />
                        <input type="hidden" name="new_order_id" id="new_order_id" />
                        <input type="hidden" name="new_comp_id" id="new_comp_id" />
                        <input type="hidden" name="old_order_id" id="old_order_id" />
                        <input type="hidden" name="trigger" value="purchase_payment" />
                        <input type="submit" value="Payment Adjustment" class="btn btn-success" />
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    function set_payment_info(opid, amount, voucher, adjust){
        $("#order_payment_id").val(opid);
        $("#order_payment_value").val(amount);
        $("#order_payment_voucher").val(voucher);
        $("#order_payment_adjust").val(adjust);
    }
    
    function set_new_order_id(order_id, company){
        $("#new_order_id").val(order_id);
        $("#new_comp_id").val(company);
    }
</script>