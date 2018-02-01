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
<!--<form action="<?php //echo site_url('sales/confirm'); ?>" method="POST">-->
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
                                <div class="span12">
                                    <table class="table table-condensed">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="invoice-data-container">
                                                        <address class="no-margin">
                                                            <b><?php echo $ShopName; ?></b>
                                                            <span><?php echo $ShopAdrs; ?>,</span>
                                                            <span><abbr title="Phone">Phone :</abbr> <?php echo $ShopPhone; ?>,</span>
                                                            <span>Branch: <?php echo get_branch_name($b_id); ?></span>
                                                        </address>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="invoice-data-container">
                                                        <address class="no-margin">
                                                            <b><?php echo $info->cl_name; ?></b>
                                                            <span><abbr title="Route">Route:</abbr> <?php echo $invoice_info->inv_route; ?></span>
                                                            <span><b><?php echo $info->cl_email;?></b></span>
                                                            <span><abbr title="Phone">Phone :</abbr> <?php echo $info->cl_phone_no;?></span>
                                                            <span><abbr title="Phone">Mobile :</abbr> <?php echo $info->cl_mobile_no; ?></span>
                                                            <!--<span><abbr title="Phone">Memo :</abbr> <?php //echo $info->or_comp_memo; ?></span>-->
                                                        </address>
                                                    </div>
                                                </td>
                                                <td>
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
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
<!--                                <div class="span4">
                                    
                                </div>
                                <div class="span4">
                                    
                                </div>
                                <div class="span4">
                                    
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="widget-body">
                        <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                            <thead>
                                <tr>
                                    <th style="width: 5%;text-align:center;">SL</th>
                                    <th style="width: 15%;">Product</th>
                                    <th style="width: 8%;">Company</th>
                                    <th style="width: 7%;" class="noprint">Group</th>
                                    <th style="width: 10%; text-align: center;">Cartoon</th>
                                    <th style="width: 10%; text-align: center;">Piece</th>
                                    <th style="width: 10%; text-align: center;">Bonus</th>
                                    <th style="width: 10%; text-align:center;">Total</th>
                                    <th style="width: 10%; text-align: center;">Return</th>
                                    <th style="width: 10%; text-align: right;">Rate</th>
                                    <th style="width: 15%; text-align: right;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if($items != FALSE) { $i = 1; $sub_total = 0; foreach ($items->result() as $item) {?>
                                <tr>
                                    <td style="text-align:center;">
                                        <input type="hidden" name="tble_id[]" value="<?php echo $item->tble_id; ?>" />
                                        <input type="hidden" name="company_id[]" value="<?php echo $item->company_id; ?>" />
                                        <input type="hidden" name="product_id[]" value="<?php echo $item->prodid; ?>" />
                                        <input type="hidden" name="group_id[]" value="<?php echo $item->group_id; ?>" />
                                        <input type="hidden" name="cartoon[]" value="<?php echo $item->cartoon; ?>" />
                                        <input type="hidden" name="piece[]" value="<?php echo $item->bonus; ?>" />
                                        <input type="hidden" name="bonus[]" value="<?php echo $item->bonus; ?>" />
                                        <input type="hidden" name="quantity[]" value="<?php echo $item->quantity; ?>" />
                                        <input type="hidden" name="u_rate[]" value="<?php echo $item->u_rate; ?>" />
                                        <input type="hidden" name="price[]" value="<?php echo $item->price; ?>" />
                                        <?php echo $i;?>
                                    </td>
                                    <td style=""><?php echo $item->p_name; ?></td>
                                    <td style=""><?php echo $item->c_name; ?></td>
                                    <td style="" class="noprint"><?php echo $item->mg_name; ?></td>                          
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
                                    <td style="text-align:center;">
                                        <?php echo $item->return_item; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo bdt() . number_format($item->u_rate, 2, ".", ","); ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php $sub_total = $sub_total + $item->price; ?>
                                        <?php echo bdt() . number_format($item->price, 2, ".", ","); ?>
                                    </td>
                                </tr>
                            <?php  $i++; } }  ?>
                                <tr>
                                    <td colspan="8" style="text-align: right;">
                                        <input type="hidden" name="sub_total" id="sub_total" value="<?php echo $sub_total; ?>" />
                                        Sub-Total
                                    </td>
                                    <td style="text-align: right;" colspan="3">
                                        <?php echo bdt() . number_format($invoice_info->sub_total, 2, ".", ","); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align: right;">
                                        Discount
                                    </td>
                                    <td style="text-align: right;" colspan="3">
                                        <?php echo bdt() . number_format($invoice_info->discount, 2, ".", ","); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align: right;">
                                        Total
                                    </td>
                                    <td style="text-align: right;" id="total_bill_label" colspan="3">
                                        <?php echo bdt() . number_format($invoice_info->total_bill, 2, ".", ","); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align: right;">
                                        Payment
                                    </td>
                                    <td style="text-align: right;" colspan="3">
                                        <?php echo bdt() . number_format($invoice_info->Paid, 2, ".", ","); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align: right;">
                                        This Invoice Due
                                    </td>
                                    <td style="text-align: right;" colspan="3">
                                        <?php echo bdt() . number_format($invoice_info->total_bill - $invoice_info->Paid, 2, ".", ","); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align: right;">
                                        Other Invoice Due
                                    </td>
                                    <td style="text-align: right;" colspan="3">
                                        <?php echo bdt() . number_format($balance - ($invoice_info->total_bill - $invoice_info->Paid), 2, ".", ","); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" style="text-align: right;">
                                        Total Due
                                    </td>
                                    <td style="text-align: right;" colspan="3">
                                        <?php echo bdt() . number_format($balance, 2, ".", ","); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                    </div>
                    <?php include 'application/views/common/marketing.php'; ?>
                </div>
                <?php include 'application/views/common/printer.php'; ?>
                <div class="clearfix"></div>
                <div class="widget-body center-align-text">
                    <a href="<?php echo site_url('sales/list'); ?>" class="btn btn-default">Back to List</a>
                </div>
            </div>
        </div>
    </div>
<!--</form>-->