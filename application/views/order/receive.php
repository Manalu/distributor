



<div class="row-fluid">
    <div class="span12" id="formsubmit">
        <div class="widget no-margin">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe025;"></span> Order Receive (Receive items according to orders)
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
            </div>
            <div class="widget-body">
                <form class="form-horizontal no-margin" action="<?php echo site_url('order/receive/' . $disorid);?>" method="post" id="receiveForm">
                    <table class="table table-striped table-condensed table-bordered no-margin">
                        <thead>
                            <tr>
                                <th class="center-align-text" style="width: 5%;">SL</th>
                                <th class="center-align-text" style="width: 5%;">RCVD</th>
                                <th style="width: 15%;">Product</th>
                                <th class="center-align-text" style="width: 9%;">Stock</th>
                                <th class="center-align-text" style="width: 5%;">Box</th>
                                <th class="center-align-text" style="width: 5%;">Order</th>
                                <th class="center-align-text" style="width: 5%;">Received</th>
                                <th class="center-align-text" style="width: 6%;">Cartoon</th>
                                <th class="center-align-text" style="width: 6%;">Piece</th>
                                <th class="center-align-text" style="width: 9%;">Bonus</th>
                                <th class="center-align-text" style="width: 10%;">Total</th>
                                <th style="width: 10%; text-align: center;">Rate</th>
                                <th style="width: 10%; text-align: right;">Price</th>
                            </tr>
                        </thead>
                        <tbody id ="prodtable">
                        <?php $i=1; $tab = 1; foreach ($items as $item) { ?>
                            <tr>
                                <td class="center-align-text">
                                    <input type="hidden" name="itid[]" value="<?php echo $item->id;?>">
                                    <input type="hidden" name="oi_comp_id[]" value="<?php echo $item->oi_comp_id;?>">
                                    <input type="hidden" name="oi_pid[]" value="<?php echo $item->p_id;?>">
                                    <?php echo $i++;?>
                                </td>
                                <td style="width: 5%; text-align: center;">
                                    <input type="checkbox" name="received_status[]" value="<?php echo $item->id;?>" />
                                </td>
                                <td>
                                    <?php echo $item->name;?>
                                </td>
                                <td class="center-align-text">
                                    <?php
                                    if($item->stok == NULL){
                                        echo 0;
                                    } else {
                                        $box = get_number_of_boxes($item->stok, $item->bxqty);
                                        $rem = get_number_of_remainder($item->stok, $item->bxqty);
                                        echo $box . '/' . $rem . '/' . $item->p_box_bonus;
                                    } ?>
                                </td>
                                <td class="center-align-text">
                                    <?php echo $item->bxqty; ?>
                                </td>
                                <td class="center-align-text">
                                    <?php
//                                    if($item->stok == NULL){
//                                        echo 0;
//                                    } else {
//                                        $box = get_number_of_boxes($item->stok, $item->bxqty);
//                                        $rem = get_number_of_remainder($item->stok, $item->bxqty);
                                        echo $item->cartoon . '/' . $item->piece;
//                                    } ?>
                                </td>
                                <td class="center-align-text">
                                    <?php
                                    $cartoon = get_order_received_stock_cartoon($disorid, $item->p_id);
                                    $piece = get_order_received_stock_piece($disorid, $item->p_id);
                                    $bonus = get_order_received_stock_bonus($disorid, $item->p_id);
                                    $quantity = get_order_received_stock_quantity($disorid, $item->p_id);
                                    ?>
                                    <?php echo $cartoon . '/' . $piece . '/' . $bonus; ?>
                                </td>
                                <td class="center-align-text vertical-align-mid">
                                    <input type="hidden" name="cart_price[]" id="<?php echo 'cart_price_' . $item->p_id; ?>" value="<?php echo $item->t_rate; ?>" class="sum" />
                                    <input type="hidden" name="oi_qty[]" id="<?php echo 'cart_qty_' . $item->p_id; ?>" value="<?php echo $item->qty; ?>" />
                                    <input id="<?php echo 'cart_box_' . $item->p_id; ?>"
                                    onkeyup="calculate_cartoon_piece('<?php echo $item->bxqty; ?>', '<?php echo $item->p_id; ?>', '<?php echo $item->p_box_bonus; ?>'), calculate_cart_item_price('<?php echo $item->purchse; ?>', '<?php echo $item->p_id; ?>')"
                                    value="<?php echo 0;//$item->cartoon; ?>" type="number" class="span12" name="cartoon[]" style="text-align: center;" tabindex="<?php echo $tab; ?>" />
                                    <?php $tab++; ?>
                                </td>
                                <td class="center-align-text vertical-align-mid">
                                    <input name="piece[]" onkeyup="calculate_cartoon_piece('<?php echo $item->bxqty; ?>', '<?php echo $item->p_id; ?>', '<?php echo $item->p_box_bonus; ?>'), calculate_cart_item_price('<?php echo $item->purchse; ?>', '<?php echo $item->p_id; ?>')"
                                           value="<?php echo 0; //$item->piece; ?>" id="<?php echo 'cart_pcs_' . $item->p_id; ?>" type="number" class="span12" style="text-align: center;" tabindex="<?php echo $tab; ?>" />
                                    <?php $tab++; ?>
                                </td>
                                <td class="center-align-text vertical-align-mid">
                                    <input onkeyup="calculate_bonus_piece('<?php echo $item->bxqty; ?>', '<?php echo $item->p_id; ?>')"
                                           id="<?php echo 'cart_bns_' . $item->p_id; ?>" value="<?php echo 0; //$item->cartoon * $item->p_box_bonus; ?>"
                                           type="number" class="span12" name="bonus[]" tabindex="<?php echo $tab; ?>" style="text-align: center;" />
                                    <?php $tab++; ?>
                                </td>
                                <td class="center-align-text vertical-align-mid" id="<?php echo 'total_quantity_' . $item->p_id; ?>">
                                    <?php echo $item->qty; ?>
                                </td>
                                <td class="center-align-text vertical-align-mid">
                                    <input onfocus="get_focus_out('<?php echo $item->p_id; ?>')" value="<?php echo $item->purchse; ?>" onkeyup="calculate_cartoon_piece('<?php echo $item->bxqty; ?>', '<?php echo $item->p_id; ?>')" id="<?php echo 'cart_prc_' . $item->p_id; ?>" class="span12" name="u_rate[]" style="text-align: center;" type="text" />
                                </td>
                                <td style="text-align: right;" id="<?php echo 'price_label_' . $item->p_id; ?>" class="vertical-align-mid">
                                    <?php echo bdt() . $item->t_rate; ?>
                                </td>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11" style="text-align: right;">
                                    Sub-Total
                                </td>
                                <td colspan="2">
                                    <input value="<?php echo $info->net; ?>" type="number" name="or_sub_total" id="or_sub_total" readonly class="span12" onfocus="total_price()()" style="text-align: right;" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" style="text-align: right;">
                                    Discount
                                </td>
                                <td colspan="2">
                                    <input onkeyup="total_price()" value="<?php echo $info->dis; ?>" tabindex="<?php echo $tab; ?>" step="any" type="number" name="or_discount" id="or_discount" min="0" class="span12" style="text-align: right;" />
                                    <?php $tab++; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" style="text-align: right;">
                                    Total
                                </td>
                                <td colspan="2">
                                    <input onfocus="total_price()" value="<?php echo $info->total; ?>" type="number" name="or_total" id="or_total" min="0" class="span12" readonly style="text-align: right;" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10" style="text-align: right;">
                                    Date
                                </td>
                                <td colspan="3">
                                    <input type="text" name="or_rcv_date" id="or_rcv_date" class="span12" readonly tabindex="<?php echo $tab; ?>" required="required" />
                                    <?php $tab++; ?>
                                    <script>
                                        $(function() {
                                            $("#or_rcv_date").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, startDate: '<?php echo $info->date; ?>'});
                                        });
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10" style="text-align: right;">
                                    Company Memo
                                </td>
                                <td colspan="3">
                                    <input tabindex="<?php echo $tab; ?>" type="text" name="or_comp_memo" id="or_comp_memo" class="span12" />
                                <?php $tab++; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10" style="text-align: right;">
                                    Notes
                                </td>
                                <td colspan="3">
                                    <input tabindex="<?php echo $tab; ?>" type="text" name="or_notes" id="or_notes" class="span12" />
                                <?php $tab++; ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="trigger" value="order_receive" />
                        <input type="hidden" name="orid" value="<?php echo $disorid; ?>" />
                        <input type="hidden" name="status" value="<?php echo $info->or_status; ?>" />
                        <input type="hidden" name="op_or_company" value="<?php echo $info->cid; ?>" />
                        <button type="submit" class="btn btn-primary pull-right"> Receive Order & Update Stock</button>
                        <a class="btn btn-default pull-right" href="<?php echo site_url('order/details/' . $disorid);?>"> Return</a>
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
        var itemprice   = (unitprce * (quantity - bonusq));
        $("#price_label_" + proid).html("<?php echo bdt(); ?> " + itemprice.toFixed(11));
        $("#cart_price_" + proid).val(itemprice);
        total_price();
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
        $("#price_label_" + proid).html("<?php echo bdt(); ?> " + itemprice);
        $("#cart_price_" + proid).val(itemprice);
        total_price();
    }
    
    function total_price(){
        var sub_total = 0;
        $('.sum').each(function (index, element) {
            sub_total = sub_total + parseFloat($(element).val());
        });
        
        $("#or_sub_total").val(sub_total);
        $("#or_discount").attr("max", sub_total);
        $("#op_amount").attr("max", sub_total);
        $("#op_amount").attr("min", sub_total);
        var discount = $("#or_discount").val();
        var total = sub_total - discount;
        
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