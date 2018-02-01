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
                    <?php widgetHeader(); ?> Investment Withdraw
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <form action="<?php echo site_url('accounts/investrefund'); ?>" class="form-horizontal" method="POST">
                    <div class="form-actions">
                        <h5>Return To: <?php echo $u_name; ?></h5>
                        <p>Total Loan: <?php echo bdt() . number_format($balance, 2, ".", ","); ?></p>
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
                        <label class="control-label"> Amount</label>
                        <div class="controls controls-row">
                            <input type="number" name="amount" id="amount" placeholder="Return Amount" required="required" class="span12" max="<?php echo $cash_hand; ?>" min="1" step="any"  />
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
                            <input type="text" name="trans_date" id="trans_date" class="span12" placeholder="Loan Taking Date" value="<?php echo date('Y-m-d'); ?>" readonly="readonly" />
                        </div>
                        <script> $(function() { $("#trans_date").datepicker({format: "yyyy-mm-dd", todayHighlight: true, autoclose: true, endDate: "<?php echo date('Y-m-d'); ?>"}); }); </script>
                    </div>
                    <hr />
                    <div class="form-actions">
                        <input type="hidden" name="user_id" value="<?php echo $userid; ?>" />
                        <input type="hidden" name="trigger" value="loanrefund" />
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure? This will be deposited in Central Depot')"> Investment Withdraw</button>
                        <a href="<?php echo site_url('accounts/investbalance'); ?>" class="btn btn-default">Back to List</a>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>