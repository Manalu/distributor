<?php

/*
 * Tarek Showkot|priom2000@gmail.com|tarek@exploriasolution.com|forgotten_tarek@hotmail.comTo change this template, choose Tools | Templates
 * Tarek Showkot|priom2000@gmail.com|tarek@exploriasolution.com|forgotten_tarek@hotmail.comand open the template in the editor.
 */
?>

<div class="row-fluid">
    <form action="<?php echo site_url('accounts/edtvchr');?>" class="form-horizontal no-margin" method="POST">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Income & Expense Voucher Update
                    </div>
                </div>
                <div class="widget-body">
                    <?php notification(); ?>
                    <div class="control-group">
                        <label class="control-label">Type</label>
                        <div class="controls controls-row">
                            <select name="voucher" id="voucher" required="required" class="span12" autofocus="on">
                                <option value="">Select</option>
                                <option value="1" <?php if($voucher->v_type == 1) { echo 'selected'; } ?>>Income</option>
                                <option value="2" <?php if($voucher->v_type == 2) { echo 'selected'; } ?>>Expense</option>
                            </select>
                        </div>
                    </div>
                    <div class="ledger_info">
                        <div class="control-group">
                            <label class="control-label"><?php echo ($v_type == 1) ? 'Income' : 'Expense'; ?> Head</label>
                            <div class="controls controls-row">
                                <select class="span12" name="v_head" id="v_head" required="required">
                                    <option value="">Select</option>
                                    <?php if($purpoz != FALSE) { foreach($purpoz->result() as $purpoz) { ?>
                                    <option value="<?php echo $purpoz->id; ?>" <?php if($voucher->v_head == $purpoz->id) { echo 'selected'; } ?>>
                                        <?php 
                                        echo $purpoz->ledger;
                                        if($purpoz->type == 1) { echo ' (Income)'; }
                                        elseif($purpoz->type == 2) { echo ' (Expense)'; }
                                        ?>
                                    </option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Method</label>
                        <div class="controls controls-row">
                            <select name="method" id="method" required="required" class="span12">
                                <option value="">Select Payment Method</option>
                                <?php if($method != FALSE) { foreach($method->result() as $method) {    ?>
                                <option value="<?php echo $method->tble_id; ?>" <?php if($voucher->method == $method->tble_id) { echo 'selected'; } ?>>
                                    <?php echo $method->method; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Date</label>
                        <div class="controls">
                            <input type="text" name="v_date" id="datepicker" class="span12" value="<?php echo $voucher->v_date; ?>" readonly="readonly" />
                        </div>
                        <script> $(function() { $("#datepicker").datepicker({format: "yyyy-mm-dd", todayHighlight: true, autoclose: true, endDate: "<?php echo date('Y-m-d'); ?>"}); }); </script>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Amount</label>
                        <div class="controls controls-row">
                            <input type="number" name="v_amount" id="v_amount" value="<?php echo $voucher->v_amount; ?>" required="required" class="span12" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Remarks/Notes</label>
                        <div class="controls controls-row">
                            <input type="text" class="span12" name="v_note" value="<?php echo $voucher->v_note; ?>" />
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <h5>Branch: <?php echo get_branch_name($b_id); ?></h5>
                        <input type="hidden" name="trigger" value="voucher" />
                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Update Voucher Entry</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $("#voucher").change(function(){
        var headtype = $("#voucher").val();
        $.ajax({
            type: "POST",
            url: "<?php  echo site_url('accounts/get_ledger_head_for_voucher');?>",
            data: {headtype: headtype},
            cache: false,
            beforeSend: function(){
               $('.ledger_info').html(
                   '<img src="<?php echo base_url() , 'img/loading-orange.gif'; ?>" style="margin-left: 20%; margin-top:5%;" />'
               );
            },
            success: function(html){
               $(".ledger_info").html(html);
            }
       });
    });
</script>