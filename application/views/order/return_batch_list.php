<?php

/**
 * Description of damage_entry
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
                    <?php widgetHeader(); ?> Return Batch List
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">Supplier</label>
                        <div class="controls controls-row">
                            <select class="span12" id="supplier_id">
                                <option value="">Select a Supplier</option>
                                <?php if($sups != FALSE) { foreach ($sups->result() as $sups) { ?>
                                <option value="<?php echo $sups->c_id; ?>"><?php echo $sups->c_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label" for="from">Batch No.</label>
                        <div class="controls">
                            <input name="batch_no" id="batch_no" class="span12" placeholder="Batch No." type="text" >
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">Status</label>
                        <div class="controls controls-row">
                            <select class="span12" id="status">
                                <option value="">Batch Status</option>
                                <option value="1">Stored</option>
                                <option value="2">Submitted</option>
                                <option value="3">Adjusted</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">Branch</label>
                        <div class="controls controls-row">
                            <select class="span12" id="branch" name="branch">
                                <option value=""> Branch</option>
                                <?php if($branch != FALSE) { foreach ($branch->result() as $from) { ?>
                                <option value="<?php echo $from->tble_id; ?>"><?php echo $from->b_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="span12 center-align-text">
                    <button type="button" class="btn btn-primary" id="batch_search_button">Search Batch Details</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <div class="widget-body">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">SL.</th>
                                <th style="width: 15%;">Batch</th>
                                <th style="width: 15%;">Supplier</th>
                                <th style="width: 10%; text-align: center;">Item</th>
                                <th style="width: 10%; text-align: center;">Stored</th>
                                <th style="width: 13%; text-align: right;">Total</th>
                                <th style="width: 7%; text-align: center;">Adjust</th>
                                <th style="width: 5%; text-align: center;">Add</th>
                                <th style="width: 5%; text-align: center;">View</th>
                            </tr>
                        </thead>
                        <tbody id="damage_batch_list">

                        </tbody>
                    </table>
                </div>
                <?php include 'application/views/common/marketing.php'; ?>
            </div>
            <?php include 'application/views/common/printer.php'; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#batch_search_button").click(function(){
        var supplier    = $("#supplier_id").val();
        var batch_no    = $("#batch_no").val();
        var b_status    = $("#status").val();
        var branch      = $("#branch").val();
        if(supplier.length > 0 || b_status.length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('order/search_return_batch'); ?>",
                data: {supplier: supplier, batchno: batch_no, b_status: b_status, branch: branch},
                cache: false,
                beforeSend: function(){
                  $('#damage_batch_list').html(
                      '<tr><td colspan="10" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
                  );
               },
                success: function(html){
                    $("#damage_batch_list").html(html);
                 },
                 error:function(html){
                     $("#damage_batch_list").html(html.responseText);
                 }
            });
        } else {
            alert("Select A Supplier & Batch Status");
            return false;
        }
    });
</script>