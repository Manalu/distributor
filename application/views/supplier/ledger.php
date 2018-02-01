<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> <?php echo $c_name; ?> Statement for Credit Deposit & Purchase Adjustment
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <div class="span4 form-inline">
                    <script>
                        $(function() {
                            $("#sales_date_start").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date("Y-m-d"); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">From</label>
                        <div class="controls">
                            <input name="sales_date_start" id="sales_date_start" class="span12" readonly="readonly" type="text" value="<?php echo date('Y-m-01') ?>" />
                        </div>
                    </div>
                </div>
                <div class="span4 form-inline">
                    <script>
                        $(function() {
                            $("#sales_date_end").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: '<?php echo date("Y-m-d"); ?>'});
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label" for="from">To</label>
                        <div class="controls">
                            <input name="sales_date_end" id="sales_date_end" class="span12" readonly="readonly" type="text" value="<?php echo date('Y-m-d') ?>" />
                        </div>
                    </div>
                </div>
                <div class="span4 form-inline">
                    <div class="control-group">
                        <label class="control-label" for="group">Head </label>
                        <div class="controls controls-row">
                            <select id="status" class="span12" name="status">
                                <option value="">Ledger Head...</option>
                                <?php foreach($purpoz->result() as $purpoz) { ?>
                                <option value="<?php echo $purpoz->tble_id; ?>"><?php echo $purpoz->ledger; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="span12 center-align-text">
                    <button type="button" class="btn btn-primary" id="ledger_search_button">Search </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <div class="widget-body">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">SL.</th>
                                <th style="text-align: center; width: 15%;">Date</th>
                                <th style="text-align: left; width: 20%;">Ledger</th>
                                <th style="text-align: left; width: 20%;">Notes</th>
                                <th style="text-align: right; width: 20%;">Adjustment</th>
                                <th style="text-align: right; width: 20%;">Deposit</th>
                            </tr>
                        </thead>
                        <tbody id="ledger_table">
                            <?php if($credit_voucher != FALSE) { $sl = 1; $adjust = 0; $deposit = 0; foreach($credit_voucher->result() as $voucher) { ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $sl; ?></td>
                                <td style="text-align: center;"><?php echo date_format(date_create($voucher->adjust_date), 'd-M-Y'); ?></td>
                                <td style="text-align: left;"><?php echo $voucher->LedgerText; ?></td>
                                <td style="text-align: left;">
                                    <?php echo $voucher->notes; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php if($voucher->ledger == 1) { $adjust = $adjust + $voucher->amount;
                                    echo bdt() . number_format($voucher->amount, 2, ".", ",");
                                    } else {
                                    echo bdt() . number_format(0, 2, ".", ",");
                                    } ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php if($voucher->ledger == 2 || $voucher->ledger == 3 || $voucher->ledger == 4 || $voucher->ledger == 7 || $voucher->ledger == 8 || $voucher->ledger == 6 || $voucher->ledger == 5) {
                                    $deposit = $deposit + $voucher->amount;    
                                    echo bdt() . number_format($voucher->amount, 2, ".", ",");    
                                    } else {
                                    echo bdt() . number_format(0, 2, ".", ",");
                                    } ?>
                                </td>
                            </tr>
                            <?php $sl++; } ?>
                            <tr>
                                <th colspan="5" style="text-align: right;">
                                <?php 
                                echo bdt() . number_format($adjust, 2, ".", ",");
                                ?>    
                                </th>
                                <th colspan="1" style="text-align: right;">
                                <?php 
                                echo bdt() . number_format($deposit, 2, ".", ",");
                                ?>    
                                </th>
                            </tr>
                            <?php } else { ?>
                            <tr>
                                <td style="text-align: center;" colspan="6">
                                    <?php echo errormessage('No data found!!') ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php include 'application/views/common/marketing.php'; ?>
            </div>
            <?php include 'application/views/common/printer.php'; ?>
            <div class="widget-body center-align-text">
                <a href="<?php echo site_url('supplier/supplierlist'); ?>" class="btn btn-default">Back to List</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#ledger_search_button").click(function(){
        var supplier    = "<?php echo $supplier_id; ?>";
        var starting    = $("#sales_date_start").val();
        var endngday    = $("#sales_date_end").val();
        var ledger      = $("#status").val();
        if(ledger === ""){
            alert("Please select a ledger head");
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?php  echo site_url('supplier/ledger_search'); ?>",
            data: {supplier: supplier, starting: starting, endngday: endngday, ledger: ledger},
            cache: false,
            beforeSend: function(){
               $('#ledger_table').html(
                   '<tr><td colspan="6" style="text-align: center;"><img src="<?php echo base_url() , 'img/ajaxloader.gif'; ?>" /></td></tr>'
               );
            },
            success: function(html){
               $("#ledger_table").html(html);
            }
       });
    });
</script>