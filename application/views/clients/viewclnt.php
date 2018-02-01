


<div class="row-fluid">
    <div class="span8">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Customer Ledger
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
                <div id="printable">
                    <div class="span12" id="headerInfo">
                        <h4><?php echo $ShopName; ?></h4>
                        <p id="addressStamp"></p>
                        <p id="timeStamp"></p>
                    </div>
                    <script type="text/javascript">
                        $("#headerInfo").css("display", "none");
                    </script>
                    <div class="invoice" id="invoice">
                        <div class="row-fluid">
                            <div class="span12">
                                <h4><?php echo $cl_name; ?> <small><?php echo $cl_phone; ?></small></h4>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span4 btn-success center-align-text">
                                <p>Total Sales</p>
                                <h3>&#2547; <?php echo number_format(getTotalAmountSoldToClientByClientId($clid), 2, ".", ","); ?></h3>
                            </div>
                            <div class="span4 btn-warning center-align-text">
                                <p>Total Invoices</p>
                                <h3><?php echo getTotalNumberOfInvoiceSoldToClientByClientId($clid); ?></h3>
                            </div>
                            <div class="span4 btn-danger center-align-text">
                                <p>Outstanding</p>
                                <h3 id="total_outstanding"><i class="icon-spinner-3"></i></h3>
                            </div>
                        </div>
                    </div>
                    <table class="table table-condensed table-striped table-bordered table-hover no-margin">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Invoice</th>
                                <th style="width: 20%;">Salesman</th>
                                <th style="width: 5%;" class="center-align-text">Item</th>
                                <th style="width: 15%; text-align: right;">Billed</th>
                                <th style="width: 15%; text-align: right;">Paid</th>
                                <th style="width: 15%; text-align: right;">Outstanding</th>
                                <th style="width: 5%;" class="center-align-text noprint">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($invoices != FALSE) { $TotalBilled = 0; $TotalPaid = 0; $TotalDue = 0; foreach ($invoices->result() as $invoices) { ?>
                            <tr>
                                <td>
                                    <a href="<?php echo site_url('sales/details/' . $invoices->InvoiceId); ?>" title="Click to view full invoice details">
                                        <?php echo date_format(date_create($invoices->Date), "d-M-Y"); ?>
                                    </a>
                                </td>
                                
                                <td>
                                    <?php echo $invoices->Salesman; ?>
                                </td>
                                <td class="center-align-text">
                                    <?php echo $invoices->Item; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php $TotalBilled = $TotalBilled + $invoices->Amount; ?>
                                    <?php echo bdt() . number_format($invoices->Amount, 2, ".", ","); ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php $TotalPaid = $TotalPaid + $invoices->Paid; ?>
                                    <?php echo bdt() . number_format($invoices->Paid, 2, ".", ","); ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php $TotalDue = $TotalDue + ($invoices->Amount - $invoices->Paid); ?>
                                    <?php echo bdt() . number_format(($invoices->Amount - $invoices->Paid), 2, '.', ','); ?>
                                </td>
                                <td class="center-align-text noprint">
                                    <a title="View Details" style="cursor: pointer;" onclick="viewDetailedInvoice('<?php echo $invoices->InvoiceId; ?>', '<?php echo $clid; ?>', '<?php echo 1; ?>')">
                                        <i class="icon-zoom-in"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align: right;" colspan="3">Total</th>
                                <th style="text-align: right;">
                                    &#2547; <?php echo number_format($TotalBilled, 2, ".", ","); ?>
                                </th>
                                <th style="text-align: right;">
                                    &#2547; <?php echo number_format($TotalPaid, 2, ".", ","); ?>
                                </th>
                                <th style="text-align: right;">
                                    &#2547; <?php echo number_format($TotalDue, 2, ".", ","); ?>
                                </th>
                                <th colspan="1" class="noprint"></th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="clearfix"></div>
                    <footer class="footer" id="marketing">
                        <span class="center-align-text">
                            2017 &copy; All rights reserved to <?php echo $ShopName; ?>. CAPSOL A Product of -  e<span style="color: #F00;">X</span>ploria Solutions Ltd.
                        </span>
                    </footer>
                    <script type="text/javascript">
                        $("#marketing").css("display", "none");
                    </script>
                </div>
                <style type="text/css">
                    @media print {
                        a[href]:after {
                          content: none !important;
                        }
                        .noprint{display: none !important; }
                    }
                </style>
                <div class="span12" style="text-align: center;">
                    <button class="btn btn-primary" id="printer">Take a Print Out</button>
                </div>
                <script type="text/javascript">
                    $("#printer").click(function(){
                        $("#headerInfo").css("display", "block");
                        $("#timeStamp").html("<?php echo '<b>' . $cl_name . ' - Ledger<br />' . $cl_addrs . '<br>'. $cl_phone .'</b><br />Print Date: ' . date("d, M Y - H:i:s A"); ?>");
                        $("#addressStamp").html("<?php echo 'Address: ' . $ShopAdrs; ?>");
                        $("#marketing").css("display", "block");
                        $("#invoice").css("display", "none");
                        $("#printable").print();
                        $("#invoice").css("display", "block");
                        $("#headerInfo").css("display", "none");
                        $("#marketing").css("display", "none");
                    });
                </script>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Sales Information
                </div>
            </div>
            <div class="widget-body" id="invoicedetails">
                
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#total_outstanding").html("<?php echo bdt() . number_format($TotalDue, 2, '.', ','); ?>");
    });
    function viewDetailedInvoice(invoiceid, client, invtype){
        jQuery .ajax({
            type: "POST",
            url: "<?php echo site_url('clients/invoicedetails'); ?>",
            data: { invid: invoiceid, cl_id: client, invtype: invtype },
            cache: false,
            beforeSend: function(){
                $('#invoicedetails').html(
                '<img src="<?php echo base_url(); ?>/img/ajaxloader.gif" style="margin-left: 4%; margin-top:5%;" />'
            );
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.Message());
            },
            success: function(html){
              $("#invoicedetails").html(html);
            } 
       });
    }
</script>