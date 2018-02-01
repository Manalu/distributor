<?php

/**
 * Description of queue
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>    
<form action="<?php echo site_url('sales/confirm'); ?>" method="POST" id="sales_confirm">
    <input type="hidden" name="total_item" value="<?php echo $total_item; ?>" />
    <input type="hidden" name="branch_id" value="<?php echo $b_id; ?>" />
    <input type="hidden" name="client_id" value="<?php echo $info->cl_id; ?>" />
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
                                            <span>Invoice No.: <?php //echo $info->id;?></span>
                                            <span>Generated On<?php //echo $info->date . ', ' . $info->time; ?></span>
                                            <?php //if($info->status == 2) { ?> <span><?php //echo 'Recieved On: ' . $info->rcvd . ', ' . $info->rcvt; ?></span> <?php //} ?>
                                            <span style="color: red; font-style: bold;">
                                                <abbr title="Order Status">Status :</abbr>
                                                <?php
                                                /* switch ($info->status){
                                                    case 1:{ echo 'Placed'; break; }
                                                    case 2:{ echo 'Received'; break; }
                                                    case 3:{ echo 'Cancelled'; break; }
                                                } */
                                                ?>
                                            </span>
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
                                    <th style="width: 5%;text-align:center; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;">SL</th>
                                    <th style="width: 20%; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;">Product</th>
                                    <th style="width: 10%; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;">Company</th>
                                    <th style="width: 10%; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;">Group</th>
                                    <th style="width: 10%; text-align: center;">Cartoon</th>
                                    <th style="width: 10%; text-align: center;">Piece</th>
                                    <th style="width: 10%; text-align: center;">Bonus</th>
                                    <th style="width: 12%; text-align:center;">Total</th>
                                    <th style="width: 13%; text-align: right;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($items != FALSE) { $i = 1; $sub_total = 0; foreach ($items->result() as $item) {?>
                                <tr>
                                    <td style="text-align:center;">
                                        <input type="hidden" name="tble_id[]" value="<?php echo $item->tble_id; ?>" />
                                        <input type="hidden" name="company_id[]" value="<?php echo $item->company_id; ?>" />
                                        <input type="hidden" name="product_id[]" value="<?php echo $item->product_id; ?>" />
                                        <input type="hidden" name="group_id[]" value="<?php echo $item->group_id; ?>" />
                                        <input type="hidden" name="cartoon[]" value="<?php echo $item->cartoon; ?>" />
                                        <input type="hidden" name="piece[]" value="<?php echo $item->piece; ?>" />
                                        <input type="hidden" name="bonus[]" value="<?php echo $item->bonus; ?>" />
                                        <input type="hidden" name="quantity[]" value="<?php echo $item->quantity; ?>" />
                                        <input type="hidden" name="u_rate[]" value="<?php echo $item->u_rate; ?>" />
                                        <input type="hidden" name="price[]" value="<?php echo $item->price; ?>" />
                                        <?php echo $i;?>
                                    </td>
                                    <td style=""><?php echo $item->p_name; ?></td>
                                    <td style=""><?php echo $item->c_name; ?></td>
                                    <td style=""><?php echo $item->mg_name; ?></td>                          
                                    <td style="text-align:center;">
                                        <?php echo $item->cartoon; ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo $item->piece; ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo $item->bonus; ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo $item->quantity; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php $sub_total = $sub_total + $item->price; ?>
                                        <?php echo bdt() . number_format($item->price, 2, ".", ",");?>
                                    </td>
                                </tr>
                            <?php  $i++; } }  ?>
                                <tr>
                                    <td colspan="7" style="text-align: right;">
                                        <input type="hidden" name="sub_total" id="sub_total" value="<?php echo $sub_total; ?>" />
                                        Total
                                    </td>
                                    <td style="text-align: right;" colspan="2">
                                        <?php echo bdt() . number_format($sub_total, 2, ".", ","); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" style="text-align: right;">
                                        Discount
                                    </td>
                                    <td style="text-align: right;" colspan="2">
                                        <input type="number" name="discount" id="discount" class="span12" style="text-align: right;" step="any" value="0" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" style="text-align: right;">
                                        <input type="hidden" name="total_bill" id="total_bill" />
                                        Total
                                    </td>
                                    <td style="text-align: right;" id="total_bill_label" colspan="2">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" style="text-align: right;">
                                        Payment
                                    </td>
                                    <td style="text-align: right;" colspan="2">
                                        <input type="number" name="payment" id="payment" class="span12" style="text-align: right;" min="0" step="any" value="0" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" style="text-align: right;">
                                        Method
                                    </td>
                                    <td colspan="2">
                                        <input type="text" name="inv_route" id="inv_route" class="span12" style="text-align: right;" placeholder="ইন্ভয়েছ রুট" />
<!--                                        <select name="method" id="method" required="required" class="span12">
                                            <option value="">Select Payment Method</option>
                                            <?php // if($method != FALSE) { foreach($method->result() as $method) {    ?>
                                            <option value="<?php echo $method->tble_id; ?>">
                                                <?php // echo $method->method; ?>
                                            </option>
                                            <?php // } } ?>
                                        </select>-->
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7"></td>
                                    <td colspan="2" style="text-align: right;">
                                        <input type="hidden" id="method" name="method" value="2" />
                                        <input type="hidden" name="trigger" value="confirm" />
                                        <a href="<?php echo site_url('sales/cancel'); ?>" class="btn btn-danger">Cancel Invoice</a>
                                        <input type="submit" class="btn btn-primary" value="Create invoice" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                    <?php include 'application/views/common/marketing.php'; ?>
                </div>
                <?php //include 'application/views/common/printer.php'; ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('mousewheel.disableScroll', function (e) {
          e.preventDefault();
        });
    });
    $('form').on('blur', 'input[type=number]', function (e) {
      $(this).off('mousewheel.disableScroll');
    });
    $("#discount").keyup(function(){
        var sub_total   = $("#sub_total").val();
        var discount    = $("#discount").val();
        var totalbil    = (sub_total - discount);
        $("#total_bill").val(totalbil);
        $("#total_bill_label").html('<?php echo bdt(); ?>' + Math.round(totalbil).toFixed(2));
        $("#payment").attr("max", (sub_total - discount));
    });
    
    $("#sales_confirm").submit(function(){
        var sub_total = parseFloat($("#sub_total").val());
        var discount  = parseFloat($("#discount").val());
        var paid_amnt = parseFloat($("#payment").val());
        if(paid_amnt > (sub_total - discount)){
            alert("Paid amount can not be greater then Sub Total");
            $("#payment").focus();
            $("#payment").attr("max", (sub_total - discount));
            return false;
        }
    });
</script>