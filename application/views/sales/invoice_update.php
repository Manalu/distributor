<?php

/**
 * Description of invoice_details
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<form action="<?php echo site_url('sales/exchange'); ?>" method="POST">
    <input type="hidden" name="invoice_id" value="<?php echo $invoice_info->inv_id; ?>" />
    <input type="hidden" name="total_item" value="<?php echo $total_item; ?>" />
    <input type="hidden" name="branch_id" value="<?php echo $invoice_info->branch_id; ?>" />
    <input type="hidden" name="client_id" value="<?php echo $invoice_info->client_id; ?>" />
    <div class="row-fluid">
        <div class="span12">
            <div class="widget no-margin">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Invoice Details
                    </div>
                </div>
                <div class="widget-body">
                    <?php notification(); ?>
                </div>
                <div id="printable">
                    <div class="widget-body">
                        <div class="invoice">
                            <div class="row-fluid">
                                <div class="span4">
                                    <div class="invoice-data-container">
                                        <address class="no-margin">
                                            <b><?php echo $ShopName; ?></b>
                                            <span><?php echo $ShopAdrs; ?>,</span>
                                            <span><abbr title="Phone">Phone :</abbr> <?php echo $ShopPhone; ?>,</span>
                                            <span>Branch: <?php echo get_branch_name($b_id); ?></span>
                                        </address>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="invoice-data-container">
                                        <address class="no-margin">
                                            <b><?php echo $info->cl_name; ?></b>
                                            <span><b><?php echo $info->cl_email;?></b></span>
                                            <span><abbr title="Phone">Phone :</abbr> <?php echo $info->cl_phone_no;?></span>
                                            <span><abbr title="Phone">Mobile :</abbr> <?php echo $info->cl_mobile_no; ?></span>
                                            <!--<span><abbr title="Phone">Memo :</abbr> <?php //echo $info->or_comp_memo; ?></span>-->
                                        </address>
                                    </div>
                                </div>
                                <div class="span4">
                                    <div class="invoice-data-container">
                                        <address class="no-margin">
                                            <b>Details</b>
                                            <span>Invoice No.: <?php echo $invoice_info->inv_id;?></span>
                                            <span>Generated On: <?php echo date_format(date_create($invoice_info->sale_date), 'd-M-Y'); ?></span>
                                            <?php if($invoice_info->status == 2) { ?> <span style="font-weight: bold; color: green;">Status: <?php echo 'Paid'; ?></span> <?php } ?>
                                            <?php if($invoice_info->status == 1) { ?> <span style="font-weight: bold; color: red;">Status: <?php echo 'Due'; ?></span> <?php } ?>
                                            <span><?php //echo $info->or_notes; ?></span>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-body">
                        <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                            <thead>
                                <tr>
                                    <th style="width: 5%;text-align:center;">SL</th>
                                    <th style="width: 15%;">Product</th>
                                    <th style="width: 10%;">Company</th>
                                    <th style="width: 5%; text-align: center;">Stock</th>
                                    <th style="width: 5%; text-align: center;">Box</th>
                                    <th style="width: 10%; text-align: center;">Cartoon</th>
                                    <th style="width: 10%; text-align: center;">Piece</th>
                                    <th style="width: 10%; text-align: center;">Bonus</th>
                                    <th style="width: 10%; text-align:center;">Total</th>
                                    <th style="width: 10%; text-align: center;">Rate</th>
                                    <th style="width: 10%; text-align: right;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($items != FALSE) { $i = 1; $sub_total = 0; foreach ($items->result() as $item) {?>
                                <tr>
                                    <td style="text-align:center;">
                                        <input type="hidden" name="tble_id[]" value="<?php echo $item->itm_id; ?>" />
                                        <input type="hidden" name="company_id[]" value="<?php echo $item->company_id; ?>" />
                                        <input type="hidden" name="product_id[]" value="<?php echo $item->product_id; ?>" />
                                        <input type="hidden" name="group_id[]" value="<?php echo $item->group_id; ?>" />
                                        <input type="hidden" name="cartoon[]" value="<?php echo $item->cartoon; ?>" />
                                        <input type="hidden" name="piece[]" value="<?php echo $item->piece; ?>" />
                                        <input type="hidden" name="bonus[]" value="<?php echo $item->bonus; ?>" />
                                        <input type="hidden" name="quantity[]" value="<?php echo $item->quantity; ?>" />
                                        <input type="hidden" name="price[]" value="<?php echo $item->price; ?>" />
                                        <input type="hidden" name="stock[]" value="<?php echo $item->stock; ?>" />
                                        <?php echo $i;?>
                                    </td>
                                    <td style=""><?php echo $item->p_name; ?></td>
                                    <td style=""><?php echo $item->c_name; ?></td>
                                    <td style="text-align: center;">
                                        <b>
                                            <?php if($item->stock == NULL) {
                                                echo 0;
                                            } else {
                                                $box = get_number_of_boxes($item->stock, $item->p_box_qty);
                                                $rem = get_number_of_remainder($item->stock, $item->p_box_qty);
                                                echo $box . '/' . $rem;
                                            } ?>
                                        </b>
                                    </td>
                                    <td style="text-align: center;"><?php echo $item->p_box_qty; ?></td>
                                    <td class="center-align-text vertical-align-mid">
                                        <input type="hidden" name="cart_price[]" id="<?php echo 'cart_price_' . $item->product_id; ?>" value="<?php echo $item->price; ?>" class="sum" />
                                        <input id="<?php echo 'cart_box_' . $item->product_id; ?>"
                                        onkeyup="calculate_cartoon_piece('<?php echo $item->p_box_qty; ?>', '<?php echo $item->product_id; ?>', '<?php echo $item->p_box_bonus; ?>'), calculate_cart_item_price('<?php echo $item->p_u_price; ?>', '<?php echo $item->product_id; ?>')"
                                        type="number" class="span12" name="cartoon_new[]" style="text-align: center;" value="<?php echo $item->cartoon; ?>" />
                                    </td>
                                    <td class="center-align-text vertical-align-mid">
                                        <input onkeyup="calculate_cartoon_piece('<?php echo $item->p_box_qty; ?>', '<?php echo $item->product_id; ?>', '<?php echo $item->p_box_bonus; ?>'), calculate_cart_item_price('<?php echo $item->p_u_price; ?>', '<?php echo $item->product_id; ?>')" id="<?php echo 'cart_pcs_' . $item->product_id; ?>" type="number" class="span12" name="piece_new[]" style="text-align: center;" value="<?php echo $item->piece; ?>" />
                                    </td>
                                    <td class="center-align-text vertical-align-mid">
                                        <input onkeyup="calculate_bonus_piece('<?php echo $item->p_box_qty; ?>', '<?php echo $item->product_id; ?>')"
                                               id="<?php echo 'cart_bns_' . $item->product_id; ?>"
                                               type="number" class="span12" name="bonus_new[]" style="text-align: center;" value="<?php echo $item->bonus; ?>" />
                                    </td>
                                    <td style="text-align:center;" class="center-align-text vertical-align-mid">
                                        <input onfocus="get_focus_out('<?php echo $item->product_id; ?>')" id="<?php echo 'cart_qty_' . $item->product_id; ?>" value="<?php echo $item->quantity; ?>" type="number" name="quantity_new[]" style="text-align: center;" max="<?php echo $item->quantity; ?>" />
                                    </td>
                                    <td class="center-align-text vertical-align-mid">
                                        <input onkeyup="calculate_cartoon_piece('<?php echo $item->p_box_qty; ?>', '<?php echo $item->product_id; ?>', '<?php echo $item->p_box_bonus; ?>')" value="<?php echo number_format($item->p_u_price, 2, ".", ","); ?>" id="<?php echo 'cart_prc_' . $item->product_id; ?>" step="any" type="number" class="span12" name="u_rate[]" style="text-align: center;" />
                                    </td>
                                    <td style="text-align: right;" id="<?php echo 'price_label_' . $item->product_id; ?>">
                                        <?php $sub_total = $sub_total + $item->price; ?>
                                        <?php echo bdt() . number_format($item->price, 2, ".", ","); ?>
                                    </td>
                                </tr>
                            <?php  $i++; } }  ?>
                                <tr>
                                    <td colspan="9" style="text-align: right;">
                                        <input type="hidden" name="earlier_sub_total" id="earlier_sub_total" value="<?php echo $invoice_info->sub_total; ?>" />
                                        <input type="hidden" name="previous_bill" id="previous_bill" value="<?php echo $invoice_info->total_bill; ?>" />
                                        <input type="hidden" name="earlier_total_bill" id="earlier_total_bill" value="<?php echo $invoice_info->total_bill; ?>" />
                                        <input type="hidden" name="earlier_paid" id="earlier_paid" value="<?php echo $invoice_info->Paid; ?>" />
                                        Sub-Total
                                    </td>
                                    <td style="text-align: right;" id="sub_total_label" colspan="2">
                                        <?php echo bdt() . number_format($invoice_info->sub_total, 2, ".", ","); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9" style="text-align: right;">
                                        Discount
                                    </td>
                                    <td style="text-align: right;" colspan="2">
                                        <input onkeyup="calculate_total_price()" value="<?php echo $invoice_info->discount; ?>" name="invoice_discount" type="number" id="invoice_discount" class="span12" style="text-align: right;" step="any" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9" style="text-align: right;">
                                        <input type="hidden" name="total_bill" id="total_bill" value="<?php echo $invoice_info->total_bill; ?>" />
                                        Total
                                    </td>
                                    <td style="text-align: right;" id="total_bill_label" colspan="2">
                                        <?php echo bdt() . number_format($invoice_info->total_bill, 2, ".", ","); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9" style="text-align: right;">
                                        <input type="hidden" name="paid_amount" id="paid_amount" value="<?php echo $invoice_info->Paid; ?>" />
                                        Paid
                                    </td>
                                    <td style="text-align: right;" id="paid_label" colspan="2">
                                        <?php echo bdt() . number_format($invoice_info->Paid, 2, ".", ","); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9" style="text-align: right;">
                                        <input type="hidden" name="adjustment_value" id="adjustment_value" value="" />
                                        <input type="hidden" name="previous_paid" value="<?php echo $invoice_info->Paid; ?>" />
                                        <input type="hidden" name="previous_due" value="<?php echo $invoice_info->total_bill; ?>" />
                                        Adjust
                                    </td>
                                    <td style="text-align: right;" id="adjustment_label" colspan="2">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="9" style="text-align: right;">
                                        Payment
                                    </td>
                                    <td style="text-align: right;" id="notes_label" colspan="2">
                                        <input type="number" step="any" name="invoice_payment" id="invoice_payment" value="<?php echo ($invoice_info->total_bill - $invoice_info->Paid) ?>" style="text-align: right;" class="span12" /> 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8"></td>
                                    <td colspan="3" style="text-align: right;">
                                        <input type="hidden" name="trigger" value="update" />
                                        <a href="<?php echo site_url('sales/list'); ?>" class="btn btn-default">Back To List</a>
                                        <input type="submit" class="btn btn-primary" id="update_invoice" value="Update invoice" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                    <?php include 'application/views/common/marketing.php'; ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    function get_focus_out(proid){
        $("#cart_qty_" + proid).blur();
    }
    
    function calculate_cartoon_piece(boxqty, proid, bonus){
        var cartoon     = parseInt($("#cart_box_" + proid).val());
        $("#cart_bns_" + proid).val(bonus * cartoon);
        var pieceq      = parseInt($("#cart_pcs_" + proid).val());
        var bonusq      = parseInt($("#cart_bns_" + proid).val());
        if(isNaN(cartoon)){ cartoon = 0; }
        if(isNaN(pieceq)){ pieceq = 0; }
        if(isNaN(bonusq)){ bonusq = 0; }
        var totalqty    = (cartoon * boxqty) + pieceq + bonusq;
        $("#total_quantity_" + proid).html(totalqty);
        $("#cart_qty_" + proid).val(totalqty);
        
        var quantity    = $("#cart_qty_" + proid).val();
        var unitprce    = $("#cart_prc_" + proid).val();
        var itemprice   = (unitprce * quantity);
        $("#price_label_" + proid).html("<?php echo bdt(); ?> " + itemprice.toFixed(2));
        $("#cart_price_" + proid).val(itemprice);
        
        calculate_total_price();
    }
    
    function calculate_bonus_piece(boxqty, proid){
        var cartoon     = parseInt($("#cart_box_" + proid).val());
        var pieceq      = parseInt($("#cart_pcs_" + proid).val());
        var bonusq      = parseInt($("#cart_bns_" + proid).val());
        if(isNaN(cartoon)){ cartoon = 0; }
        if(isNaN(pieceq)){ pieceq = 0; }
        if(isNaN(bonusq)){ bonusq = 0; }
        var totalqty    = (cartoon * boxqty) + pieceq + bonusq;
        $("#total_quantity_" + proid).html(totalqty);
        $("#cart_qty_" + proid).val(totalqty);
        
        var quantity    = $("#cart_qty_" + proid).val();
        var unitprce    = $("#cart_prc_" + proid).val();
        var itemprice   = (unitprce * (quantity - bonusq));
        $("#price_label_" + proid).html("<?php echo bdt(); ?> " + itemprice.toFixed(2));
        $("#cart_price_" + proid).val(itemprice);
        total_price();
    }
    
    function calculate_total_price(){
        var sub_total = 0;
        $('.sum').each(function (index, element) {
            sub_total = sub_total + parseFloat($(element).val());
        });
        $("#sub_total_label").html("<?php echo bdt(); ?>" + sub_total.toFixed(11));
        $("#earlier_sub_total").val(sub_total);
        
        var discount = $("#invoice_discount").val();
        
        var totalBill = sub_total - discount;
        
        $("#total_bill_label").html("<?php echo bdt(); ?>" + totalBill.toFixed(11));
        $("#earlier_total_bill").val(totalBill);
        
        var previous_bill = $("#previous_bill").val();
        var early_paid = $("#earlier_paid").val();
        
        if(totalBill > previous_bill){
            alert("Current total can not be greater then previous total");
            return false;
        }
        
        var adjustment = (totalBill - early_paid);
        
        $("#adjustment_label").html("<?php echo bdt(); ?>" + adjustment.toFixed(11));
        $("#adjustment_value").val(adjustment);
        $("#invoice_payment").val(0);
        $("#invoice_payment").attr("max", adjustment);
    }
</script>