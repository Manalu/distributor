<?php

/**
 * Description of loan_deposit
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <form action="<?php echo site_url('accounts/cashbookopening');?>" class="form-horizontal no-margin" method="POST">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Cash Book Opening Balance
                    </div>
                </div>
                <div class="widget-body"> <?php notification(); ?> </div>
                <div class="widget-body">
                    <div class="control-group">
                        <label class="control-label">From</label>
                        <div class="controls controls-row">
                            <select name="user_id" id="user_id" required="required" class="span12" autofocus="on">
                                <option value="">Select</option>
                                <?php if($user_list != FALSE) { foreach($user_list->result() as $users) { ?>
                                <option value="<?php echo $users->u_id; ?>">
                                    <?php echo $users->u_name; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
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
                            <input type="number" name="amount" id="amount" placeholder="Amount" required="required" class="span12"  />
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
                        <input type="hidden" name="trigger" value="cash_book_deposit" />
                        <button type="submit" class="btn btn-primary"> Cash Book Opening Balance</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>