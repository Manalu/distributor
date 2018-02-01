



<div class="row-fluid">
    <div class="span8" id="report_div">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span> Day Wise Report
                </div>
            </div>
            <div class="widget-body">
                <div class="span12">
                    <table class="table table-condensed table-hover table-striped">
                        <tbody>
                            <tr>
                                <td>Cash Invoice</td>
                                <td>:</td>
                                <td>&#2547; <?php echo number_format($cashsale, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Due Sales</td>
                                <td>:</td>
                                <td>&#2547; <?php echo number_format($dueblnce, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Card Sale</td>
                                <td>:</td>
                                <td>&#2547; <?php echo number_format($cardsale, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="success" style="height: 17px;"></td>
                            </tr>
                            <tr>
                                <td>Total Sale Invoice</td>
                                <td>:</td>
                                <td>&#2547; <?php echo number_format($totalsale, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="success" style="height: 17px;"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="success" style="height: 17px;"></td>
                            </tr>
                            <tr>
                                <td>Cash Collection</td>
                                <td>:</td>
                                <td>&#2547; <?php echo number_format($collectn, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Previous Cash in Hand</td>
                                <td>:</td>
                                <td>&#2547; <?php echo number_format($cashinhas, 2); ?></td>
                            </tr>
                            <tr>
                                <td>Total Cash out</td>
                                <td>:</td>
                                <td>&#2547; <?php echo number_format($cashoutofday, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="success" style="height: 17px;"></td>
                            </tr>
                            <tr>
                                <td>Current Cash in Hand</td>
                                <td>:</td>
                                <td>&#2547;  <?php echo number_format($totalDay, 2, ".", ","); ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span> Cash out list
                </div>
            </div>
            <div class="widget-body">
                <div class="span6">
                    <table class="table table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Head</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($cashoutlist != FALSE) { foreach($cashoutlist->result() as $cashoutlist) { ?>
                            <tr>
                                <td>Head : 
                                    <?php
                                    if($cashoutlist->co_identifier == 1){    //If the ledger is a medicine order or others ?>
                                        Order No: <a href="<?php echo site_url('order/details/' . $cashoutlist->co_purpose); ?>" target="_blank"><?php echo $cashoutlist->co_purpose; ?></a>
                                    <?php }
                                    elseif($cashoutlist->co_identifier == 2){//If the ledger is a sales return... ?>
                                        Sales Return: <a href="<?php echo site_url('sales/details/' . $cashoutlist->co_purpose); ?>" target="_blank"><?php echo $cashoutlist->co_purpose; ?></a>
                                    <?php }
                                    else{
                                        echo getCashOutPurpose($cashoutlist->co_purpose);
                                    }
                                    ?>
                                </td>
                                <td>&#2547; <?php echo number_format($cashoutlist->co_amount, 2); ?></td>
                            </tr>
                            <?php } } ?>
                            <tr>
                                <td>Total : </td>
                                <td>&#2547; <?php echo number_format($cashoutofday, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="span4">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span> Sales/Invoice Search
                </div>                   
            </div>                
            <div class="widget-body">
                <form class="form-horizontal no-margin">
                    <script>
                        $(function() {
                            $("#starting").datepicker();
                            $("#endingday").datepicker();
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">From</label>
                        <div class="controls">
                            <input type="text" name="starting" id="starting" class="span12" placeholder="Select Starting Date" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="to">To</label>
                        <div class="controls">
                            <input type="text" name="endingday" id="endingday" class="span12" placeholder="Select Ending Date" />
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <label  class="btn btn-info pull-right" id="report_filter" onclick="getFilteredReport()"><i class="icon-search"></i> Find Report</label>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script>
    function getFilteredReport(){
        var starting = $("#starting").val();
        var endingda = $("#endingday").val();
        if(starting == ""){
            alert("You must provide the starting day!!");
            return false;
        }
        else{
            $.ajax({
                type: "POST",
                url: "<?php  echo site_url() . 'settings/filterreport';?>",
                data: {starting:starting, endingday: endingda},
                cache: false,
                beforeSend: function(){
                   $('#report_div').html(
                       '<img src="<?php echo base_url() , 'img/ajaxloader.gif'; ?>" style="margin-left: 20%; margin-top:5%;" />'
                   );
                },
                success: function(html){
                   $("#report_div").html(html);
                }
           });
        }
    }
</script>

