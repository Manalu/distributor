<?php

/**
 * Description of invoice_list
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
                    <?php widgetHeader(); ?> Invoice List
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <div class="span3 form-inline">
                    <script>
                        $(function() {
                            $("#sales_date_start").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date("Y-m-d"); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">From</label>
                        <div class="controls">
                            <input name="sales_date_start" id="sales_date_start" class="span12" readonly="readonly" type="text" value="<?php echo date('Y-m-01') ?>" />
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <script>
                        $(function() {
                            $("#sales_date_end").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date("Y-m-d"); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">To</label>
                        <div class="controls">
                            <input name="sales_date_end" id="sales_date_end" class="span12" readonly="readonly" type="text" value="<?php echo date('Y-m-d') ?>" />
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">DSR/Customer</label>
                        <div class="controls controls-row">
                            <select class="span12" id="customer" name="customer">
                                <option value="">Select a DSR or Customer</option>
                                <?php if($customer != FALSE) { foreach ($customer->result() as $customer) { ?>
                                <option value="<?php echo $customer->cl_id; ?>"><?php echo $customer->cl_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">Invoice No.</label>
                        <div class="controls controls-row">
                            <input name="invoice" id="invoice" class="span12" placeholder="Invoice No." type="text" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="span12 center-align-text">
                    <button type="button" class="btn btn-primary" id="invoice_search_button">Search </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%;">SL.</th>
                            <th style="width: 8%; text-align: center;">Invoice</th>
                            <th style="width: 8%; text-align: center;">Date</th>
                            <th style="width: 11%;">DSR/Customer</th>
                            <th style="width: 11%;">Market</th>
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
                                <?php echo $invoices->Market; ?>
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
                                <?php if($invoices->status == 1 && $invoices->branch_id == $b_id) { if($invoices->Paid == NULL) { $total_paid = 0; } else { $total_paid = $invoices->Paid; } ?>
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
                                <?php if($invoices->branch_id == $b_id) {  ?>
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
<script type="text/javascript">
    $("#invoice_search_button").click(function(){
        var customer    = $("#customer").val();
        var startd8     = $("#sales_date_start").val();
        var finsd8      = $("#sales_date_end").val();
        var invoice     = $("#invoice").val();
        if(invoice.length > 0){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sales/search_by_invoice'); ?>",
                data: {invoice: invoice},
                cache: false,
                beforeSend: function(){
                  $('#invoice_list').html(
                      '<tr><td colspan="11" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
                  );
               },
                success: function(html){
                    $("#invoice_list").html(html);
                 },
                 error:function(html){
                     $("#invoice_list").html(html.responseText);
                 }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sales/search_by_data'); ?>",
                data: {client_id: customer, starting: startd8, ending: finsd8},
                cache: false,
                beforeSend: function(){
                  $('#invoice_list').html(
                      '<tr><td colspan="11" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
                  );
               },
                success: function(html){
                    $("#invoice_list").html(html);
                 },
                 error:function(html){
                     $("#invoice_list").html(html.responseText);
                 }
            });
        }
    });
    
    function set_modal_value(bill, paid, invoice, branch, client, saledate, due){
        $("#payment_amount").attr("max", due);
        $("#bill_amount").val(bill);
        $("#paid_amount").val(paid);
        $("#invoice_id").val(invoice);
        $("#branch_id").val(branch);
        $("#client_id").val(client);
        $("#payment_date").datepicker({ format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, startDate: saledate, endDate: "<?php echo date('Y-m-d') ?>" });
    }
</script>
<div id="paymentModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> × </button>
        <h4 id="myModalLabel">
            Due Payment
        </h4>
    </div>
    <div class="modal-body">
        <form action="<?php echo site_url('sales/payment'); ?>" method="post" class="form-horizontal">
            <div class="control-group">
                <label class="control-label">Paid Amount</label>
                <div class="controls controls-row">
                    <input type="number" name="payment_amount" id="payment_amount" max="" min="0" class="span3" placeholder="Paid Amount" autofocus="on" autocomplete="off" required="required" step="any" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Payment Date</label>
                <div class="controls">
                    <input type="text" name="payment_date" id="payment_date" class="span3" placeholder="Payment Date" value="<?php echo date('Y-m-d') ?>" autocomplete="off" required="required" readonly="readonly" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Method</label>
                <div class="controls">
                    <select name="method" id="method" required="required" class="span3">
                        <option value="">Select Payment Method</option>
                        <?php if($method != FALSE) { foreach($method->result() as $method) {    ?>
                        <option value="<?php echo $method->tble_id; ?>">
                            <?php echo $method->method; ?>
                        </option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
            <div class="form-actions no-margin">
                <input type="hidden" name="redirect" id="redirect" value="sales/list" />
                <input type="hidden" name="bill_amount" id="bill_amount" />
                <input type="hidden" name="paid_amount" id="paid_amount" />
                <input type="hidden" name="invoice_id" id="invoice_id" />
                <input type="hidden" name="branch_id" id="branch_id" />
                <input type="hidden" name="client_id" id="client_id" />
                <input type="hidden" name="trigger" id="trigger" value="payment" />
                <input type="submit" class="btn btn-primary" value="Submit Payment" />
            </div>
        </form>
    </div>
</div>