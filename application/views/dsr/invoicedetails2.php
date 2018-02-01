


<table class="table table-condensed">
    <thead>
        <tr>
            <th>Name</th>
            <th class="center-align-text">Quantity</th>
            <th style="text-align: right;">Price</th>
        </tr>
    </thead>
    <tbody>
        <?php if($invit != FALSE) { foreach ($invit->result() as $invoicedetails) { ?>
        <tr>
            <td><?php echo getMedicineNameByMedicineId($invoicedetails->MedId); ?></td>
            <td class="center-align-text"><?php echo $invoicedetails->Quantity; ?></td>
            <td style="text-align: right;"><?php echo bdt() . number_format($invoicedetails->Price, 2, ".", ","); ?></td>
        </tr>
        <?php } ?>
        <tr>
            <th colspan="2" style="text-align: right;">Sub-Total</th>
            <th style="text-align: right;"><?php echo bdt() . number_format($invfo->inv_sub_total, 2, ".", ","); ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">
                <?php if($invfo->inv_dis_type == "P") {
                    echo 'Discount ' . $invfo->inv_discount . ' %';
                } else { 
                    echo 'Discount';
                } ?>
            </th>
            <th style="text-align: right;">
                <?php
                if($invfo->inv_dis_type == "P") {
                    $discount = (($invfo->inv_sub_total * $invfo->inv_discount) / 100);
                } else {
                    $discount = $invfo->inv_discount;
                } ?>
                <?php echo bdt() . number_format($discount, 2, ".", ","); ?>
            </th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Total</th>
            <th style="text-align: right;"><?php echo bdt() . number_format($invfo->inv_all_total, 2, ".", ","); ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Paid</th>
            <th style="text-align: right;"><?php echo bdt() . number_format($invfo->Paid, 2, ".", ","); ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Outstanding</th>
            <?php $dues_amount = $invfo->inv_all_total - $invfo->Paid; ?>
            <th style="text-align: right;">&#2547; <?php echo number_format($dues_amount, 2, ".", ","); ?></th>
        </tr>
        <?php } ?>
        <?php if($dues_amount > 0) { ?>
        <tr>
            <td colspan="3" style="text-align: center;">
                <a onclick="get_payment_form('<?php echo $invid; ?>', '<?php echo $dues_amount; ?>', '<?php echo $client; ?>')" class="btn btn-primary" href="#myModal" role="button" data-toggle="modal">
                    Pay Outstanding
                </a>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <form action="<?php echo site_url('clients/bill_payment'); ?>" method="POST" class="form-horizontal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Invoice Payment</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="control-group">
                                        <label class="control-label">Paid Amount</label>
                                        <div class="controls controls-row">
                                            <input class="span12" type="number" name="paid_amount" id="paid_amount" placeholder="Paid Amount" autofocus="on" min="1" max="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" name="trigger" value="bill_payment" />
                                    <input type="hidden" name="cl_id" id="cl_id" value="" />
                                    <input type="hidden" name="inv_id" id="inv_id" value="" />
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Make Payment</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<script type="text/javascript">
    function get_payment_form(invid, due, client){
        $("#inv_id").val(invid);
        $("#cl_id").val(client);
        $("#paid_amount").attr("max", due);
    }
</script>