<?php

/**
 * Description of damage
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
                    <?php widgetHeader(); ?> Return Batch Details
                </div>
            </div>
            <div id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <div class="widget-body">
                    <h5>Batch NO: <?php echo $return_info->batch_no; ?>. <br />Supplier: <?php echo get_supplier_name_by_supplier_id($return_info->supplier_id); ?></h5>
                    <p>Status: 
                        <?php if($return_info->status == 1) { ?>
                        <label class="label label-info">Stored</label>
                        <?php } else if($return_info->status == 2) { ?>
                        <label class="label label-success">Submitted</label>
                        <?php } else if($return_info->status == 3) { ?>
                        <label class="label label-warning">Adjusted</label>
                        <?php } ?>
                    <br />
                    <?php if($return_info->status == 1) { ?>
                        Stored : <?php echo date_format(date_create($return_info->store_date), "d-M-Y"); ?>
                    <?php } else if($return_info->status == 2) { ?>
                        Submitted : <?php echo date_format(date_create($return_info->submission_date), "d-M-Y"); ?>
                    <?php } else if($return_info->status == 3) { ?>
                        Received : <?php echo date_format(date_create($return_info->received_date), "d-M-Y"); ?>
                    <?php } ?>
                    </p>
                </div>
                <div class="widget-body">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">SL.</th>
                                <th style="width: 20%;">Product</th>
                                <th style="text-align: center; width: 10%;">Cartoon</th>
                                <th style="text-align: center; width: 10%;">Quantity</th>
                                <th style="text-align: right; width: 15%;">Value</th>
                                <th style="text-align: center; width: 10%;">Receive</th>
                                <th style="text-align: center; width: 10%;">Remove</th>
                                <th style="text-align: center; width: 10%;">Adjust</th>
                                <th style="text-align: center; width: 10%;">Added</th>
                            </tr>
                        </thead>
                        <tbody id="damage_item_list">
                            <?php if($return_itms != FALSE) { $sl = 1; foreach($return_itms->result() as $items){   ?>
                            <tr>
                                <td style="text-align: center;">
                                    <?php echo $sl; ?>
                                </td>
                                <td>
                                    <?php echo $items->Product; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $items->Cartoon; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $items->quantity; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php //echo bdt(). number_format(($items->quantity * $items->Purchase), 2, ".", ","); ?>
                                    <?php echo bdt(). number_format(($items->quantity * $items->StockPrice), 2, ".", ","); ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if($items->received == 1) { ?>
                                    <button onclick="update_stock_receive('<?php echo $items->tble_id ?>',
                                                            '<?php echo $items->p_id; ?>',
                                                            '<?php echo $items->Central + $items->quantity; ?>',
                                                            '<?php echo $return_info->tble_id; ?>')" class="btn btn-success btn-mini">
                                        Receive
                                    </button>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if($items->received == 1) { ?>
                                    <i class="icon-trash"></i>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if($items->received == 1) { ?>
                                    <button class="btn btn-warning btn-mini">Adjust</button>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if($items->added != NULL) { 
                                        echo date_format(date_create($items->added), "d-M-Y");
                                    } ?>
                                </td>
                            </tr>
                            <?php $sl++; } } ?>
                        </tbody>
                    </table>
                </div>
                <?php include 'application/views/common/marketing.php'; ?>
            </div>
            <?php include 'application/views/common/printer.php'; ?>
            <div class="widget-body center-align-text">
                <?php if($return_info->status == 1 && $return_info->branch_id == $b_id) { ?>
                <a class="btn btn-primary" href="<?php echo site_url('order/batchstatus?func=status_update&cat=stock&mod=admin&sess_auth=' . md5(date('Y-m-d')) . '&remote=' . md5($memb) . '&batch=' . $return_info->tble_id . '&status=2'); ?>" onclick="return confirm('Are you sure this is submitted?')">Mark as Submitted</a>    
                <a class="btn btn-danger" href="<?php echo site_url('order/dltrtnbtch?func=delete&cat=stock&mod=admin&sess_auth=' . md5(date('Y-m-d')) . '&remote=' . md5($memb) . '&batch=' . $return_info->tble_id); ?>" onclick="return confirm('আপনি কি নিশ্চিত?')">Delete Entire Batch</a>
                <?php } else if($return_info->status == 2 && $return_info->branch_id == $b_id) { ?>
                <a class="btn btn-success" href="<?php echo site_url('order/batchstatus?func=status_update&cat=stock&mod=admin&sess_auth=' . md5(date('Y-m-d')) . '&remote=' . md5($memb) . '&batch=' . $return_info->tble_id . '&status=3'); ?>" onclick="return confirm('Are you sure this is adjusted?')">Mark as Adjusted</a>    
                <a class="btn btn-danger" href="<?php echo site_url('order/dltrtnbtch?func=delete&cat=stock&mod=admin&sess_auth=' . md5(date('Y-m-d')) . '&remote=' . md5($memb) . '&batch=' . $return_info->tble_id); ?>" onclick="return confirm('আপনি কি নিশ্চিত?')">Delete Entire Batch</a>    
                <?php } ?>
                <a href="<?php echo site_url('order/batchlist'); ?>" class="btn btn-default">Back to List</a>
            </div>
        </div>
    </div>
</div>
<script>
    function update_stock_receive(tble_id, product, stock, damage){
        var r = confirm('Are you sure you want to add this product into stock?')
        if(r){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('order/add_return_item_to_stock'); ?>",
                data: { table: tble_id, product: product, stock: stock, return: damage },
                cache: false,
                beforeSend: function(){
                    $('#damage_item_list').html(
                    '<tr><td colspan="7" class="center-align-text"><img src="<?php echo base_url(); ?>/img/ajaxloader.gif" style="" /></td></tr>'
                    );
                },
                success: function(html){
                    $("#damage_item_list").html(html);
                } 
           });
        } else {
            return false;
        }
    }
</script>
<script language="JavaScript">
$('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }
    else{
        $(':checkbox').each(function() {
            this.checked = false;                        
        });
    }
});
</script>