<?php

/**
 * Description of balance_transfer
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <form action="<?php echo site_url('accounts/transfer'); ?>" method="POST">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Balance Transfer from Branch to Branch
                    </div>
                </div>
                <div class="widget-body"><?php notification(); ?></div>
                <div class="clearfix"></div>
                <div class="widget-body">
                    <div class="span6 form-inline">
                        <div class="control-group">
                            <label class="control-label">Source</label>
                            <div class="controls controls-row">
                                <select class="span12" name="source" id="source">
                                    <option value=""><?php echo get_branch_name($b_id); ?></option>
                                    <?php //if($source != FALSE) { foreach ($source->result() as $source) {   ?>
                                    <option value="<?php //echo $source->tble_id; ?>"><?php //echo $source->b_name; ?></option>
                                    <?php //} } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span6 form-inline">
                        <div class="control-group">
                            <label class="control-label">Destination</label>
                            <div class="controls controls-row">
                                <select class="span12" name="destination" id="destination" required="required">
                                    <option value="">Select Destination Branch</option>
                                    <?php if($destin != FALSE) { foreach ($destin->result() as $destin) { if($destin->tble_id != $b_id) {   ?>
                                    <option value="<?php echo $destin->tble_id; ?>"><?php echo $destin->b_name; ?></option>
                                    <?php } } } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="widget-body">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">SL.</th>
                                <th style="width: 30%;">Branch</th>                            
                                <th style="width: 25%; text-align: right;">Balance</th>
                                <th style="width: 40%; text-align: center;">Transfer</th>
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
    $("#source").change(function(){
        var source = '<?php echo $b_id; ?>';
        if(source > 0){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('accounts/branch_balance_transfer'); ?>",
                data: {b_id: source},
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
            alert("Please select a source branch");
            return false;
        }
    });
    
    $(document).ready(function(){
        $("#source").change();
    });
</script>