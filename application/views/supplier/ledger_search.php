<?php

/**
 * Description of ledger_search
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php if($credit_voucher != FALSE) { $sl = 1; $adjust = 0; $deposit = 0; foreach($credit_voucher->result() as $voucher) { ?>
<tr>
    <td style="text-align: center;"><?php echo $sl; ?></td>
    <td style="text-align: center;"><?php echo date_format(date_create($voucher->adjust_date), 'd-M-Y'); ?></td>
    <td style="text-align: left;"><?php echo $voucher->LedgerText; ?></td>
    <td style="text-align: left;">
        <?php echo $voucher->notes; ?>
    </td>
    <td style="text-align: right;">
        <?php if($voucher->ledger == 1) { $adjust = $adjust + $voucher->amount;
        echo bdt() . number_format($voucher->amount, 2, ".", ",");
        } else {
        echo bdt() . number_format(0, 2, ".", ",");
        } ?>
    </td>
    <td style="text-align: right;">
        <?php if($voucher->ledger == 2 || $voucher->ledger == 3 || $voucher->ledger == 4 || $voucher->ledger == 7 || $voucher->ledger == 8 || $voucher->ledger == 6) {
        $deposit = $deposit + $voucher->amount;    
        echo bdt() . number_format($voucher->amount, 2, ".", ",");    
        } else {
        echo bdt() . number_format(0, 2, ".", ",");
        } ?>
    </td>
</tr>
<?php $sl++; } ?>
<tr>
    <th colspan="5" style="text-align: right;">
    <?php 
    echo bdt() . number_format($adjust, 2, ".", ",");
    ?>    
    </th>
    <th colspan="1" style="text-align: right;">
    <?php 
    echo bdt() . number_format($deposit, 2, ".", ",");
    ?>    
    </th>
</tr>
<?php } else { ?>
<tr>
    <td style="text-align: center;" colspan="6">
        <?php echo errormessage('No data found!!') ?>
    </td>
</tr>
<?php } ?>