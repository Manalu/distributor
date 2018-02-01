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
<?php if($product->p_tid == 1) { ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#p_box_qty").css("display", "none");
    });
</script>
<?php } else if($product->p_tid == 2) { ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#p_box_qty").css("display", "block");
    });
</script>
<?php } ?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Update Product Setup
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
                <form action="<?php echo site_url('products/update') ?>" class="form-horizontal" method="POST">
                    <div class="control-group">
                        <label class="control-label"> Name</label>
                        <div class="controls controls-row">
                            <input type="text" class="span12" name="p_name" value="<?php echo $product->p_name; ?>" autocomplete="off" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Supplier</label>
                        <div class="controls controls-row">
                            <select class="span12" name="p_cid" required="required">
                                <option value="">Select Product Supplier</option>
                                <?php if($supplier != FALSE) { foreach($supplier->result() as $supplier) {  ?>
                                <option value="<?php echo $supplier->c_id; ?>" <?php if($supplier->c_id == $product->p_cid) { echo 'selected'; } ?>>
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
                                <option value="<?php echo $groups->mg_id; ?>" <?php if($groups->mg_id == $product->p_gid) { echo 'selected'; } ?>>
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
                                <option value="">Select Product Type</option>
                                <?php if($types != FALSE) { foreach($types->result() as $types) {  ?>
                                <option value="<?php echo $types->mt_id; ?>" <?php if($types->mt_id == $product->p_tid) { echo 'selected'; } ?>>
                                    <?php echo $types->mt_name; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group" id="p_box_qty">
                        <label class="control-label" style="color: red;"> Cartoon Qty</label>
                        <div class="controls controls-row">
                            <input type="number" class="span12" name="p_box_qty" id="p_box_qty_input" value="<?php echo $product->p_box_qty; ?>" autocomplete="off" style="color: red;" />
                        </div>
                    </div>
                    <script type="text/javascript">
                        $("#p_tid").change(function(){
                            var val = $("#p_tid").val();
                            if(val == 2){
                                $("#p_box_qty").css("display", "block");
                            } else {
                                $("#p_box_qty_input").attr("value", 1);
                                $("#p_box_qty").css("display", "none");
                            }
                        });
                    </script>
                    <div class="control-group">
                        <label class="control-label"> Minimum Qty</label>
                        <div class="controls controls-row">
                            <?php if($product->p_tid == 2) {
                            $mini = ($product->p_min_qty / $product->p_box_qty);
                            } else if($product->p_tid == 1) {
                            $mini = $product->p_min_qty;
                            } ?>
                            <input type="number" class="span12" name="p_min_qty" value="<?php echo $mini; ?>" autocomplete="off" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Bonus Qty</label>
                        <div class="controls controls-row">
                            <input type="number" value="<?php echo $product->p_box_bonus; ?>" step="any" class="span12" name="p_box_bonus" placeholder="Product Bonus Per Cartoon" autocomplete="off" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Sale</label>
                        <div class="controls controls-row">
                            <?php if($product->p_tid == 2) {
                            $sale = ($product->p_u_price * $product->p_box_qty);
                            } else if($product->p_tid == 1) {
                            $sale = $product->p_u_price;
                            } ?>
                            <input type="number" class="span12" name="p_u_price" value="<?php echo $sale; ?>" autocomplete="off" step="any" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Purchase</label>
                        <div class="controls controls-row">
                            <?php if($product->p_tid == 2) {
                            $purchase = ($product->p_purchse_price * $product->p_box_qty);
                            } else if($product->p_tid == 1) {
                            $purchase = $product->p_purchse_price;
                            } ?>
                            <input type="number" class="span12" name="p_purchse_price" value="<?php echo $purchase; ?>" autocomplete="off" required step="any" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Stock Price</label>
                        <div class="controls controls-row">
                            <?php if($product->p_tid == 2) {
                            $stockPrice = ($product->p_stock_price * $product->p_box_qty);
                            } else if($product->p_tid == 1) {
                            $stockPrice = $product->p_stock_price;
                            } ?>
                            <input type="number" class="span12" name="p_stock_price" value="<?php echo $stockPrice; ?>" autocomplete="off" required step="any" />
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="trigger" value="update_product_setup" />
                        <input type="hidden" name="p_id" value="<?php echo $product->p_id; ?>" />
                        <a href="<?php echo site_url('products/list'); ?>" class="btn btn-default">Back To List</a>
                        <a href="<?php echo site_url('products/delete?product=' . $product->p_id . '&merge=' . md5(date('Ymdhis')) . '&supplier=' . $product->c_name . '&group=' . $product->mg_name); ?>" class="btn btn-danger" onclick="return confirm('Are you sure??')">Delete SKU</a>
                        <button type="submit" class="btn btn-info">Update Product</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>