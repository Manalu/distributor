    
    
    
<div class="row-fluid">
    <div class="span12">
        <div class="widget no-margin">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Order Details (Detailed order information)
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
                                        <span><abbr title="Phone">Memo :</abbr> <?php echo $info->or_comp_memo; ?></span>
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
                                        <span><?php echo $info->or_notes; ?></span>
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
                                <th style="width: 20%;">Product</th>
                                <th style="width: 10%;">Type</th>
                                <th style="width: 10%; text-align: center;">Cartoon</th>
                                <th style="width: 10%; text-align: center;">Piece</th>
                                <?php if($info->status == 2) { ?>
                                <th style="text-align: center; ">
                                    Bonus
                                </th>
                                <?php } ?>
                                <th style="width: 12%; text-align:center;">Quantity</th>
                                <th style="width: 23%; text-align: right;">
                                    Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $rcv_counter = 0; $i=1; foreach ($items as $item) {?>
                            <tr>
                                <td style="text-align:center;"><?php echo $i++;?></td>
                                <td style="">
                                    <?php echo $item->name;?>
                                    &nbsp; &nbsp;
                                    <?php if($item->Received == 1) { $rcv_counter++ ?> 
                                    <i class="icon-ok-circle"></i>
                                    <?php } ?>
                                </td>
                                <td style=""><?php echo $item->type;?></td>
                                <td style="text-align: center;">
                                    <?php echo $item->cartoon . '/' . get_order_received_stock_cartoon($info->id, $item->p_id);?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $item->piece . '/' . get_order_received_stock_piece($info->id, $item->p_id); ?>
                                </td>
                                <?php if($info->status == 2) { ?>
                                <td style="text-align: center;">
                                    <?php echo $item->bonus . '/' . get_order_received_stock_bonus($info->id, $item->p_id); ?>
                                </td>
                                <?php } ?>
                                <td style="text-align:center;">
                                    <?php echo $item->qty . '/' . get_order_received_stock_quantity($info->id, $item->p_id);?>
                                </td>
                                <td style="text-align: right;">
                                    <?php echo bdt() . $item->t_rate; ?>
                                </td>
                            </tr>
                        <?php  } ?>
                        <?php if($info->status == 2) { 
                        ?>
                            <tr>
                                <td colspan="6" style="text-align: right;">Sub - Total </td>
                                <td style="text-align: right;" colspan="3"><?php echo bdt() . $info->net; ?></td>
                            </tr>
                            <tr>
                                <td colspan="6" style="text-align: right;">Discount </td>
                                <td style="text-align: right;" colspan="3"><?php echo bdt() . $info->dis; ?></td>
                            </tr>
                            <tr>
                                <td colspan="6" style="text-align: right;">Total</td>
                                <td style="text-align: right;" colspan="3"><?php echo bdt() . $info->total; ?></td>
                            </tr>
                            <tr>
                                <td colspan="6" style="text-align: right;">Paid Amount</td>
                                <td style="text-align: right;" colspan="3"><?php echo bdt() . $info->paid; ?></td>
                            </tr>
                            <tr>
                                <td colspan="6" style="text-align: right;">Current Due</td>
                                <?php $remaining = ($info->total - $info->paid); ?>
                                <td style="text-align: right;" colspan="3"><?php echo bdt() . $remaining; ?></td>
                            </tr>
                            <?php } ?>
                            <tr class="hidden-phone noprint">
                                <td class="center-align-text hidden-phone noprint" colspan="9">
                                    <div id="button_bar" class="hidden-phone noprint">
                                        <?php if($info->or_pending == 0){ ?>
                                            <a href="<?php echo site_url('order/pending?sess_auth=' . md5(date('Ymshis')) . '&func=pending&route=order&current=0&pending=' . $info->id )?>" class="btn btn-small btn-warning2" id="btn_receive">Mark As Pending</a>
                                        <?php } ?>
                                        <?php if($info->or_pending == 1){ ?>
                                            <a href="<?php echo site_url('order/pending?sess_auth=' . md5(date('Ymshis')) . '&func=pending&route=order&current=1&pending=' . $info->id )?>" class="btn btn-small btn-warning" id="btn_receive">Mark As Complete</a>
                                        <?php } ?>
                                    <?php switch ($info->status){
                                        case 1:{ ?>
                                        <a href="<?php echo site_url('order/receive/' . $info->id )?>" class="btn btn-small btn-success" id="btn_receive">Receive</a>
                                        <a href="<?php echo site_url('order/delete?order=' . $info->id . '&company=' . $info->cid)?>" class="btn btn-small btn-danger" id="btn_cancel" onclick="return confirm('Are you sure you want to cancel the order? This cant be undone.')">Cancel</a>
                                        <?php
                                            break;
                                        }
                                        case 2:{    //Order is received and checking if thre is any outstanding for this order or any pending item.. ?>
                                        <?php if($rcv_counter > 0) { ?>
                                        <a href="<?php echo site_url('order/receive/' . $info->id )?>" class="btn btn-small btn-success" id="btn_receive">Receive</a>
                                        <?php } ?>
                                        <?php if($remaining > 0) { ?>
                                        <!--<button type="button" class="btn btn-small btn-success" data-toggle="modal" id="datamodal" data-target="#myModal">Make Payment</button>-->
                                        <?php }
                                            break;
                                        }
                                        case 3:{ ?>
                                        <?php
                                            break;
                                        }
                                        ?>
                                    <?php } ?>
                                    </div>
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
                <a href="<?php echo site_url('order/orderlist'); ?>" class="btn btn-default" data-original-title="">Back to List</a>
            </div>
        </div>
    </div>
</div>
<!--  </div>
</div>-->
    
<?php if($info->status == 2) { ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo site_url('order/payment'); ?>" method="POST" class="form-horizontal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Order Payment</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <label class="control-label">Amount</label>
                        <div class="controls controls-row">
                            <input class="span3" type="number" name="op_amount" placeholder="Amount to be paid" id="op_amount" autofocus="on" min="1" max="<?php echo $remaining; ?>" value="<?php echo $remaining; ?>" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="op_orid" value="<?php echo $info->id; ?>" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Make Payments</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php } ?>
<script type="text/javascript">
    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('mousewheel.disableScroll', function (e) {
          e.preventDefault();
        });
    });
    $('form').on('blur', 'input[type=number]', function (e) {
      $(this).off('mousewheel.disableScroll');
    });
</script>
    
    
