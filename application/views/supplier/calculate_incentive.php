<?php

/**
 * Description of calculate_incentive
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php if($incentive != FALSE) { $sl = 1; foreach($incentive->result() as $incentive) {  ?>
<tr>
    <td style="text-align: center; width: 10%;">
        <?php echo $sl; ?>
    </td>
    <td>
        <?php echo $incentive->Company; ?>
    </td>
    <td>
        <?php echo $incentive->Policy; ?>
    </td>
    <td>
        <?php echo $incentive->Type; ?>
    </td>
    <td style="text-align: right;">
        <?php
        if($incentive->Type == "Percentage")
        {
            echo $incentive->Incentive . ' %';
        }
        if($incentive->Type == "Fixed")
        {
            echo bdt() . number_format($incentive->Incentive, 2, ".", ",");
        }
        ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($incentive->Target, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php // echo 'Supplier: ' . $incentive->Supplier; ?>
        <?php // echo '<br />'; ?>
        <?php // echo 'Starting: ' . $starting; ?>
        <?php // echo '<br />'; ?>
        <?php // echo 'Finishing: ' . $finishig; ?>
        <?php // echo '<br />'; ?>
        <?php // echo 'Policy: ' . $incentive->Policy; ?>
        <?php // echo '<br />'; ?>
        <?php // echo 'Type: ' . $incentive->Type; ?>
        <?php // echo '<br />'; ?>
        <?php $acheivement = get_supplier_acheivement($incentive->Supplier, $starting, $finishig, $incentive->Policy, $incentive->Type); ?>
        <?php echo bdt() . number_format($acheivement, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php $incentives = get_supplier_incentive($incentive->Supplier, $starting, $finishig, $incentive->Policy, $incentive->Target, $incentive->Incentive, $incentive->Type); ?>
        <?php echo bdt() . number_format($incentives, 2, ".", ","); ?>
    </td>
    <td style="text-align: center;">
        <?php if($acheivement > $incentive->Target) { ?>
<!--        <a href="<?php //echo site_url('supplier/creditpost?sess_auth=' . md5(date('Ymd')) . '&func=credit_post&route=supplier&supplier=' . $incentive->Supplier . '&amount=' . $incentives . '&ledger=5&month=' . date_format(date_create($starting), 'm') . '&year=' . date_format(date_create($starting), 'Y') . '&date=' . $starting); ?>"-->
        <a data-toggle="modal" id="datamodal" data-target="#myModal"
           class="btn btn-warning btn-block btn-mini"
           onclick="set_modal_value_incentive_posting('<?php echo $incentive->Supplier ?>', '<?php echo $incentive->Month ?>', '<?php echo $incentive->Year ?>', '<?php echo $incentives ?>', '<?php echo $incentive->Company; ?>')">
           <!--onclick="return confirm('Are you sure? This can not be un-done.')">-->
            Adjust
        </a>
        <?php } else { ?>
        
        <a data-toggle="modal" id="datamodal" data-target="#myModal"
           class="btn btn-warning btn-block btn-mini"
           onclick="set_modal_value_incentive_posting('<?php echo $incentive->Supplier ?>', '<?php echo $incentive->Month ?>', '<?php echo $incentive->Year ?>', '<?php echo $incentives ?>', '<?php echo $incentive->Company; ?>')">
            Adjust
        </a>
        
        <!--<button type="button" class="btn btn-inverse btn-block btn-mini">Adjust</button>-->
        <?php } ?>
    </td>
</tr>
<?php $sl++; } } ?>