<?php

/**
 * Description of add_damage_item_to_stock
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<tr>
    <td colspan="8" class="center-align-text">
        <?php notification(); ?>
    </td>
</tr>
<?php if($return_itms != FALSE) { $sl = 1; foreach($return_itms->result() as $items){   ?>
                            <tr>
<!--                                <td style="text-align: center;">
                                    <input type="checkbox" name="tble_id[]" value="<?php // echo $items->tble_id; ?>" />
                                </td>-->
                                <td style="text-align: center;">
                                    <?php echo $sl; ?>
                                </td>
                                <td>
                                    <?php echo $items->Product; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $items->Cartoon; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $items->quantity; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php echo bdt(). number_format(($items->quantity * $items->Purchase), 2, ".", ","); ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if($items->received == 1) { ?>
                                    <button onclick="update_stock_receive('<?php echo $items->tble_id ?>',
                                                            '<?php echo $items->p_id; ?>', '<?php echo $items->Central + $items->quantity; ?>',
                                                            '<?php echo $return_info->tble_id; ?>')" class="btn btn-success btn-mini">
                                        Receive
                                    </button>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if($items->received == 1) { ?>
                                    <i class="icon-trash"></i>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php if($items->received == 1) { ?>
                                    <button class="btn btn-warning btn-mini">Adjust</button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php $sl++; } } ?>