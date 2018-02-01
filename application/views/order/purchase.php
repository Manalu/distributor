


<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Purchase Order
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
                            <select class="span12" name="destination" id="destination" required="required">
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
                    <input type="button" class="btn btn-danger" name="getshortstock" id="getshortstock" value="Get Short Stock" />
                    <input type="button" class="btn btn-success" name="getmedzstock" id="getmedzstock" value="Get Full Stock" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body">
                <form class="form-horizontal no-margin" action="<?php echo site_url('order/queue')?>" method="post" id="purchase_order_form">
                    <table class="table table-condensed table-striped table-hover table-bordered pull-left">
                        <thead>
                            <tr>
                                <th class="center-align-text" style="width:10%;">
                                    <input id="select-all" type="checkbox" />
                                </th>
                                <th style="width: 25%;">Product</th>
                                <th style="width: 15%;">Group</th>
                                <th style="width: 15%;" class="center-align-text">In Stock </th>
                                <th style="width: 15%;" class="center-align-text">Min Qty</th>
                                <th style="width: 15%;" class="center-align-text">Status</th>
                            </tr>
                        </thead>
                        <tbody id="medtable">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="center-align-text">
                                    <button type="button" class="btn btn-info" id="place_order">Place Order</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden" name="trigger" value="order/purchase" />
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>   
<script>
    $("#getmedzstock").click(function(){
        var supplier = $("#p_cid").val();
        var branchs  = $("#destination").val();
        if(supplier.length > 0){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>order/stocksearch",
                data: { sup: supplier, branchs: branchs },
                cache: false,
                beforeSend: function(){
                    $('#medtable').html(
                    '<tr><td colspan="6" class="center-align-text"><img src="<?php echo base_url(); ?>/img/ajaxloader.gif" style="" /></td></tr>'
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
    $("#getshortstock").click(function(){
        var supplier = $("#p_cid").val();
        var branchs  = $("#destination").val();
        if(supplier.length > 0){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>order/shortsearch",
                data: { sup: supplier, branchs: branchs },
                cache: false,
                beforeSend: function(){
                    $('#medtable').html(
                    '<tr><td colspan="6" class="center-align-text"><img src="<?php echo base_url(); ?>/img/ajaxloader.gif" style="" /></td></tr>'
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
    
    $("#place_order").click(function(){
        var atLeastOneIsChecked = $('input:checkbox').is(':checked');
        if(atLeastOneIsChecked){
            $("#purchase_order_form").submit();
        } else {
            alert("At least select one product");
            return false;
        }
    })
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