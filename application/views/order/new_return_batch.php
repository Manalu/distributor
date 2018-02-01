<?php

/**
 * Description of new_damage_batch
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
                    <?php widgetHeader(); ?> Create new return batch
                </div>
            </div>
            <div class="widget-body">
                <form action="<?php echo site_url('order/newbatch'); ?>" class="form-horizontal" method="post">
                    <div class="control-group">
                        <label class="control-label"> Batch No.</label>
                        <div class="controls controls-row">
                            <input class="span12" name="batch_no" placeholder="Batch No" required="required" autofocus="on" type="text">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Supplier</label>
                        <div class="controls controls-row">
                            <select class="span12" id="supplier_id" name="supplier_id">
                                <option value="">Select a Supplier</option>
                                <?php if($sups != FALSE) { foreach ($sups->result() as $sups) { ?>
                                <option value="<?php echo $sups->c_id; ?>"><?php echo $sups->c_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <script>
                    $(function() {
                            $("#store_date").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date("Y-m-d"); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from"> Date</label>
                        <div class="controls">
                            <input name="store_date" id="store_date" class="span12" value="<?php echo date('Y-m-d'); ?>" type="text" autocomplete="off" readonly="readonly" />
                        </div>
                    </div>
                    <hr />
                    <div class="form-actions">
                        <input type="hidden" name="trigger" value="new_damage_batch" />
                        <input type="submit" value="Create new Batch " class="btn btn-success" />
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>