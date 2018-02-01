<?php

/**
 * Description of get_closing_record
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php if($records != FALSE) foreach ($records->result() as $closing){   ?>
<tr>
    <td style="text-align: center;">
        <?php echo date_format(date_create($closing->closing_date), 'd-M-Y'); ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($closing->company_balance, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($closing->stock_balance, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($closing->cash_in_hand, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($closing->damage_balance, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($closing->total_due_balance, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($closing->loan_balance, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php echo bdt() . number_format($closing->invest_balance, 2, ".", ","); ?>
    </td>
</tr>
<?php } else {  ?>
<tr></tr>
<?php } ?>