<?php

/**
 * Description of incentive_calculation
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <div class="widget">
        <div class="widget-header">
            <div class="title">
                <?php widgetHeader(); ?> Monthly Incentive Calculation
            </div>
        </div>
        <div class="widget-body">
            <?php notification(); ?>
        </div>
        <div class="widget-body">
            <div class="span6 form-inline">
                <div class="control-group">
                    <label class="control-label">Month</label>
                    <div class="controls controls-row">
                        <select class="span12" id="month" name="month">
                            <option value="">Select a Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="span6 form-inline">
                <div class="control-group">
                    <label class="control-label">Year</label>
                    <div class="controls controls-row">
                        <input type="number" name="year" id="year" value="<?php echo date('Y'); ?>" placeholder="Year" class="span12" />
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="span12 center-align-text">
                <input class="btn btn-primary" id="calculatecomapnyincentive" value="Calculate Monthly Incentive" type="button">
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="widget-body">
            <table class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <tr>
                        <th style="text-align: center; width: 5%;">
                            SL.
                        </th>
                        <th style="width: 15%;">
                            Company
                        </th>
                        <th style="width: 10%;">
                            Policy
                        </th>
                        <th style="width: 10%;">
                            Type
                        </th>
                        <th style="width: 10%; text-align: right;">
                            Incentive
                        </th>
                        <th style="width: 15%; text-align: right;">
                            Target
                        </th>
                        <th style="width: 15%; text-align: right;">
                            Achieved
                        </th>
                        <th style="width: 15%; text-align: right;">
                            Incentive
                        </th>
                        <th style="text-align: center; width: 5%;">
                            Adjust
                        </th>
                    </tr>
                </thead>
                <tbody id="incentive_calculate">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo site_url('supplier/creditpost'); ?>" method="GET" class="form-horizontal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Incentive Adjustment</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <label class="control-label">Month</label>
                        <div class="controls controls-row">
                            <p id="month_text"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Year</label>
                        <div class="controls controls-row">
                            <p id="year_text"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Supplier</label>
                        <div class="controls controls-row">
                            <p id="supplier_text"></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Amount</label>
                        <div class="controls controls-row">
                            <input class="span3" type="number" name="amount" placeholder="Incentive Amount" id="inc_amount" autofocus="on" min="1" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="supplier" id="inc_supplier" value="" />
                    <input type="hidden" name="month" id="inc_month" value="" />
                    <input type="hidden" name="year" id="inc_year" value="" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Make Incentive Adjustment</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $("#calculatecomapnyincentive").click(function(){
        var month = $("#month").val();
        var year  = $("#year").val();
        
        if(month === "" || year == ""){
            alert("Please select a month or year");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('supplier/calculate_incentive'); ?>",
                data: { month: month, year: year },
                cache: false,
                beforeSend: function(){
                    $('#incentive_calculate').html(
                    '<tr><td colspan="9" class="center-align-text"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" style="" /></td></tr>'
                    );
                },
                success: function(html){
                    $("#incentive_calculate").html(html);
                } 
           });
        }
    });
    function set_modal_value_incentive_posting(supplier, month, year, incentive, supplierText){
        $("#inc_supplier").val(supplier);
        $("#inc_month").val(month);
        $("#inc_year").val(year);
        $("#inc_amount").val(incentive);
        $("#month_text").html(month);
        $("#year_text").html(year);
        $("#supplier_text").html(supplierText);
    }
</script>