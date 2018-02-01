<?php

/**
 * Description of add_damage_item
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<form class=" no-margin" action="<?php echo site_url('order/return_items_entry')?>" method="POST">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Add Return Item
                    </div>
                </div>
                <div class="widget-body">
                    <div class="span6 form-inline">
                        <div class="control-group">
                            <label class="control-label">Supplier</label>
                            <div class="controls controls-row">
                                <select class="span12" id="supplier_id" name="supplier_id">
                                    <option value="">Select a Supplier</option>
                                    <?php if($sups != FALSE) { foreach ($sups->result() as $sups) { ?>
                                    <option value="<?php echo $sups->c_id; ?>" <?php if($filter_company != FALSE && $filter_company == $sups->c_id) { echo 'selected'; } ?>>
                                        <?php echo $sups->c_name; ?>
                                    </option>
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
                                    <option value="<?php echo $destin->tble_id; ?>" <?php if($filter_branch != FALSE && $filter_branch == $destin->tble_id) { echo 'selected'; } ?>>
                                        <?php echo $destin->b_name; ?>
                                    </option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="span12 center-align-text">
                        <input type="button" class="btn btn-success" name="getmedzstock" id="getmedzstock" value="Get Products" />
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget-body form-horizontal">
                    <table class="table table-condensed table-striped table-hover table-bordered pull-left">
                        <thead>
                            <tr>
                                <th class="center-align-text" style="width:10%;">
                                    <input id="select-all" type="checkbox" />
                                </th>
                                <th style="width: 25%;">Product</th>
                                <th style="width: 15%;">Group</th>
                                <th style="width: 15%;" class="center-align-text">In Stock (Piece)</th>
                                <th style="width: 10%;" class="center-align-text">Damaged</th>
                                <th style="width: 10%;" class="center-align-text">Price</th>
                                <th style="width: 10%;" class="center-align-text">Notes</th>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <button type="submit" class="btn btn-mini btn-info pull-right">Save Entry</button>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="medtable">
                        </tbody>
                    </table>
                    <input type="hidden" name="trigger" value="add_damage_item" />
                    <input type="hidden" name="return_id" value="<?php echo $return; ?>" />
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $("#getmedzstock").click(function(){
        var supplier = $("#supplier_id").val();
        var branchs  = $("#destination").val();
        if(supplier.length > 0){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('order/return_pro_search'); ?>",
                data: { sup: supplier, branchs: branchs },
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
    
    $(document).ready(function(){
        $("#getmedzstock").trigger('click'); //$("#getmedzstock").click();
    });
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