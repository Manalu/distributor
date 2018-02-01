<?php

/**
 * Description of stock_transaction
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
                    <?php widgetHeader(); ?> Sales List
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <div class="span3 form-inline">
                    <script>
                        $(function() {
                            $("#sales_date_start").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date("Y-m-d"); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">From</label>
                        <div class="controls">
                            <input name="sales_date_start" id="sales_date_start" class="span12" readonly="readonly" type="text" value="<?php echo date('Y-m-01') ?>" />
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <script>
                        $(function() {
                            $("#sales_date_end").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date("Y-m-d"); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">To</label>
                        <div class="controls">
                            <input name="sales_date_end" id="sales_date_end" class="span12" readonly="readonly" type="text" value="<?php echo date('Y-m-d') ?>" />
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">Supplier</label>
                        <div class="controls controls-row">
                            <select class="span12" id="p_cid" name="p_cid">
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
                        <label class="control-label">Branch</label>
                        <div class="controls controls-row">
                            <select class="span12" name="branch" id="branch">
                                <option value="">Branch</option>
                                <?php if($source != FALSE) { foreach ($source->result() as $source) {   ?>
                                <option value="<?php echo $source->tble_id; ?>"><?php echo $source->b_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="span12 center-align-text">
                    <button type="button" class="btn btn-primary" id="sales_search_button">Search </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="width: 5%; text-align: center;">SL.</th>
                            <th style="width: 20%;">Product</th>
                            <th style="width: 15%;">Supplier</th>
                            <th style="width: 10%; text-align: center;">Box Qty</th>
                            <th style="width: 12%; text-align: center;">Opening</th>
                            <th style="width: 12%; text-align: center;">Stock-In</th>
                            <th style="width: 12%; text-align: center;">Stock-Out</th>
                            <th style="width: 12%; text-align: center;">Balance</th>
                        </tr>
                    </thead>
                    <tbody id="filtered_sales_table"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#sales_search_button").click(function(){
        var p_cid       = $("#p_cid").val();
        var startd8     = $("#sales_date_start").val();
        var finsd8      = $("#sales_date_end").val();
        var p_sku       = $("#branch").val();
        if(p_sku === ""){
            alert("Please select a branch.");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('order/filter_stock_transaction'); ?>",
                data: {p_cid: p_cid, start: startd8, finish: finsd8, p_sku: p_sku},
                cache: false,
                beforeSend: function(){
                  $('#filtered_sales_table').html(
                      '<tr><td colspan="8" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
                  );
               },
                success: function(html){
                    $("#filtered_sales_table").html(html);
                 },
                 error:function(html){
                     $("#filtered_sales_table").html(html.responseText);
                 }
            });
        }
    });
</script>