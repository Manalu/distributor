<?php

/**
 * Description of pro_stock_transfer
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php if($pro_list != FALSE) { $sl = 1; foreach($pro_list->result() as $pro_list) {  ?>
<tr>
    <td style="text-align: center;">
        <?php echo $sl; ?>
        <input type="hidden" name="p_id[]" value="<?php echo $pro_list->p_id; ?>" />
        <input type="hidden" name="p_stok[]" value="<?php echo $pro_list->stock; ?>" />
    </td>
    <td><?php echo $pro_list->p_name; ?></td>
    <td><?php echo $pro_list->c_name; ?></td>
    <td><?php echo $pro_list->mg_name; ?></td>
    <td style="text-align: center;">
        <?php
            if($pro_list->stock == NULL){
                echo $box = 0 . '/' . 0;
            } else {
                $box = get_number_of_boxes($pro_list->stock, $pro_list->p_box_qty);
                $rem = get_number_of_remainder($pro_list->stock, $pro_list->p_box_qty);
                echo $box . '/' . $rem;
            } ?>
    </td>
    <td style="text-align: center;">
        <input onkeyup="calculate_product_quantity_stock_transfer('<?php echo $pro_list->p_box_qty; ?>', '<?php echo $pro_list->p_id; ?>')" id="<?php echo 'cart_box_' . $pro_list->p_id; ?>" value="0" autocomplete="off" required="required" style="text-align: center;" type="number" name="cartoon[]" />
    </td>
    <td style="text-align: center;">
        <input onkeyup="calculate_product_quantity_stock_transfer('<?php echo $pro_list->p_box_qty; ?>', '<?php echo $pro_list->p_id; ?>')" id="<?php echo 'cart_pcs_' . $pro_list->p_id; ?>" type="number" name="piece[]" value="0" autocomplete="off" required="required" style="text-align: center;" />
    </td>
    <td style="text-align: center;">
        <input type="number" id="<?php echo 'cart_qty_' . $pro_list->p_id; ?>" max="<?php echo $pro_list->stock; ?>" onfocus="get_focus_out('<?php echo $pro_list->p_id; ?>')" name="qty[]" style="text-align: center;" />
    </td>
</tr>
<?php $sl++; } ?>
<tr>
    <td colspan="7" style="text-align: center;">
        <input type="hidden" name="trigger" value="transfer" />
        <input type="submit" class="btn btn-primary btn-small" value="Transfer Stock" />
    </td>
</tr>
<?php } else { ?>
<tr class="noitemwarning">
    <td colspan="8" style="text-align: center;">
        <?php echo errormessage('No product stock in the chosen branch'); ?>
    </td>
</tr>
<script type="text/javascript">
    $(".noitemwarning").fadeOut(4000);
</script>
<?php } ?>