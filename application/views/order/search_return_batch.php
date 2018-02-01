<?php

/**
 * Description of search_damage_batch
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php if($return_list != FALSE) { $sl = 1; $total = 0; foreach($return_list->result() as $list) {   ?>
<tr>
    <td style="text-align: center;"> <?php echo $sl; ?> </td>
    <td><?php echo $list->batch_no; ?></td>
    <td><?php echo $list->Supplier; ?></td>
    <td style="text-align: center;">
        <?php echo $list->Item; ?>
    </td>
    <td style="text-align: center;">
        <?php echo date_format(date_create($list->Stored), "d-M-Y"); ?>
    </td>
    <td style="text-align: right;">
        <?php $total = $total + $list->TotalPrice; ?>
        <?php echo bdt() . number_format($list->TotalPrice, 2, ".", ","); ?>
    </td>
    <td style="text-align: center;">
        <?php if($list->status != 3 && $list->Item > 0 && $list->branch == $b_id) { ?>
        <a class="btn btn-mini btn-success" href="<?php echo site_url('order/damage_adjust?func=damage_adjust&route=order&batch='. $list->batch . '&company=' . $list->Company . '&amount=' . $list->TotalPrice); ?>">
            Adjust
        </a>
        <?php } ?>
    </td>
    <td style="text-align: center;">
        <?php if($list->branch == $b_id) { ?>
        <a href="<?php echo site_url('order/returnit/' . $list->batch . '/' . $list->Company . '/' . $list->branch); ?>" class="btn btn-block btn-mini btn-success">Add Item</a>
        <?php } ?>
    </td>
    <td style="text-align: center;">
        <a href="<?php echo site_url('order/return_details/' . $list->batch); ?>" class="btn btn-block btn-mini btn-warning">Details</a>
    </td>
</tr>
<?php $sl++; } ?>
<tr>
    <td colspan="5" style="text-align: right; font-weight: bold;">Total</td>
    <td style="font-weight: bold; text-align: right;"><?php echo bdt() . number_format($total, 2, ".", ","); ?></td>
    <td colspan="3"></td>
</tr>
<?php } else { ?>
<tr>
    <td colspan="10" class="center-align-text">
        <?php echo errormessage('There is no data!!'); ?>
    </td>
</tr>
<?php } ?>