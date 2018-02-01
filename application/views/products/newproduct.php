<?php

/**
 * Description of newproduct
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#p_box_qty").css("display", "none");
    });
</script>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> New Product Setup
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
                <form action="<?php echo site_url('products/new') ?>" class="form-horizontal" method="POST">
                    <div class="control-group">
                        <label class="control-label"> Name</label>
                        <div class="controls controls-row">
                            <input type="text" class="span12" name="p_name" placeholder="Product Name" autocomplete="on" autofocus required />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Supplier</label>
                        <div class="controls controls-row">
                            <select class="span12" name="p_cid" required="required">
                                <option value="">Select Supplier</option>
                                <?php if($supplier != FALSE) { foreach($supplier->result() as $supplier) {  ?>
                                <option value="<?php echo $supplier->c_id; ?>">
                                    <?php echo $supplier->c_name; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Group</label>
                        <div class="controls controls-row">
                            <select class="span12" name="p_gid" required="required">
                                <option value="">Select Product Group</option>
                                <?php if($groups != FALSE) { foreach($groups->result() as $groups) {  ?>
                                <option value="<?php echo $groups->mg_id; ?>">
                                    <?php echo $groups->mg_name; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Type</label>
                        <div class="controls controls-row">
                            <select class="span12" name="p_tid" id="p_tid" required="required">
                                <option value="">Select Type</option>
                                <?php if($types != FALSE) { foreach($types->result() as $types) {  ?>
                                <option value="<?php echo $types->mt_id; ?>">
                                    <?php echo $types->mt_name; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $("#p_tid").change(function(){
                            var val = $("#p_tid").val();
                            if(val == 2){
                                $("#p_box_qty").css("display", "block");
                            } else {
                                $("#p_box_qty").css("display", "none");
                            }
                        });
                    </script>
                    <div class="control-group" id="p_box_qty">
                        <label class="control-label" style="color: red;"> Cartoon Qty</label>
                        <div class="controls controls-row">
                            <input type="number" class="span12" name="p_box_qty" placeholder="Quantity in Cartoon" autocomplete="off" style="color: red;" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Minimum Qty</label>
                        <div class="controls controls-row">
                            <input type="number" class="span12" name="p_min_qty" placeholder="Product Minimum Quantity" autocomplete="off" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Bonus Qty</label>
                        <div class="controls controls-row">
                            <input type="number" class="span12" name="p_box_bonus" placeholder="Product Bonus Per Cartoon" autocomplete="off" value="0" step="any" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Sale</label>
                        <div class="controls controls-row">
                            <input type="number" class="span12" name="p_u_price" placeholder="Product Sale Price" autocomplete="off" required step="any" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Purchase</label>
                        <div class="controls controls-row">
                            <input type="number" class="span12" name="p_purchse_price" placeholder="Product Purchase Price" autocomplete="off" required step="any" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Stock Price</label>
                        <div class="controls controls-row">
                            <input type="number" class="span12" name="p_stock_price" placeholder="Product Stock Price" autocomplete="off" required step="any" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Opening Stock</label>
                        <div class="controls controls-row">
                            <input type="number" class="span12" name="stock" value="0" autocomplete="off" required="required" step="any" />
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="trigger" value="add_new_product" />
                        <button type="submit" class="btn btn-info">Create Product</button>
                        <a href="<?php echo site_url('products/list'); ?>" class="btn btn-default">Back to List</a>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>