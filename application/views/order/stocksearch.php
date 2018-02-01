



<?php if($prods != FALSE){foreach ($prods->result() as $prods) { ?>
<tr>
    <td style="width: 5%; text-align: center;">
        <input type="checkbox" name="product_id[]" value="<?php echo $prods->p_id; ?>" />
    </td>
    <td><?php echo $prods->p_name; ?></td>
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
    <td class="center-align-text"><?php echo $prods->p_min_qty; ?></td>
    <td class="center-align-text">
        <?php if($prods->p_stok < $prods->p_min_qty || $prods->p_stok == $prods->p_min_qty || $prods->p_stok == 0){ ?>
        <label class="label label-important">Short</label>
        <?php } else { ?>
        <label class="label label-success">Stock</label>
        <?php } ?>
    </td>
</tr>
<?php }} else { ?>
<tr>
    <td colspan="6" class="center-align-text" style="color: red;">
        <?php echo errormessage('No Data Found!!'); ?>
    </td>
</tr>
<?php } ?>