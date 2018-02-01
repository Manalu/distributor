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
<?php if($balance != FALSE) { $sl = 1; foreach($balance->result() as $balance) {  ?>
<tr>
    <td style="text-align: center;">
        <?php echo $sl; ?>
    </td>
    <td><?php echo $balance->Branch; ?></td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($balance->Balance, 2, ".", ","); ?>
    </td>
    <td style="text-align: center;">
        <input type="number" name="balance" max="<?php echo $balance->Balance; ?>" autocomplete="off" required="required" style="text-align: right;" class="span12" step="any" />
    </td>
</tr>
<?php $sl++; } ?>
<tr>
    <td colspan="4" style="text-align: center;">
        <input type="hidden" name="trigger" value="transfer" />
        <input type="submit" class="btn btn-primary btn-small" value="Transfer Balance" />
    </td>
</tr>
<?php } else { ?>
<tr class="noitemwarning">
    <td colspan="4" style="text-align: center;">
        <?php echo errormessage('No product stock in the chosen branch'); ?>
    </td>
</tr>
<script type="text/javascript">
    $(".noitemwarning").fadeOut(4000);
</script>
<?php } ?>