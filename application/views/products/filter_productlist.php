<?php

/**
 * Description of filter_productlist
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
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
        <?php echo intval($products->p_stok); ?>
    </td>
    <td style="text-align: center;">
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
<?php $sl++; } } else { ?>
<tr>
    <?php if($role == 3) { ?>
    <td style="text-align: center;" colspan="11">
    <?php } else { ?>
    <td style="text-align: center;" colspan="10">
    <?php } ?>
        <?php echo errormessage('No Data Found!!'); ?>
    </td>
</tr>
<?php } ?>
