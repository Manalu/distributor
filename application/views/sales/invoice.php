


<div class="row-fluid">
    <form action="<?php echo site_url('sales/queue')?>" method="post" id="sales_invoice_form">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">
                        <?php widgetHeader(); ?> Create Invoice
                    </div>
                </div>
                <div class="widget-body" id="notfication_panel">
                    <?php notification(); ?>
                </div>
                <div class="widget-body">
                    <div class="span6 form-inline">
                        <div class="control-group">
                            <label class="control-label">Supplier</label>
                            <div class="controls controls-row">
                                <select class="span12" id="p_cid" name="p_cid" required="required">
                                    <option value="">Select a Supplier</option>
                                    <?php if($sups != FALSE) { foreach ($sups->result() as $sups) { ?>
                                    <option value="<?php echo $sups->c_id; ?>"><?php echo $sups->c_name; ?></option>
                                    <?php } } ?>
                                </select>
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
                        <input type="button" class="btn btn-success" name="getmedzstock" id="getmedzstock" value="Get Product List" />
                        <a href="<?php echo site_url('sales/invoice'); ?>" class="btn btn-danger">Restart Invoice</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget-body">
                    <table class="table table-condensed table-striped table-hover table-bordered pull-left">
                        <thead>
                            <tr>
                                <th class="center-align-text" style="width:5%;">
                                    <!--<input id="select-all" type="checkbox" />-->
                                    SL.
                                </th>
                                <th style="width: 17%;">Product</th>
                                <!--<th style="width: 5%;">Group</th>-->
                                <th style="width: 9%;" class="center-align-text">Stock</th>
                                <th style="width: 9%;" class="center-align-text">Box</th>
                                <th style="width: 9%;" class="center-align-text">Cartoon</th>
                                <th style="width: 8%;" class="center-align-text">Piece</th>
                                <th style="width: 8%;" class="center-align-text">Bonus</th>
                                <th style="width: 6%;" class="center-align-text">Total</th>
                                <th style="width: 10%;" class="center-align-text">Rate</th>
                                <th style="width: 10%; text-align: right;">Price</th>
                                <th style="width: 9%;" class="center-align-text">Add</th>
                            </tr>
                        </thead>
                        <tbody id="medtable">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11" class="center-align-text">
                                    <button type="submit" class="btn btn-info" id="create_invoicee">Continue </button>
                                    <!--<button data-dismiss="alert" style="margin-bottom: 0px;" class="close" type="button" onclick="remove_cart_item()"> × </button>-->
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden" name="trigger" value="sales/invoice" />
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $("#getmedzstock").click(function(){
        var supplier = $("#p_cid").val();
        if(supplier.length > 0){
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sales/stocksearch'); ?>",
                data: { sup: supplier, branchs: "<?php echo $b_id; ?>" },
                cache: false,
                beforeSend: function(){
                    $('#medtable').html(
                    '<tr><td colspan="11" class="center-align-text"><img src="<?php echo base_url(); ?>/img/ajaxloader.gif" style="" /></td></tr>'
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
    
    $("#create_invoice").click(function(){
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

    function calculate_cart_item_price(price, id){  return true;
//        var quantity    = $("#cart_qty_"+id).val();
//        var unitprce    = $("#cart_prc_"+id).val();
//        var itemprice   = (unitprce * quantity);
//        $("#price_label_"+id).html("<?php // echo bdt(); ?> " + itemprice.toFixed(2));
//        $("#cart_price_"+id).val(itemprice);
    }

    function add_to_cart(branch, date, company, product, group, name, price, available_box, cartoon_size){
        var customer    = $("#customer").val();
        if(customer.length < 1){
            alert("Please select a DSR/Customer");
            return false;
        }
        
        var cartoon     = parseInt($("#cart_box_" + product).val());
        var pieceq      = parseInt($("#cart_pcs_" + product).val());
        
        if(cartoon > available_box){
            alert("Cartoon size should be less then available Cartoon in stock.");
            return false;
        }
        if(pieceq > cartoon_size){
            alert("Piece amount should be less Cartoon Size of the product.");
            return false;
        }
        var quantity    = $("#cart_qty_"+product).val();    quantity  = parseInt(quantity);
        var itmbonus    = $("#cart_bns_"+product).val();    itmbonus  = parseInt(itmbonus);
        var itemprice   = $("#cart_price_"+product).val();  itemprice = parseFloat(itemprice);
        var unitrate    = $("#cart_prc_" + product).val();  unitrate  = parseFloat(unitrate);
        
        if(itemprice < 1){
            alert("You can not add this item into cart");
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales/add_to_cart'); ?>",
            data: { branch: branch, date: date, company: company, product: product, group: group, cartoon: cartoon, piece: pieceq, bonusqty: itmbonus, quantity: quantity, unitrate: unitrate, itemprice: itemprice, price: price, name: name, customer: customer },
            cache: false,
            beforeSend: function(){
                $("#cartbtn_label_"+product).html(
                '<img src="<?php echo base_url(); ?>/img/loading-orange.gif" style="" />'
                );
            },
            success: function(html){
                $("#cartbtn_label_"+product).html(html)
            } 
       });
    }

    function remove_cart_item(cart_id, branch, date, company, product, group, name, price, available_box, cartoon_size){
        var pric    = $("#cart_prc_" + product).val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('sales/remove_from_cart'); ?>",
            data: { cart_id: cart_id, branch: branch, date: date, company: company, product: product, group: group, available_box: available_box, cartoon_size: cartoon_size, price: pric, name: name },
            cache: false,
            beforeSend: function(){
                $("#cartbtn_label_" + product).html('<img src="<?php echo base_url(); ?>/img/loading-orange.gif" style="" />');
            },
            success: function(html){
                $("#cartbtn_label_" + product).html(html)
            } 
        });
    }
    
    function total_quantity(proid){
        var quantity    = parseInt($("#cart_qty_" + proid).val());
        var bonusqty    = parseInt($("#cart_bns_" + proid).val());
        var totalqty    = quantity + bonusqty;
        $("#total_quantity_" + proid).html(totalqty);
    }
    
    function calculate_cartoon_piece(boxqty, proid, bonus){
        var cartoon     = parseInt($("#cart_box_" + proid).val());
        $("#cart_bns_" + proid).val(bonus * cartoon);
        var pieceq      = parseInt($("#cart_pcs_" + proid).val());
        var bonusq      = parseInt($("#cart_bns_" + proid).val());
        if(isNaN(cartoon)){ cartoon = 0; }
        if(isNaN(pieceq)){ pieceq = 0; }
        if(isNaN(bonusq)){ bonusq = 0; }
        var totalqty    = (cartoon * boxqty) + pieceq + bonusq;
        var bonusless   = (cartoon * boxqty) + pieceq;
        $("#total_quantity_" + proid).html(totalqty);
        $("#cart_qty_" + proid).val(totalqty);
        
        var quantity    = $("#cart_qty_" + proid).val();
        var unitprce    = $("#cart_prc_" + proid).val();
        var itemprice   = (unitprce * bonusless);
        $("#price_label_" + proid).html("<?php echo bdt(); ?> " + itemprice.toFixed(2));
        $("#cart_price_" + proid).val(itemprice);
    }
    
    function calculate_bonus_piece(boxqty, proid){
        var cartoon     = parseInt($("#cart_box_" + proid).val());
        var pieceq      = parseInt($("#cart_pcs_" + proid).val());
        var bonusq      = parseInt($("#cart_bns_" + proid).val());
        if(isNaN(cartoon)){ cartoon = 0; }
        if(isNaN(pieceq)){ pieceq = 0; }
        if(isNaN(bonusq)){ bonusq = 0; }
        var totalqty    = (cartoon * boxqty) + pieceq + bonusq;
        $("#total_quantity_" + proid).html(totalqty);
        $("#cart_qty_" + proid).val(totalqty);
        
        var quantity    = $("#cart_qty_" + proid).val();
        var unitprce    = $("#cart_prc_" + proid).val();
        var itemprice   = (unitprce * (quantity - bonusq));
        $("#price_label_" + proid).html("<?php echo bdt(); ?> " + itemprice.toFixed(2));
        $("#cart_price_" + proid).val(itemprice);
        total_price();
    }
</script>
