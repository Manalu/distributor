<?php

/**
 * Description of invoice_transfer
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Transfer Invoice to DSR/Clients
                </div>
            </div>
            <div class="widget-body">
                <div class="span4 form-inline">
                    <div class="control-group">
                        <label class="control-label">Invoice No.</label>
                        <div class="controls controls-row">
                            <input name="invoice" id="invoice" class="span12" placeholder="Invoice No." type="text" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="span2 form-inline">
                    <div class="control-group">
                        <label class="control-label">Search Invoice</label>
                        <div class="controls controls-row">
                            <button id="invoiceno" class="span12 btn-primary" type="button"> <i class="icon-search"></i> Search</button>
                        </div>
                    </div>
                </div>
                <div class="span2 form-inline">
                    <div class="control-group">
                        <label class="control-label">Type</label>
                        <div class="controls controls-row">
                            <select name="cl_type" required="required" id="cl_type" class="span12">
                                <option value="">Select Type</option>
                                <option value="1">Customer</option>
                                <option value="2">DSR</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span4 form-inline" id="customer_dsr">
                </div>
                <div class="clearfix"></div>
                <div class="span12 center-align-text">
                    <button type="button" class="btn btn-success" id="invoice_search_button"> Transfer </button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="center-align-text" id="transdet">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#cl_type").change(function(){
        var type = $("#cl_type").val();
        if(type.length > 0){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sales/get_invoice_customer'); ?>",
                data: { type: type},
                cache: false,
                beforeSend: function(){
                    $('#customer_dsr').html(
                    '<img src="<?php echo base_url(); ?>/img/loading-orange.gif" style="text-align: center;" />'
                    );
                },
                success: function(html){
                    $("#customer_dsr").html(html);
                } 
           });
        } else {
            alert("Please select a customer/dsr type");
            return false;
        }
    });
    $("#invoiceno").click(function(){
        var invno = $("#invoice").val();
        if(invno.length > 0){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sales/transdet'); ?>",
                data: { invoice: invno},
                cache: false,
                beforeSend: function(){
                    $('#transdet').html('<img src="<?php echo base_url(); ?>/img/ajaxloader.gif" style="text-align: center;" />');
                },
                success: function(html){
                    $("#transdet").html(html);
                } 
           });
        } else {
            alert("Please provide an invoice number");
            return false;
        }
    });
</script>