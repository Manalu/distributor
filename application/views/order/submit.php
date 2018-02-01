


<div class="row-fluid">
    <div class="span12">
        <div class="widget no-margin">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Order Place - Please provide the quantity for each item
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <script type="text/javascript">
                    $(document).ready(function(){
                        $(".invoice").css('display', 'none');
                    });
                </script>
                <div class="invoice">
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="invoice-data-container">
                                <address class="no-margin">
                                    <b><?php echo $ShopName; ?></b>
                                    <span><?php echo $ShopAdrs; ?>,</span>
                                    <span><abbr title="Phone">Phone :</abbr> <?php echo $ShopPhone; ?>,</span>
                                </address>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="invoice-data-container">
                                <address class="no-margin">
                                    <b><?php echo $info->contact; ?></b>
                                    <span><b><?php echo $info->company;?></b></span>
                                    <span><abbr title="Phone">Phone :</abbr> <?php echo $info->c_phone;?></span>
                                    <span><abbr title="Phone">Mobile :</abbr> <?php echo $info->c_mobile; ?></span>
                                </address>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="invoice-data-container">
                                <address class="no-margin">
                                    <b>Details</b>
                                    <span>Order No.: <?php echo $info->id;?></span>
                                    <span><?php echo 'Placed On: ' . $info->date . ', ' . $info->time; ?></span>
                                    <?php if($info->status == 2) { ?> <span><?php echo 'Recieved On: ' . $info->rcvd . ', ' . $info->rcvt; ?></span> <?php } ?>
                                    <span style="color: red; font-style: bold;">
                                        <abbr title="Order Status">Status :</abbr>
                                        <?php switch ($info->status){
                                            case 1:{ echo 'Placed'; break; }
                                            case 2:{ echo 'Received'; break; }
                                            case 3:{ echo 'Cancelled'; break; }
                                        } ?>
                                    </span>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="form-horizontal no-margin" action="<?php echo site_url('order/finalize');?>" onsubmit="return check()" method="post">
                    <table class="table table-striped table-condensed table-bordered no-margin">
                        <thead>
                            <tr>
                                <th class="center-align-text" style="width: 5%;">SL</th>
                                <th style="width: 15%;">Product</th>
                                <!--<th style="width: 15%;">Type</th>-->
                                <th class="center-align-text" style="width: 10%;">Stock</th>
                                <th class="center-align-text" style="width: 10%;">Box</th>
                                <th class="center-align-text" style="width: 10%;">Cartoon</th>
                                <th class="center-align-text" style="width: 10%;">Piece</th>
                                <th class="center-align-text" style="width: 10%;">Total</th>
                                <th style="width: 10%; text-align: center;">Rate</th>
                                <th style="width: 10%; text-align: right;">Price</th>
                            </tr>
                        </thead>
                        <tbody id ="prodtable">
                        <?php $i=1; $tab = 1; foreach ($items as $item) { ?>
                            <tr>
                                <td class="center-align-text">
                                    <?php echo $i++;?>
                                </td>
                                <td>
                                    <input type="hidden" name="itid[]" value="<?php echo $item->id;?>">
                                    <?php echo $item->name;?>
                                </td>
<!--                                <td>
                                    <?php // echo $item->type;?>
                                </td>-->
                                <td class="center-align-text">
                                    <?php
                                    if($item->stok == NULL){
                                        echo 0;
                                    } else {
                                        $box = get_number_of_boxes($item->stok, $item->bxqty);
                                        $rem = get_number_of_remainder($item->stok, $item->bxqty);
                                        echo $box . '/' . $rem;
                                    } ?>
                                </td>
                                <td class="center-align-text">
                                    <?php echo $item->bxqty; ?>
                                </td>
                                <td class="center-align-text vertical-align-mid">
                                    <input type="hidden" name="cart_price[]" id="<?php echo 'cart_price_' . $item->p_id; ?>" value="0" class="sum" />
                                    <input type="hidden" name="quantity[]" id="<?php echo 'cart_qty_' . $item->p_id; ?>" />
                                    <input id="<?php echo 'cart_box_' . $item->p_id; ?>"
                                    onkeyup="calculate_cartoon_piece_order_submit('<?php echo $item->bxqty; ?>', '<?php echo $item->p_id; ?>'), calculate_cart_item_price('<?php echo $item->purchse; ?>', '<?php echo $item->p_id; ?>')"
                                    type="number" class="span12" name="cartoon[]" style="text-align: center;" value="0" tabindex="<?php echo $tab; ?>" />
                                    <?php $tab++; ?>
                                </td>
                                <td class="center-align-text vertical-align-mid">
                                    <input name="piece[]" onkeyup="calculate_cartoon_piece_order_submit('<?php echo $item->bxqty; ?>', '<?php echo $item->p_id; ?>'), calculate_cart_item_price('<?php echo $item->purchse; ?>', '<?php echo $item->p_id; ?>')" max="<?php echo ($item->bxqty - 1); ?>" id="<?php echo 'cart_pcs_' . $item->p_id; ?>" type="number" class="span12" style="text-align: center;" value="0" tabindex="<?php echo $tab; ?>" />
                                </td>
                                <td class="center-align-text vertical-align-mid" id="<?php echo 'total_quantity_' . $item->p_id; ?>">

                                </td>
                                <td class="center-align-text vertical-align-mid">
                                    <input onfocus="get_focus_out('<?php echo $item->p_id; ?>')" value="<?php echo $item->purchse; ?>" onkeyup="calculate_cartoon_piece('<?php echo $item->bxqty; ?>', '<?php echo $item->p_id; ?>')" id="<?php echo 'cart_prc_' . $item->p_id; ?>" class="span12 nooutline" name="u_rate[]" style="text-align: center;" type="text" />
                                </td>
                                <td style="text-align: right;" id="<?php echo 'price_label_' . $item->p_id; ?>" class="vertical-align-mid">
                                    <?php echo bdt() . number_format(0, 2); ?>
                                </td>
                        <?php $tab++;  } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" style="text-align: right;">
                                    Sub-Total
                                </td>
                                <td style="text-align: right;" colspan="2">
                                    <input type="number" tabindex="<?php echo $tab; ?>" name="or_sub_total" id="or_sub_total" readonly style="text-align: right;" class="span12" onfocus="total_price()" value="0" step="0.003921568633" />
                                    <?php $tab++; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: right;">
                                    Discount
                                </td>
                                <td style="text-align: right;" colspan="2">
                                    <input onkeyup="total_price()" type="number" name="or_discount" id="or_discount" min="0" class="span12" value="0" step="any" tabindex="<?php echo $tab; ?>" style="text-align: right;" />
                                <?php $tab++; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: right;">
                                    Total
                                </td>
                                <td style="text-align: right;" colspan="2">
                                    <input type="number" name="or_total" id="or_total" min="0" class="span12" readonly onfocus="total_price()" tabindex="<?php echo $tab; ?>" value="0" style="text-align: right;" />
                                <?php $tab++; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right; color: green;" colspan="5">
                                    Balance
                                </td>
                                <td style="text-align: right; color: green;">
                                    <?php echo bdt() . number_format($info->balance, 2, ".", ","); ?>
                                </td>
                                <td colspan="1" style="text-align: right;">
                                    Adjustment
                                </td>
                                <td style="text-align: right;" colspan="2">
                                    <input type="number" name="op_amount" id="op_amount" min="0" value="0" class="span12" tabindex="<?php echo $tab; ?>" style="text-align: right;" step="any" />
                                <?php $tab++; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: right;">
                                    Date
                                </td>
                                <td colspan="2">
                                    <input type="text" name="or_date" id="or_date" class="span12" readonly />
                                    <script>
                                        $(function() {
                                            $("#or_date").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date('Y-m-d'); ?>'});
                                        });
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: right;">
                                    Company Memo
                                </td>
                                <td colspan="2">
                                    <input tabindex="<?php echo $tab; ?>" type="text" name="or_comp_memo" id="or_comp_memo" class="span12" />
                                <?php $tab++; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: right;">
                                    Notes
                                </td>
                                <td colspan="2">
                                    <input tabindex="<?php echo $tab; ?>" type="text" name="or_notes" id="or_notes" class="span12" />
                                <?php $tab++; ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="balance" value="<?php echo $info->balance; ?>" />
                        <input type="hidden" name="op_or_company" value="<?php echo $info->cid; ?>" />
                        <input type="hidden" value="<?php echo $info->id; ?>" name="orid" />
                        <button type="submit" class="btn btn-primary pull-right"> Place Order</button>
                        <a class="btn btn-danger pull-right" tabindex="<?php echo $tab; ?>" href="<?php echo site_url('order/delete/' . $disorid);?>" onclick="return confirm('Are you sure you want to cancel placing this order?')"> Cancel Placing</a>
                        <?php $tab++; ?>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function get_focus_out(proid){
        $("#cart_prc_" + proid).blur();
    }
    function calculate_cartoon_piece_order_submit(boxqty, proid){
        var cartoon     = parseInt($("#cart_box_" + proid).val());
        var pieceq      = parseInt($("#cart_pcs_" + proid).val());
        //var bonusq      = parseInt($("#cart_bns_" + proid).val());
        if(isNaN(cartoon)){ cartoon = 0; }
        if(isNaN(pieceq)){ pieceq = 0; }
        //if(isNaN(bonusq)){ bonusq = 0; }
        var totalqty    = (cartoon * boxqty) + pieceq;// + bonusq;
        $("#total_quantity_" + proid).html(totalqty);
        $("#cart_qty_" + proid).val(totalqty);
        
        var quantity    = $("#cart_qty_" + proid).val();
        var unitprce    = $("#cart_prc_" + proid).val();
        var itemprice   = (unitprce * quantity);
        $("#price_label_" + proid).html("<?php echo bdt(); ?> " + itemprice.toFixed(11));
        $("#cart_price_" + proid).val(itemprice.toFixed(11));
        total_price();
    }
    
    function total_price(){
        var sub_total = 0;
        $('.sum').each(function (index, element) {
            sub_total = sub_total + parseFloat($(element).val());
        });
        
        sub_total = parseFloat(sub_total);
        
        $("#or_sub_total").val(sub_total);
        $("#or_discount").attr("max", sub_total);
        
        var discount = $("#or_discount").val();
        discount = parseFloat(discount);
        var total = sub_total - discount;
        total = parseFloat(total);
        
        $("#op_amount").attr("max", total);
        $("#op_amount").attr("min", total);
        
        $("#or_total").val(total);
        $("#op_amount").val(total);
    }
</script>
<script>
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('mousewheel.disableScroll', function (e) {
          e.preventDefault();
        });
    });
    $('form').on('blur', 'input[type=number]', function (e) {
      $(this).off('mousewheel.disableScroll');
    });
</script>