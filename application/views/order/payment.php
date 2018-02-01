<?php

/**
 * Description of payment
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
                    <?php widgetHeader(); ?> Purchase Order Payment
                </div>
            </div>
            <div class="widget-body"><?php notification(); ?></div>
            <div class="clearfix"></div>
            <div class="widget-body">
                <div class="span6">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <tbody>
                            <tr>
                                <td>Supplier Name</td>
                                <td><?php echo $order_info->Supplier; ?></td>
                            </tr>
                            <tr>
                                <td>Order Date</td>
                                <td><?php echo date_format(date_create($order_info->or_date), "d-M-Y"); ?></td>
                            </tr>
                            <tr>
                                <td>Sub-Total</td>
                                <td><?php echo bdt() . number_format($order_info->SubTotal, 2, ".", ","); ?></td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td><?php echo bdt() . number_format($order_info->Discount, 2, ".", ","); ?></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td><?php echo bdt() . number_format($order_info->Total, 2, ".", ","); ?></td>
                            </tr>
                            <tr>
                                <td>Paid</td>
                                <td><?php echo bdt() . number_format($order_info->Paid, 2, ".", ","); ?></td>
                            </tr>
                            <tr>
                                <td>Due</td>
                                <td><?php echo bdt() . number_format(($order_info->Total - $order_info->Paid), 2, ".", ","); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">SL.</th>
                                <th style="width: 40%;">Name</th>
                                <th style="text-align: center; width: 15%;">QTY</th>
                                <th style="text-align: center; width: 15%;">BONUS</th>
                                <th style="text-align: right; width: 25%;">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($order_item != FALSE) { $sl = 1; foreach($order_item->result() as $items) { ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $sl; ?></td>
                                <td><?php echo $items->name; ?></td>
                                <td style="text-align: center;"><?php echo $items->qty ?></td>
                                <td style="text-align: center;"><?php echo $items->bonus ?></td>
                                <td style="text-align: right;"><?php echo bdt() . number_format($items->t_rate, 2, ".", ","); ?></td>
                            </tr>
                            <?php $sl++; } } ?>
                        </tbody>
                    </table>    
                </div>
                <div class="span6">
                    <form action="" class="form-horizontal" method="POST">
                        <div class="control-group">
                            <label class="control-label">Paid Amount</label>
                            <div class="controls controls-row">
                                <input type="number" class="span12" name="op_amount" required="required" max="<?php echo ($order_info->Total - $order_info->Paid); ?>" min="1" placeholder="Paid Amount" autocomplete="off" autofocus="on" />
                            </div>
                        </div>
                        <script>
                        $(function() {
                                $("#op_date").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, startDate: '<?php echo $order_info->or_date; ?>', endDate: '<?php echo date("Y-m-d"); ?>'});
                            });
                        </script>
                        <div class="control-group">
                            <label class="control-label" for="from">Payment Date</label>
                            <div class="controls">
                                <input name="op_date" id="op_date" class="span12" value="<?php echo date('Y-m-d'); ?>" type="text" autocomplete="off" readonly="readonly" />
                            </div>
                        </div>
<!--                        <div class="control-group">
                            <label class="control-label">Payment Method</label>
                            <div class="controls controls-row">
                                <select class="span12" name="payment_method" id="payment_method" required="required" onchange="get_bank_accounts()">
                                    <option value="">Select Payment Method</option>
                                    <option value="1">Cash</option>
                                    <option value="2">Bank Deposit</option>
                                </select>
                            </div>
                        </div>-->
                        <div id="bank_account_div">
                        </div>
                        <div class="form-actions">
                            <input type="hidden" name="payment_method" value="1" />
                            <input type="hidden" name="total_billed" value="<?php echo $order_info->Total; ?>" readonly="readonly" />
                            <input type="hidden" name="total_paid" value="<?php echo $order_info->Paid; ?>" />
                            <input type="hidden" name="op_orid" value="<?php echo $order_info->or_id; ?>" />
                            <input type="hidden" name="trigger" value="purchase_payment" />
                            <input type="submit" value="Order Payment" class="btn btn-success" />
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function get_bank_accounts(){
        var bank_accounts = $("#payment_method").val();
        if(bank_accounts == 2){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('order/get_bank_accounts'); ?>",
                data: {bank_accounts: bank_accounts},
                cache: false,
                success: function(html){
                   $("#bank_account_div").html(html);
                },
                error:function(html){
                    alert(html.responseText);
                    alert(html.responseStatus);
                }
            });
        } else if(bank_accounts == 1){
            $("#bank_account_div").html("");
        }
    }
</script>