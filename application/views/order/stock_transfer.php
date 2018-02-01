<?php

/**
 * Description of stock_transfer
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <form action="<?php echo site_url('order/transfer'); ?>" method="POST">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Stock Transfer from Branch to Branch
                    </div>
                </div>
                <div class="widget-body"><?php notification(); ?></div>
                <div class="clearfix"></div>
                <div class="widget-body">
                    <div class="span6 form-inline">
                        <div class="control-group">
                            <label class="control-label">Supplier</label>
                            <div class="controls controls-row">
                                <select class="span12" id="supplier_id" required="required">
                                    <option value="">Select a Supplier</option>
                                    <?php if($sups != FALSE) { foreach ($sups->result() as $sups) { ?>
                                    <option value="<?php echo $sups->c_id; ?>"><?php echo $sups->c_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="source" id="source" value="<?php echo $b_id; ?>" />
<!--                    <div class="span4 form-inline">
                        <div class="control-group">
                            <label class="control-label">Source</label>
                            <div class="controls controls-row">
                                <select class="span12" name="source" id="source" required="required">
                                    <option value="">Select Source Branch</option>
                                    <?php //if($source != FALSE) { foreach ($source->result() as $source) {   ?>
                                    <option value="<?php //echo $source->tble_id; ?>"><?php //echo $source->b_name; ?></option>
                                    <?php //} } ?>
                                </select>
                            </div>
                        </div>
                    </div>-->
                    <div class="span6 form-inline">
                        <div class="control-group">
                            <label class="control-label">Destination</label>
                            <div class="controls controls-row">
                                <select class="span12" name="destination" id="destination" required="required">
                                    <option value="">Select Source Branch</option>
                                    <?php if($destin != FALSE) { foreach ($destin->result() as $destin) {   ?>
                                    <option value="<?php echo $destin->tble_id; ?>"><?php echo $destin->b_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="span12 center-align-text">
                        <button type="button" class="btn btn-primary" id="stock_search_button">Search Branch Stock</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="widget-body">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">SL.</th>
                                <th style="width: 25%;">Name</th>                            
                                <th style="width: 15%;">Supplier</th>
                                <th style="width: 15%;">Group</th>
                                <th style="width: 10%; text-align: center;">Available</th>
                                <th style="width: 10%; text-align: center;">Cartoon</th>
                                <th style="width: 10%; text-align: center;">Piece</th>
                                <th style="width: 10%; text-align: center;">Total</th>
                            </tr>
                        </thead>
                        <tbody id="filtered_order_table">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $("#stock_search_button").click(function(){
        var suppli = $("#supplier_id").val();
        var source = $("#source").val();
        if(source > 0 && suppli !== ""){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('order/pro_stock_transfer'); ?>",
                data: {b_id: source, s_id: suppli},
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
        } else {
            alert("Please select a source branch & Supplier");
            return false;
        }
    });
    
    function calculate_product_quantity_stock_transfer(boxqty, proid){
        var cartoon     = parseInt($("#cart_box_" + proid).val());
        var pieceq      = parseInt($("#cart_pcs_" + proid).val());
        if(isNaN(cartoon)){ cartoon = 0; }
        if(isNaN(pieceq)){ pieceq = 0; }
        var totalqty    = (cartoon * boxqty) + pieceq;
        $("#cart_qty_" + proid).val(totalqty);
    }
    function get_focus_out(proid){
        $("#cart_qty_" + proid).blur();
    }
</script>