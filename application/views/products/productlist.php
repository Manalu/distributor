<?php

/**
 * Description of productlist
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
                    <?php widgetHeader(); ?> Products List
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="clearfix"></div>
            <div class="widget-body">
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls controls-row">
                            <input name="p_name" id="p_name" class="span12" placeholder="Product Name" type="text" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">Supplier</label>
                        <div class="controls controls-row">
                            <select class="span12" id="p_cid" name="p_cid">
                                <option value="">Select a Supplier</option>
                                <?php if($sups != FALSE) { foreach ($sups->result() as $sups) { ?>
                                <option value="<?php echo $sups->c_id; ?>"><?php echo $sups->c_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">Group</label>
                        <div class="controls controls-row">
                            <select class="span12" name="p_gid" id="p_gid">
                                <option value="">Select Product Group</option>
                                <?php if($groups != FALSE) { foreach($groups->result() as $groups) {  ?>
                                <option value="<?php echo $groups->mg_id; ?>">
                                    <?php echo $groups->mg_name; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">Status</label>
                        <div class="controls controls-row">
                            <select class="span12" id="p_status">
                                <option value="">Product Status</option>
                                <option value="1">Active</option>
                                <option value="2">Deleted</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="span12 center-align-text">
                    <button type="button" class="btn btn-primary" id="purchase_order_search_button">Search Product Information</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body" id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%;">SL.</th>
                            <th style="width: 15%">Name</th>
                            <th style="width: 10%;">Group</th>
                            <th style="width: 15%;">Supplier</th>
                            <th style="width: 10%; text-align: center;">Box</th>
                            <th style="width: 5%; text-align: center;">Bonus</th>
                            <th style="width: 10%; text-align: right;">Sale</th>
                            <th style="width: 10%; text-align: right;">Purchase</th>
                            <th style="width: 10%; text-align: center;">Stock</th>
                            <th style="width: 5%; text-align: center;" class="noprint">View</th>
                            <?php if($role == 3) { ?>
                            <th style="width: 5%; text-align: center;" class="noprint">Edit</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="filtered_order_table">
                        <?php if($products != FALSE) { $sl = 1; foreach($products->result() as $products) {  ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $sl; ?></td>
                            <td><?php echo $products->p_name; ?></td>
                            <td><?php echo $products->mg_name; ?></td>
                            <td><?php echo $products->c_name; ?></td>
                            <td style="text-align: center;"><?php echo $products->p_box_qty; ?></td>
                            <td style="text-align: center;"><?php echo $products->p_box_bonus; ?></td>
                            <td style="text-align: right;"><?php echo bdt() . number_format($products->p_box_qty * $products->p_u_price, 2, ".", ","); ?></td>
                            <td style="text-align: right;"><?php echo bdt() . number_format($products->p_box_qty * $products->p_purchse_price, 2, ".", ","); ?></td>
                            <td style="text-align: center;" data-title="Total Stock">
                                <?php echo $products->p_stok; ?>
                            </td>
                            <td style="text-align: center;">
                                <!--<a href="<?php //echo site_url('order/stock?product=' . $products->p_id . '&merge=' . md5(date('Ymdhis')) . '&supplier=' . $products->c_name . '&group=' . $products->mg_name); ?>">-->
                                <a href="#stockModal" role="button" data-toggle="modal" data-original-title="" onclick="get_pro_stock('<?php echo $products->p_id; ?>')">
                                    <i class="icon-storage"></i>
                                </a>
                            </td>
                            <?php if($role == 3) { ?>
                            <td style="text-align: center;" class="noprint">
                                <a href="<?php echo site_url('products/update?product=' . $products->p_id . '&merge=' . md5(date('Ymdhis')) . '&supplier=' . $products->c_name . '&group=' . $products->mg_name); ?>">
                                    <i class="icon-edit"></i>
                                </a>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php $sl++; } } ?>
                    </tbody>
                </table>
                <div class="clearfix"></div>
                <?php include 'application/views/common/marketing.php'; ?>
            </div>
            <?php include 'application/views/common/printer.php'; ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div id="stockModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="myModalLabel"> Branch Wise Stock Report</h4>
    </div>
    <div class="modal-body"></div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"> Close </button>
    </div>
</div>
<script type="text/javascript">
    $("#purchase_order_search_button").click(function(){
        var name         = $("#p_name").val();
        var cid         = $("#p_cid").val();
        var gid         = $("#p_gid").val();
        var stat        = $("#p_status").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('products/filter_productlist'); ?>",
            data: {name: name, cid: cid, gid: gid, stat: stat},
            cache: false,
            beforeSend: function(){
              $('#filtered_order_table').html(
                  '<tr><td colspan="11" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
              );
           },
            success: function(html){
                $("#filtered_order_table").html(html);
             },
             error:function(html){
                 $("#filtered_order_table").html(html.responseText);
             }
        });
    });
    
    function get_pro_stock(proid){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('products/stock_report'); ?>",
            data: {proid: proid},
            cache: false,
            beforeSend: function(){
              $('.modal-body').html(
                  '<img src="<?php echo $img . 'ajaxloader.gif'; ?>" style="text-align: center;" />'
              );
            },
            success: function(html){
                $(".modal-body").html(html);
            },
            error:function(html){
                $(".modal-body").html(html.responseText);
            }
        });
    }
</script>