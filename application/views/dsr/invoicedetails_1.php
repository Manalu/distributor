

<div class="span6">
    <h4><?php echo $sale_type; ?></h4>
    <p>Invoice No: <?php echo $inv_id; ?></p>
</div>
<div class="span6">
    <h4 style="text-align: right;">Date: <?php echo date_format(date_create($sale_info->inv_sale_date), "d-M-Y"); ?></h4>
    <p style="text-align: right;">Branch: <?php echo $sale_info->b_name; ?></p>
</div>
<div class="clearfix"></div>
<table class="table table-condensed">
    <thead>
        <tr>
            <th>Name</th>
            <th class="center-align-text">Quantity</th>
            <th style="text-align: right;">Price</th>
        </tr>
    </thead>
    <tbody>
        <?php if($inv_items != FALSE) { foreach($inv_items->result() as $items) {   ?>
        <tr>
            <td>
                <?php echo $items->p_name; ?>
            </td>
            <td class="center-align-text">
                <?php echo $items->it_qty; ?>
            </td>
            <td style="text-align: right;">
                <?php echo bdt() . number_format($items->it_pro_prce, 2, ".", ","); ?>
            </td>
        </tr>
        <?php } } ?>
        <tr>
            <th colspan="2" style="text-align: right;">Sub-Total</th>
            <th style="text-align: right;">
                <?php echo bdt() . number_format($sale_info->inv_sub_total, 2, ".", ","); ?>
            </th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Discount</th>
            <th style="text-align: right;">
                <?php echo bdt() . number_format($sale_info->inv_discount, 2, ".", ","); ?>
            </th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Total</th>
            <th style="text-align: right;">
                <?php echo bdt() . number_format($sale_info->inv_all_total, 2, ".", ","); ?>
            </th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right; color: Green;">Paid</th>
            <th style="text-align: right; color: Green;">
                <?php echo bdt() . number_format($sale_info->Paid, 2, ".", ","); ?>
            </th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right; color: red;">Outstanding</th>
            <th style="text-align: right; color: red;">
                <?php echo bdt() . number_format(($sale_info->inv_all_total - $sale_info->Paid), 2, ".", ","); ?>
            </th>
        </tr>
        <?php $due = ($sale_info->inv_all_total - $sale_info->Paid); ?>
        <?php if($due > 0 && $sale_info->inv_status == 2) {    ?>
        <tr>
            <th colspan="3" class="center-align-text">
                <a href="#paymentModal" role="button" class="btn btn-small btn-primary btn-block" data-toggle="modal" data-original-title="">
                    Pay Due Amount
                </a>
            </th>
        </tr>
        <?php } ?>
    </tbody>
</table>
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
                    <input type="number" name="payment_amount" id="payment_amount" max="<?php echo $due; ?>" min="1" class="span12" placeholder="Paid Amount" autofocus="on" autocomplete="off" required="required" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Sale Date</label>
                <div class="controls">
                    <input type="text" name="payment_date" id="payment_date" class="span12" placeholder="Payment Date" value="<?php echo date('Y-m-d') ?>" autocomplete="off" required="required" readonly="readonly" />
                </div>
                <script>
                    $(function() {
                        $("#payment_date").datepicker({ format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, startDate: "<?php echo $sale_info->inv_sale_date; ?>", endDate: "<?php echo date('Y-m-d') ?>" });
                    });
                </script>
            </div>
            <div class="form-actions no-margin">
                <input type="hidden" name="redirect" id="redirect" value="clients/details?func=details&cat=clients&mod=admin&sess_auth=c6a16c8a24edbc6186a290b390a472a1&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=<?php echo $client_id; ?>" />
                <input type="hidden" name="bill_amount" id="bill_amount" value="<?php echo $sale_info->inv_all_total; ?>" />
                <input type="hidden" name="paid_amount" id="paid_amount" value="<?php echo $sale_info->Paid; ?>" />
                <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $inv_id; ?>" />
                <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $sale_info->branch_id; ?>" />
                <input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id; ?>" />
                <input type="hidden" name="trigger" id="trigger" value="payment" />
                <input type="submit" class="btn btn-primary" value="Submit Payment" />
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function get_payment_form(invid, due, client){
        $("#inv_id").val(invid);
        $("#cl_id").val(client);
        $("#paid_amount").attr("max", due);
    }
</script>