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
<?php if($products != FALSE) { $total = 0; $sl = 1; foreach($products->result() as $products) {  ?>
<tr>
    <td style="text-align: center;"><?php echo $sl; ?></td>
    <td><?php echo $products->p_name; ?></td>
    <td><?php echo $products->mg_name; ?></td>
    <td><?php echo $products->c_name; ?></td>
    <td style="text-align: center;" data-title="Total Stock">
        <?php echo get_number_of_boxes($products->p_stok, $products->p_box_qty); ?>
    </td>
    <td style="text-align: center;" data-title="Total Stock">
        <?php echo get_number_of_remainder($products->p_stok, $products->p_box_qty); ?>
    </td>
    <td style="text-align: right;">
        <?php $total = $total + ($products->p_stok * $products->p_stock_price); ?>
        <?php echo bdt() . number_format($products->p_stok * $products->p_stock_price, 2, ".", ","); ?>
    </td>
</tr>
<?php $sl++; } ?>
<tr>
    <th colspan="6" style="text-align: right;">Total</th>
    <th style="text-align: right;"><?php echo bdt() . number_format($total, 2, ".", ","); ?></th>
</tr>
<?php } else { ?>
<tr>
    <td style="text-align: center;" colspan="7">
        <?php echo errormessage('No Data Found!!'); ?>
    </td>
</tr>
<?php } ?>
