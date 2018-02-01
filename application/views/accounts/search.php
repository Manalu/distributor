

<?php if($orderz != NULL) { $sl = 1; $total = 0; foreach($orderz->result() as $orderz) {?>
<tr>
    <td style="text-align: center;"><?=$sl;?></td>
    <td>
        <?php echo date_format(date_create($orderz->v_date), "d-M-Y"); ?>
    </td>
    <td>
        <?php echo $orderz->Branch; ?>
    </td>
    <td>
        <?php echo $orderz->Through; ?>
    </td>
    <td>
        <?php echo $orderz->ledger; ?>
    </td>
    <td>
        <?php echo $orderz->v_note; ?>
    </td>
    <td style="text-align: right;">
        <?php $total = $total + $orderz->v_amount; ?>
        <?php echo bdt() . number_format(abs($orderz->v_amount), 2, ".", ","); ?>
    </td>
    <?php if($role == 3) { ?>
    <td style="text-align: center;" class="noprint">
        <?php if($orderz->edit == 1) { ?>
        <a href="<?php echo site_url('accounts/edvchr?func=update&cat=accounts&mod=admin&sess_auth=' . md5(date('Ymdhis')) . '&remote=' . md5($title) . '&v_id=' . $orderz->tble_id . '&type=' . $orderz->v_type); ?>">
            <i class="icon-edit"></i>
        </a>
        <?php } ?>
    </td>
    <?php } ?>
</tr>
<?php $sl++; } ?>
<tr>
    <th style="text-align: right;" colspan="6">
        Total
    </th>
    <th style="text-align: right;">
        <?php echo bdt() . number_format($total, 2, ".", ","); ?>
    </th>
    <?php if($role == 3) { ?>
    <th class="noprint"></th>
    <?php } ?>
</tr>
<?php } else { ?>
<tr>
    <td colspan="8" style="text-align: center;">
        <?php echo errormessage('No recrods found!!'); ?>
    </td>
</tr>
<?php } ?>
