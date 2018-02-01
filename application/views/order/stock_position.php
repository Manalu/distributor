<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Products Stock Position
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
                            <label class="control-label">Product </label>
                            <div class="controls controls-row">
                                <input name="p_name" id="p_name" class="span12" placeholder="Product Name" type="text" autocomplete="off">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="span3">
                    <form class="form-inline">
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
                    </form>
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
                <div class="span3 form-inline">
                    <script>
                        $(function() {
                            $("#closing_date").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date("Y-m-d"); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">Closing Date</label>
                        <div class="controls">
                            <input name="closing_date" id="closing_date" class="span12" readonly="readonly" type="text" value="<?php echo date('Y-m-d') ?>" />
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="span12 center-align-text">
                    <button type="button" class="btn btn-primary" id="purchase_order_search_button">Search Product Stock</button>
                    <button type="button" class="btn btn-warning" id="search_closing_date">Search Closing Report</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body" id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 10%;">SL.</th>
                            <th style="width: 20%">Name</th>
                            <th style="width: 15%;">Group</th>
                            <th style="width: 20%;">Supplier</th>
                            <th style="width: 10%; text-align: center;">Cartoon</th>
                            <th style="width: 10%; text-align: center;">Piece</th>
                            <th style="width: 15%; text-align: right;">Price</th>
                        </tr>
                    </thead>
                    <tbody id="filtered_order_table">
                        <?php if($products != FALSE) { $total = 0; $sl = 1; foreach($products->result() as $products) {  ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $sl; ?></td>
                            <td><?php echo $products->p_name; ?></td>
                            <td><?php echo $products->mg_name; ?></td>
                            <td><?php echo $products->c_name; ?></td>
                            <td style="text-align: center;" data-title="Total Stock">
                                <?php echo get_number_of_boxes($products->p_stok, $products->p_box_qty); ?>
                            </td>
                            <td style="text-align: center;" data-title="Total Stock">
                                <?php echo get_number_of_remainder($products->p_stok, $products->p_box_qty); ?>
                            </td>
                            <td style="text-align: right;">
                                <?php $total = $total + ($products->p_stok * $products->p_stock_price); ?>
                                <?php echo bdt() . number_format($products->p_stok * $products->p_stock_price, 2, ".", ","); ?>
                            </td>
                        </tr>
                        <?php $sl++; } ?>
                        <tr>
                            <th colspan="6" style="text-align: right;">Total</th>
                            <th style="text-align: right;"><?php echo bdt() . number_format($total, 2, ".", ","); ?></th>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="clearfix"></div>
                <?php include 'application/views/common/marketing.php'; ?>
            </div>
            <?php if($role == 3) { ?>
            <div class="widget-body center-align-text">
                <h4>Date: <?php echo date('dS M, Y'); ?></h4>
                <a class="btn btn-success" href="<?php echo site_url('order/stockclose'); ?>" onclick="return confirm('Are you sure to proceed??\nThe stock closing action can only be perfoemd once a day & this is un-editable, so please double check before you perform this action finally.')">Stock Closing</a>
                <h3>The stock closing action can only be perfoemd once a day & this is un-editable, so please double check before you perform this action finally.</h3>
                <div class="clearfix"></div>                
            </div>
            <?php } ?>
            <?php include 'application/views/common/printer.php'; ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div id="stockModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="myModalLabel"> Branch Wise Stock Position</h4>
    </div>
    <div class="modal-body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"> Close </button>
    </div>
</div>
<script type="text/javascript">
    $("#purchase_order_search_button").click(function(){
        var sku         = $("#p_name").val();
        var cid         = $("#p_cid").val();
        var brn         = $("#branch").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('order/filter_pro_stock'); ?>",
            data: {sku: sku, cid: cid, brn: brn},
            cache: false,
            beforeSend: function(){
              $('#filtered_order_table').html(
                  '<tr><td colspan="9" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
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
    
    $("#search_closing_date").click(function(){
        var branch         = $("#branch").val();
        var cldate         = $("#closing_date").val();
        var cid            = $("#p_cid").val();
        if(branch.length < 1){
            alert("Please select a branch");
            return false;
        }
        if(cldate.length < 1){
            alert("Please select a date");
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('order/filter_daily_closing'); ?>",
            data: {brn: branch, cldate: cldate, supplier: cid},
            cache: false,
            beforeSend: function(){
              $('#filtered_order_table').html(
                  '<tr><td colspan="9" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
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
    
    function get_pro_stock(proid){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('products/stock_report'); ?>",
            data: {proid: proid},
            cache: false,
            beforeSend: function(){
              $('.modal-body').html(
                  '<img src="<?php echo $img . 'ajaxloader.gif'; ?>" style="text-align: center;" />'
              );
            },
            success: function(html){
                $(".modal-body").html(html);
            },
            error:function(html){
                $(".modal-body").html(html.responseText);
            }
        });
    }
</script>