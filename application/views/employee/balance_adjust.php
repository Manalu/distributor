<?php

/**
 * Description of opening_balance_adjust
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php

/**
 * Description of loan_refund
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
                    <?php widgetHeader(); ?> Opening Balance Adjustment
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <form action="<?php echo site_url('employee/adjust'); ?>" class="form-horizontal" method="POST">
                    <div class="form-actions">
                        <h5>Adjustment Of: <?php echo $detls->emp_name; ?></h5>
                        <p>Current Balance: <?php echo bdt() . number_format($detls->emp_opening_balance, 2, ".", ","); ?></p>
                        <h6>Balance Type: <?php echo $detls->emp_balance_type; ?></h6>
                        <p>Total Paid: <?php echo bdt() . number_format($paid_adjust, 2, ".", ","); ?></p>
                        <p>Total Due: <?php echo bdt() . number_format($detls->emp_opening_balance - $paid_adjust, 2, ".", ","); ?></p>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Amount</label>
                        <div class="controls controls-row">
                            <input type="number" name="amount" id="amount" placeholder="Adjusted Amount" required="required" class="span12" max="<?php echo $detls->emp_opening_balance - $paid_adjust; ?>" min="1" step="any"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Remarks/Notes</label>
                        <div class="controls controls-row">
                            <input type="text" name="notes" id="notes" class="span12" placeholder="Remarks/Notes" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Date</label>
                        <div class="controls">
                            <input type="text" name="ledger_date" id="ledger_date" class="span12" placeholder="Adjustment Date" value="<?php echo date('Y-m-d'); ?>" readonly="readonly" />
                        </div>
                        <script> $(function() { $("#ledger_date").datepicker({format: "yyyy-mm-dd", todayHighlight: true, autoclose: true, endDate: "<?php echo date('Y-m-d'); ?>"}); }); </script>
                    </div>
                    <hr />
                    <div class="form-actions">
                        <h4>The amount will be adjusted into Central Depot Cash in Hand</h4>
                        <input type="hidden" name="type" value="<?php echo $detls->emp_balance_type; ?>" />
                        <input type="hidden" name="emp_id" value="<?php echo $detls->tble_id; ?>" />
                        <input type="hidden" name="trigger" value="opening_balance_adjust" />
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure? This will be adjusted from Opening Balance')"> Adjust Opening Balance</button>
                        <a href="<?php echo site_url('employee/list'); ?>" class="btn btn-default">Back to List</a>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>