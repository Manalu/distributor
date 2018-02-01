<?php

/*
 * Tarek Showkot|priom2000@gmail.com|tarek@exploriasolution.com|forgotten_tarek@hotmail.comTo change this template, choose Tools | Templates
 * Tarek Showkot|priom2000@gmail.com|tarek@exploriasolution.com|forgotten_tarek@hotmail.comand open the template in the editor.
 */
?>

<div class="row-fluid">
    <form action="<?php echo site_url('accounts/suppliercredit');?>" class="form-horizontal no-margin" method="POST">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Credit Deposit to Supplier
                    </div>
                </div>
                <div class="widget-body">
                    <?php notification(); ?>
                    <div class="control-group">
                        <label class="control-label">Supplier</label>
                        <div class="controls controls-row">
                            <select class="span12" id="company" name="company" required="required">
                                <option value="">Select a Supplier</option>
                                <?php if($sups != FALSE) { foreach ($sups->result() as $sups) { ?>
                                <option value="<?php echo $sups->c_id; ?>"><?php echo $sups->c_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Method</label>
                        <div class="controls controls-row">
                            <select class="span12" id="method" name="method" required="required">
                                <option value="">Select a Method</option>
                                <?php if($method != FALSE) { foreach ($method->result() as $method) { ?>
                                <option value="<?php echo $method->tble_id; ?>"><?php echo $method->method; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Head</label>
                        <div class="controls controls-row">
                            <select class="span12" id="ledger" name="ledger" required="required">
                                <option value="">Select a Head</option>
                                <?php if($ledger != FALSE) { foreach ($ledger->result() as $ledger) { if($ledger->tble_id != 6) { ?>
                                <option value="<?php echo $ledger->tble_id; ?>"><?php echo $ledger->ledger; ?></option>
                                <?php } } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Date</label>
                        <div class="controls">
                            <input type="text" name="adjust_date" id="adjust_date" class="span12" placeholder="Voucher Date" value="<?php echo date('Y-m-d'); ?>" required="required" readonly="readonly" />
                        </div>
                        <script> $(function() { $("#adjust_date").datepicker({format: "yyyy-mm-dd", todayHighlight: true, autoclose: true, endDate: "<?php echo date('Y-m-d'); ?>"}); }); </script>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Amount</label>
                        <div class="controls controls-row">
                            <input type="number" name="amount" id="amount" placeholder="Amount Deposited" required="required" class="span12" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Remarks/Notes</label>
                        <div class="controls controls-row">
                            <!--<textarea class="span12" rows="6" name="notes"></textarea>-->
                            <input type="text" name="notes" id="notes" placeholder="Remarks/Notes" class="span12" />
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <h4>The amount will be adjusted from Central Depot Cash in hand</h4>
                        <hr />
                    </div>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="trigger" value="company_credit" />
                        <button type="submit" class="btn btn-primary"> Deposit Credit</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!--<script type="text/javascript">
    $("#voucher").change(function(){
        var headtype = $("#voucher").val();
        $.ajax({
            type: "POST",
            url: "<?php //echo site_url('accounts/get_ledger_head_for_voucher');?>",
            data: {headtype: headtype},
            cache: false,
            beforeSend: function(){
               $('.ledger_info').html(
                   '<img src="<?php //echo base_url() , 'img/loading-orange.gif'; ?>" style="margin-left: 20%; margin-top:5%;" />'
               );
            },
            success: function(html){
               $(".ledger_info").html(html);
            }
       });
    });
</script>-->