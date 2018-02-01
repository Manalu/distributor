



<?php if($prods != FALSE){ $sl = 1; foreach ($prods->result() as $prods) { ?>
<tr>
    <td style="width: 5%; text-align: center;" class="vertical-align-mid">
        <?php echo $sl; ?>
    </td>
    <td class="vertical-align-mid"><?php echo $prods->p_name; ?></td>
    <!--<td class="vertical-align-mid"><?php // echo $prods->mg_name; ?></td>-->
    <td class="center-align-text vertical-align-mid">
        <b>
            <?php
            if($prods->p_stok == NULL){
                echo $box = 0 . '/' . 0 . '/' . 0;
            } else {
                $box = get_number_of_boxes($prods->p_stok, $prods->p_box_qty);
                $rem = get_number_of_remainder($prods->p_stok, $prods->p_box_qty);
                echo $box . '/' . $rem . '/' . $prods->p_box_bonus;
            } ?>
        </b>
    </td>
    <td class="center-align-text vertical-align-mid">
        <?php echo $prods->p_box_qty; ?>
    </td>
    <td class="center-align-text vertical-align-mid">
        <input type="hidden" name="cart_price[]" id="<?php echo 'cart_price_' . $prods->p_id; ?>" value="0" />
        <input type="hidden" name="quantity[]" id="<?php echo 'cart_qty_' . $prods->p_id; ?>" />
        <input max="<?php echo $box; ?>" id="<?php echo 'cart_box_' . $prods->p_id; ?>"
        onkeyup="calculate_cartoon_piece('<?php echo $prods->p_box_qty; ?>', '<?php echo $prods->p_id; ?>', '<?php echo $prods->p_box_bonus; ?>'), calculate_cart_item_price('<?php echo $prods->p_u_price; ?>', '<?php echo $prods->p_id; ?>')"
        type="number" class="span12" name="cartoon[]" style="text-align: center;" value="0" />
    </td>
    <td class="center-align-text vertical-align-mid">
        <input onkeyup="calculate_cartoon_piece('<?php echo $prods->p_box_qty; ?>', '<?php echo $prods->p_id; ?>', '<?php echo $prods->p_box_bonus; ?>'), calculate_cart_item_price('<?php echo $prods->p_u_price; ?>', '<?php echo $prods->p_id; ?>')" max="<?php echo ($prods->p_box_qty - 1); ?>" id="<?php echo 'cart_pcs_' . $prods->p_id; ?>" type="number" class="span12" name="piece[]" style="text-align: center;" value="0" />
    </td>
    <td class="center-align-text vertical-align-mid">
        <input onkeyup="calculate_bonus_piece('<?php echo $prods->p_box_qty; ?>', '<?php echo $prods->p_id; ?>', '<?php echo $prods->p_box_bonus; ?>')"
               max="<?php echo $prods->p_stok; ?>" id="<?php echo 'cart_bns_' . $prods->p_id; ?>"
               type="number" class="span12" name="bonus[]" style="text-align: center;" value="0" step="any" />
    </td>
    <td class="center-align-text vertical-align-mid" id="<?php echo 'total_quantity_' . $prods->p_id; ?>">
        
    </td>
    <td class="center-align-text vertical-align-mid">
        <input value="<?php echo $prods->p_u_price; ?>" onkeyup="calculate_cartoon_piece('<?php echo $prods->p_box_qty; ?>', '<?php echo $prods->p_id; ?>', '<?php echo $prods->p_box_bonus; ?>')" id="<?php echo 'cart_prc_' . $prods->p_id; ?>" step="any" type="number" class="span12" name="u_rate[]" style="text-align: center;" />
    </td>
    <td style="text-align: right;" id="<?php echo 'price_label_' . $prods->p_id; ?>" class="vertical-align-mid">
        <?php echo bdt() . number_format(0, 2); ?>
    </td>
    <td class="center-align-text vertical-align-mid" id="<?php echo 'cartbtn_label_' . $prods->p_id; ?>">
        <label class="btn btn-mini btn-warning" onclick="add_to_cart('<?php echo $b_id; ?>',
                                                                        '<?php echo date('Y-m-d'); ?>',
                                                                        '<?php echo $prods->p_cid; ?>',
                                                                        '<?php echo $prods->p_id; ?>',
                                                                        '<?php echo $prods->p_gid; ?>',
                                                                        '<?php echo $prods->p_name; ?>',
                                                                        '<?php echo $prods->p_u_price; ?>',
                                                                        '<?php echo $box; ?>',
                                                                        '<?php echo ($prods->p_box_qty - 1); ?>')">
            <i class="icon-cart"></i> Add
        </label>
    </td>
</tr>
<?php $sl++; } } else { ?>
<tr>
    <td colspan="11" class="center-align-text" style="color: red;">
        <?php echo errormessage('No Data Found!!'); ?>
    </td>
</tr>
<?php } ?>