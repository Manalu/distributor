<?php

/**
 * Description of daily_closing
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <div class="span3">
    </div>
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Daily Closing.
                </div>
            </div>
            <div class="widget-body"><?php notification(); ?></div>
            <div class="widget-body center-align-text">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <tbody>
                        <tr>
                            <td style="width: 50%; text-align: center;">Date</td>
                            <td style="text-align: right;">
                                <?php echo date_format(date_create($closing_value['closing_date']), 'd, M Y - l'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Company</td>
                            <td style="text-align: right;">
                                <?php $closing_value['Profit'] = $closing_value['Profit'] + $closing_value['Company']; ?>
                                <?php echo bdt() . number_format($closing_value['Company'], 2, ".", ","); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Stock</td>
                            <td style="text-align: right;">
                                <?php $closing_value['Profit'] = $closing_value['Profit'] + $closing_value['Stock']; ?>
                                <?php echo bdt() . number_format($closing_value['Stock'], 2, ".", ","); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Cash In Hand</td>
                            <td style="text-align: right;">
                                <?php $closing_value['Profit'] = $closing_value['Profit'] + $closing_value['CashInHand']; ?>
                                <?php echo bdt() . number_format($closing_value['CashInHand'], 2, ".", ","); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Damage</td>
                            <td style="text-align: right;">
                                <?php $closing_value['Profit'] = $closing_value['Profit'] + $closing_value['Damage']; ?>
                                <?php echo bdt() . number_format($closing_value['Damage'], 2, ".", ","); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Total Due</td>
                            <td style="text-align: right;">
                                <?php $closing_value['Profit'] = $closing_value['Profit'] + $closing_value['TotalDue']; ?>
                                <?php echo bdt() . number_format($closing_value['TotalDue'], 2, ".", ","); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Loan</td>
                            <td style="text-align: right;">
                                <?php $closing_value['Profit'] = $closing_value['Profit'] - $closing_value['Liability']; ?>
                               <?php echo bdt() . number_format($closing_value['Liability'], 2, ".", ","); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="height: 20px; background-color: greenyellow;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Investment</td>
                            <td style="text-align: right;">
                               <?php $closing_value['Profit'] = $closing_value['Profit'] - $closing_value['Investment']; ?>
                               <?php echo bdt() . number_format($closing_value['Investment'], 2, ".", ","); ?>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="height: 20px; background-color: greenyellow;"></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Profit</td>
                            <td style="text-align: right;">
                               <?php echo bdt() . number_format($closing_value['Profit'], 2, ".", ","); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="center-align-text">
                                <?php if($flag) { ?>
                                <form action="<?php echo site_url('accounts/dailyclosing'); ?>" method="POST" name="daily_close">
                                    <input type="hidden" name="closing_date" value="<?php echo $closing_value['closing_date']; ?>" />
                                    <input type="hidden" name="company_balance" value="<?php echo $closing_value['Company']; ?>" />
                                    <input type="hidden" name="stock_balance" value="<?php echo $closing_value['Stock']; ?>" />
                                    <input type="hidden" name="cash_in_hand" value="<?php echo $closing_value['CashInHand']; ?>" />
                                    <input type="hidden" name="damage_balance" value="<?php echo $closing_value['Damage']; ?>" />
                                    <input type="hidden" name="total_due_balance" value="<?php echo $closing_value['TotalDue']; ?>" />
                                    <input type="hidden" name="loan_balance" value="<?php echo $closing_value['Liability']; ?>" />
                                    <input type="hidden" name="invest_balance" value="<?php echo $closing_value['Investment']; ?>" />
                                    <input type="hidden" name="trigger" value="<?php echo 'close_the_day'; ?>" />
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to close the day?')">Close the Day</button>
                                </form>
                                <?php } else { ?>
                                <button type="button" class="btn btn-inverse">Close the Day</button>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="span3"></div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Daily Closing Record.
                </div>
            </div>
            <div class="widget-body">
                <div class="span6 form-inline">
                    <script>
                        $(function() {
                            $("#closing_date_start").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date('Y-m-d'); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">From</label>
                        <div class="controls">
                            <input name="closing_date_start" id="closing_date_start" class="span12" readonly="readonly" value="<?php echo date('Y-m-d'); ?>" type="text">
                        </div>
                    </div>
                </div>
                <div class="span6 form-inline">
                    <script>
                        $(function() {
                            $("#closing_date_end").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date('Y-m-d'); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">To</label>
                        <div class="controls">
                            <input name="closing_date_end" id="closing_date_end" class="span12" readonly="readonly" value="<?php echo date('Y-m-d'); ?>" type="text">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="span12 center-align-text">
                    <button type="button" class="btn btn-primary" id="closing_record_search"> Search </button>
                </div>
            </div>
            <div id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <div class="widget-body">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 10%;">Date</th>
                                <th style="text-align: right; width: 13%;">Company</th>
                                <th style="text-align: right; width: 13%;">Stock</th>
                                <th style="text-align: right; width: 13%;">Cash In Hand</th>
                                <th style="text-align: right; width: 13%;">Damage</th>
                                <th style="text-align: right; width: 13%;">Total Due</th>
                                <th style="text-align: right; width: 13%;">Loan</th>
                                <th style="text-align: right; width: 13%;">Investment</th>
                            </tr>
                        </thead>
                        <tbody id="closing_data_table">
                            
                        </tbody>
                    </table>
                </div>
                <?php include 'application/views/common/marketing.php'; ?>
            </div>
            <?php include 'application/views/common/printer.php'; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#closing_record_search").click(function(){
        var start = $("#closing_date_start").val();
        var to    = $("#closing_date_end").val();
        $.ajax({
            type: "POST",
             url: "<?php echo site_url('accounts/search_closing'); ?>",
             data: {from: $("#closing_date_start").val(), to: $("#closing_date_end").val()},
             cache: false,
             beforeSend: function(){
               $('#closing_data_table').html(
                   '<tr><td colspan="7" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
               );
             },
             success: function(html){
                 $("#closing_data_table").html(html);
             },
             error:function(html){
                 $("#closing_data_table").html(html.responseText);
             } 
         });
    });
</script>