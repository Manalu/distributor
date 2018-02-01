

<form action="<?php echo site_url('order/emergency')?>" method="post" id="emergency_stock_form">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Emergency Stock Entry
                    </div>
                </div>
                <div class="widget-body">
                    <?php notification(); ?>
                </div>
                <div class="widget-body">
                    <div class="span6 form-inline">
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
                    <div class="span6 form-inline">
                        <div class="control-group">
                            <label class="control-label">Branch</label>
                            <div class="controls controls-row">
                                <select class="span12" name="branch_id" id="branch_id" required="required">
                                    <option value="">Branch</option>
                                    <?php if($destin != FALSE) { foreach ($destin->result() as $destin) {   ?>
                                    <option value="<?php echo $destin->tble_id; ?>"><?php echo $destin->b_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="span12 center-align-text">
                        <input type="button" class="btn btn-success" name="getmedzstock" id="getmedzstock" value="Get Product List" />
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget-body">
                    <table class="table table-condensed table-striped table-hover table-bordered pull-left">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Product</th>
                                <th style="width: 15%;">Group</th>
                                <th style="width: 15%;" class="center-align-text">In Stock </th>
                                <th style="width: 10%;" class="center-align-text">Box</th>
                                <th style="width: 10%;" class="center-align-text">Cartoon</th>
                                <th style="width: 10%;" class="center-align-text">Piece</th>
                                <th style="width: 15%;" class="center-align-text">Total</th>
                            </tr>
                        </thead>
                        <tbody id="medtable">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="center-align-text">
                                    <input type="hidden" name="trigger" value="emergency" />
                                    <input type="submit" class="btn btn-info" value="Update Stock" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $("#getmedzstock").click(function(){
        var supplier = $("#p_cid").val();
        if(supplier.length > 0){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>order/emergency_stocksearch",
                data: { sup: supplier },
                cache: false,
                beforeSend: function(){
                    $('#medtable').html(
                    '<tr><td colspan="7" class="center-align-text"><img src="<?php echo base_url(); ?>/img/ajaxloader.gif" style="" /></td></tr>'
                    );
                },
                success: function(html){
                    $("#medtable").html(html);
                } 
           });
        } else {
            alert("Please select a supplier");
            return false;
        }
    });
    
    function calculate_cartoon_piece(qty, pro){
        var cartoon = $("#cart_box_" + pro).val();
        var piececs = $("#cart_pcs_" + pro).val();
        cartoon = parseInt(cartoon);
        piececs = parseInt(piececs);
        var total   = parseInt((cartoon * qty) + piececs);
        
        $("#cart_qty_" + pro).val(total);
        $("#total_quantity_" + pro).html(total);
    }
</script>
<script language="JavaScript">
$('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    }
    else{
        $(':checkbox').each(function() {
            this.checked = false;                        
        });
    }
});
</script>