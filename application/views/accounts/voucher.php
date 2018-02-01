<?php

/*
 * Tarek Showkot|priom2000@gmail.com|tarek@exploriasolution.com|forgotten_tarek@hotmail.comTo change this template, choose Tools | Templates
 * Tarek Showkot|priom2000@gmail.com|tarek@exploriasolution.com|forgotten_tarek@hotmail.comand open the template in the editor.
 */
?>

<div class="row-fluid">
    <form action="<?php echo site_url('accounts/voucher');?>" class="form-horizontal no-margin" method="POST">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Income & Expense Voucher
                    </div>
                </div>
                <div class="widget-body">
                    <?php notification(); ?>
                    <div class="control-group">
                        <label class="control-label">Type</label>
                        <div class="controls controls-row">
                            <select name="voucher" id="voucher" required="required" class="span12" autofocus="on">
                                <option value="">Select</option>
                                <option value="1">Income</option>
                                <option value="2">Expense</option>
                            </select>
                        </div>
                    </div>
                    <div class="ledger_info">
                    </div>
                    <div class="control-group">
                        <label class="control-label">Method</label>
                        <div class="controls controls-row">
                            <select name="method" id="method" required="required" class="span12">
                                <option value="">Select Payment Method</option>
                                <?php if($method != FALSE) { foreach($method->result() as $method) {    ?>
                                <option value="<?php echo $method->tble_id; ?>">
                                    <?php echo $method->method; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Date</label>
                        <div class="controls">
                            <input type="text" name="v_date" id="datepicker" class="span12" placeholder="Voucher Date" value="<?php echo date('Y-m-d'); ?>" readonly="readonly" />
                        </div>
                        <script> $(function() { $("#datepicker").datepicker({format: "yyyy-mm-dd", todayHighlight: true, autoclose: true, endDate: "<?php echo date('Y-m-d'); ?>"}); }); </script>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Amount</label>
                        <div class="controls controls-row">
                            <input type="text" name="v_amount" class="input-block-level" id="v_amount" placeholder="Voucher Amount" required="required" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Remarks/Notes</label>
                        <div class="controls controls-row">
                            <input type="text" class="span12" rows="6" name="v_note" placeholder="Remarks/Notes" />
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <h5>Branch: <?php echo get_branch_name($b_id); ?></h5>
                        <input type="hidden" name="trigger" value="voucher" />
                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Post Voucher</button>
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