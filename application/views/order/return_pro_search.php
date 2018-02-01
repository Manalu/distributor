<?php

/**
 * Description of damage_pro_search
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>




<?php if($prods != FALSE){foreach ($prods->result() as $prods) { ?>
<tr>
    <td style="width: 5%; text-align: center;">
        <input type="checkbox" name="product_id[]" value="<?php echo $prods->p_id; ?>" checked="checked" />
        <input type="hidden" name="stock[]" value="<?php echo $prods->p_stok; ?>" />
    </td>
    <td><?php echo $prods->p_name; ?></td>
    <td><?php echo $prods->mg_name; ?></td>
    <td class="center-align-text">
        <b>
            <?php
            if($prods->p_stok == NULL){
                echo 0;
            } else {
                echo $prods->p_stok;
            } ?>
        </b>
    </td>
    <td class="center-align-text">
        <input type="number" name="quantity[]" max="<?php echo $prods->p_stok; ?>" class="input-block-level" style="text-align: center;" required="required" value="0" />
    </td>
    <td class="center-align-text">
        <input type="number" name="rates[]" class="input-block-level" style="text-align: center;" required="required" value="<?php echo $prods->p_stock_price; ?>" />
    </td>
    <td class="center-align-text">
        <input type="text" name="notes[]" class="input-block-level" />
    </td>
</tr>
<?php }} else { ?>
<tr>
    <td colspan="7" class="center-align-text" style="color: red;">
        <?php echo errormessage('No Data Found!!'); ?>
    </td>
</tr>
<?php } ?>