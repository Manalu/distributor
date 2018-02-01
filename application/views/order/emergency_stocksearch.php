



<?php if($prods != FALSE){foreach ($prods->result() as $prods) { ?>
<tr>
    <td>
        <input type="hidden" name="product_id[]" value="<?php echo $prods->p_id; ?>" />
        <?php echo $prods->p_name; ?>
    </td>
    <td><?php echo $prods->mg_name; ?></td>
    <td class="center-align-text">
        <b>
            <?php
            if($prods->p_stok == NULL){
                echo 0;
            } else {
                $box = get_number_of_boxes($prods->p_stok, $prods->p_box_qty);
                $rem = get_number_of_remainder($prods->p_stok, $prods->p_box_qty);
                echo $box . '/' . $rem;
                //echo $prods->p_stok;
            } ?>
        </b>
    </td>
    <td class="center-align-text vertical-align-mid">
        <?php echo $prods->bxqty; ?>
    </td>
    <td class="center-align-text vertical-align-mid">
        <input type="hidden" name="total[]" id="<?php echo 'cart_qty_' . $prods->p_id; ?>" />
        <input id="<?php echo 'cart_box_' . $prods->p_id; ?>" onkeyup="calculate_cartoon_piece('<?php echo $prods->bxqty; ?>', '<?php echo $prods->p_id; ?>')" name="cartoon[]" value="0" type="number" class="span12 center-align-text" />
    </td>
    <td class="center-align-text vertical-align-mid">
        <input id="<?php echo 'cart_pcs_' . $prods->p_id; ?>" onkeyup="calculate_cartoon_piece('<?php echo $prods->bxqty; ?>', '<?php echo $prods->p_id; ?>')" name="piece[]" value="0" type="number" class="span12 center-align-text" />
    </td>
    <td class="center-align-text vertical-align-mid" id="<?php echo 'total_quantity_' . $prods->p_id; ?>">
    </td>
</tr>
<?php }} else { ?>
<tr>
    <td colspan="6" class="center-align-text" style="color: red;">
        <?php echo errormessage('No Data Found!!'); ?>
    </td>
</tr>
<?php } ?>