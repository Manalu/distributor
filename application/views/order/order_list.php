<div class="row-fluid">
    <div class="widget">
        <div class="widget-header">
            <div class="title">
                <?php widgetHeader(); ?> Search Purchase Order
            </div>
        </div>
        <div class="widget-body">
            <?php notification(); ?>
        </div>
        <div class="clearfix"></div>
        <div class="widget-body">
            <div class="span3">
                <form class="form-inline">
                    <div class="control-group">
                        <label class="control-label">Supplier</label>
                        <div class="controls controls-row">
                            <select class="span12" id="supplier">
                                <option value="">Select a Supplier</option>
                                <?php if($sups != FALSE) { foreach ($sups->result() as $sups) { ?>
                                <option value="<?php echo $sups->c_id; ?>"><?php echo $sups->c_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="span3">
                <form class="form-inline">
                    <div class="control-group">
                        <label class="control-label" for="from">Company Memo</label>
                        <div class="controls">
                            <input name="or_comp_memo" id="or_comp_memo" class="span12" placeholder="Company Memo No." type="text" autocomplete="off" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="span2">
                <form class="form-inline">
                    <script>
                        $(function() {
                            $("#order_date_start").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date("Y-m-d"); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">From</label>
                        <div class="controls">
                            <input name="order_date_start" id="order_date_start" class="span12" placeholder="From" type="text" readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="span2">
                <form class="form-inline">
                    <script>
                        $(function() {
                            $("#order_date_end").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date("Y-m-d"); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">To</label>
                        <div class="controls">
                            <input name="order_date_end" id="order_date_end" class="span12" placeholder="To" type="text" readonly>
                        </div>
                    </div>
                </form>
            </div>
            <div class="span2">
                <form class="form-inline">
                    <div class="control-group">
                        <label class="control-label">Status</label>
                        <div class="controls controls-row">
                            <select class="span12" id="order_status">
                                <option value="">Order Status</option>
                                <option value="1">Placed</option>
                                <option value="2">Received</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
            <div class="span12 center-align-text">
                <button type="button" class="btn btn-primary" id="purchase_order_search_button">Search Purchase Order</button>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="widget-body search_order_list_body">
            <table class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 5%;">SL.</th>
                        <th style="width: 20%;">Supplier</th>
                        <th style="text-align: center; width: 10%;">Placed</th>
                        <th style="text-align: center; width: 5%;">Item</th>
                        <th style="text-align: right; width: 15%;">Billed</th>
                        <th style="text-align: right; width: 15%;">Paid</th>
                        <th style="text-align: right; width: 15%;">Due</th>
                        <th style="text-align: center; width: 5%;">Status</th>
                        <th style="text-align: center; width: 5%;">View</th>
                        <th style="text-align: center; width: 5%;">Receive</th>
                    </tr>
                </thead>
                <tbody id="filtered_order_table">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#purchase_order_search_button").click(function(){
        var supplier    = $("#supplier").val();
        var commemo     = $("#or_comp_memo").val();
        var startd8     = $("#order_date_start").val();
        var finsd8      = $("#order_date_end").val();
        var status      = $("#order_status").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('order/search_order_list'); ?>",
            data: {supplier: supplier, memono: commemo, start: startd8, finish: finsd8, status: status},
            cache: false,
            beforeSend: function(){
              $('#filtered_order_table').html(
                  '<tr><td colspan="10" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
              );
           },
            success: function(html){
                $("#filtered_order_table").html(html);
             },
             error:function(html){
                 $("#filtered_order_table").html(html.responseText);
             }
        });
    });
</script>