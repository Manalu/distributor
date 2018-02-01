<?php

/**
 * Description of search_by_data
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php if($invoices != FALSE) { $sl = 1; foreach($invoices->result() as $invoices) {  ?>
<tr>
    <td style="text-align: center; width: 5%;">
        <?php echo $sl; ?>
    </td>
    <td style="text-align: center;">
        <?php echo $invoices->inv_id; ?>
    </td>
    <td style="text-align: center;">
        <?php echo date_format(date_create($invoices->sale_date), 'd-M-Y'); ?>
    </td>
    <td>
        <?php echo $invoices->Customer; ?>
    </td>
    <td>
        <?php echo $invoices->Market; ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($invoices->Billed, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($invoices->Paid, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format(($invoices->Billed - $invoices->Paid), 2, ".", ","); ?>
    </td>
    <td style="text-align: center;" class="noprint">
        <?php if($invoices->status == 1) { if($invoices->Paid == NULL) { $total_paid = 0; } else { $total_paid = $invoices->Paid; } ?>
        <a class="btn btn-mini btn-success" href="#paymentModal" role="button" data-toggle="modal"
           onclick="set_modal_value('<?php echo $invoices->Billed; ?>',
                                    '<?php echo $total_paid; ?>',
                                    '<?php echo $invoices->inv_id; ?>',
                                    '<?php echo $invoices->branch_id; ?>',
                                    '<?php echo $invoices->client_id; ?>',
                                    '<?php echo $invoices->sale_date; ?>',
                                    '<?php echo $invoices->Billed - $invoices->Paid; ?>')">
            Pay
        </a>    
        <?php } else if($invoices->status == 2) {   ?>
        <button type="button" class="btn btn-mini btn-inverse">Paid</button>
        <?php } ?>
    </td>
    <td style="text-align: center;" class="noprint">
        <a href="<?php echo site_url('sales/details?func=details&cat=sales&mod=admin&sess_auth=' . md5(date('Ymdhis')) . '&remote=' . md5($memb) . '&invoice=' . $invoices->inv_id . '&customer=' . $invoices->client_id); ?>">
            <i class="icon-profile"></i>
        </a>
    </td>
    <td style="text-align: center;" class="noprint">
        <?php if($invoices->status == 1 && $invoices->branch_id == $b_id) {  ?>
        <a href="<?php echo site_url('sales/update?func=update&cat=sales&mod=admin&sess_auth=' . md5(date('Ymdhis')) . '&remote=' . md5($memb) . '&invoice=' . $invoices->inv_id . '&customer=' . $invoices->client_id); ?>">
            <i class="icon-edit"></i>
        </a>
        <?php } else {  ?>
        <i class="icon-edit"></i>
        <?php } ?>
    </td>
</tr>
<?php $sl++; } } else { ?>
<tr>
    <td colspan="11" class="center-align-text">
        <?php echo errormessage('No Data Found!!'); ?>
    </td>
</tr>
<?php } ?>