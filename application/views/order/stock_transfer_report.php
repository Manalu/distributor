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
                    <?php widgetHeader(); ?> Stock Transfer Report
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
                        <label class="control-label">From</label>
                        <div class="controls controls-row">
                            <select class="span12" id="source" name="source">
                                <option value="">From Branch</option>
                                <?php if($branch != FALSE) { foreach ($branch->result() as $from) { ?>
                                <option value="<?php echo $from->tble_id; ?>"><?php echo $from->b_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">To</label>
                        <div class="controls controls-row">
                            <select class="span12" id="destination" name="destination">
                                <option value="">To Branch</option>
                                <?php if($branch != FALSE) { foreach ($branch->result() as $to) { ?>
                                <option value="<?php echo $to->tble_id; ?>"><?php echo $to->b_name; ?></option>
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
                            <th style="width: 25%;">Product</th>
                            <th style="width: 20%;">Supplier</th>
                            <th style="width: 25%; text-align: center;">Cartoon</th>
                            <th style="width: 25%; text-align: center;">Piece</th>
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
        var startd8     = $("#sales_date_start").val();
        var finsd8      = $("#sales_date_end").val();
        var source      = $("#source").val();
        var destination = $("#destination").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('order/get_stock_transfer_report'); ?>",
            data: {from: startd8, to: finsd8, source: source, destination: destination},
            cache: false,
            beforeSend: function(){
              $('#filtered_sales_table').html(
                  '<tr><td colspan="6" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
              );
           },
            success: function(html){
                $("#filtered_sales_table").html(html);
             },
             error:function(html){
                 $("#filtered_sales_table").html(html.responseText);
             }
        });
    });
</script>