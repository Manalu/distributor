<?php

/*
 * Tarek Showkot|priom2000@gmail.com|tarek@exploriasolution.com|forgotten_tarek@hotmail.comTo change this template, choose Tools | Templates
 * Tarek Showkot|priom2000@gmail.com|tarek@exploriasolution.com|forgotten_tarek@hotmail.comand open the template in the editor.
 */
?>

<div class="row-fluid">
    <form action="<?php echo site_url('order/damage_adjust');?>" class="form-horizontal no-margin" method="POST">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Damage Adjustment with Supplier
                    </div>
                </div>
                <div class="widget-body">
                    <?php notification(); ?>
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
                        <label class="control-label"> Date</label>
                        <div class="controls">
                            <input type="text" name="adjust_date" id="adjust_date" class="span12" placeholder="Voucher Date" value="<?php echo date('Y-m-d'); ?>" required="required" readonly="readonly" />
                        </div>
                        <script> $(function() { $("#adjust_date").datepicker({format: "yyyy-mm-dd", todayHighlight: true, autoclose: true, endDate: "<?php echo date('Y-m-d'); ?>"}); }); </script>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Amount</label>
                        <div class="controls controls-row">
                            <input type="number" name="amount" id="amount" value="<?php echo $amount; ?>" required="required" class="span12" step="any" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Remarks/Notes</label>
                        <div class="controls controls-row">
                            <input type="text" name="notes" id="notes" placeholder="Remarks/Notes" class="span12" />
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="trigger" value="company_credit" />
                        <input type="hidden" name="company" id="company" value="<?php echo $company; ?>" />
                        <input type="hidden" name="batch" id="batch" value="<?php echo $batch; ?>" />
                        <button type="submit" class="btn btn-primary"> Adjust Damage</button>
                        <a href="<?php echo site_url('order/batchlist'); ?>" class="btn btn-default">Back To List</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>