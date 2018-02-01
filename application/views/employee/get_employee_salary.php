<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="controls controls-row">
    <p><?php echo $salary_info; ?></p>
    <?php
    if($attendance != FALSE) { $hajira = $attendance->num_rows(); } else { $hajira = 0; }
    $salary = round($detls->emp_daily_salary * $hajira);
    ?>
    <h5>Attendance: <?=$hajira?> Days</h5>
    <h4>Salary: <?php echo bdt() . number_format($salary, 2, ".", ","); ?></h4>
    <h6>Paid Amount: <?php echo bdt() . number_format($paid_salary, 2, ".", ","); ?></h6>
    <?php $remaining = $salary - $paid_salary; ?>
    <input type="hidden" name="emp_id" value="<?php echo $detls->tble_id; ?>" />
    <input type="hidden" name="balance" id="current_balance" value="<?php echo $detls->emp_opening_balance; ?>" />
    <input type="hidden" name="amount" id="current_amount" value="<?php echo $salary; ?>" />
</div>
<!--<div class="control-group">
    <label class="control-label">Paid Amount</label>
    <div class="controls controls-row">
        <?php // if($starting <= date('Y-m-d')) { ?>
        <input type="number" class="span12" name="amount" required="required" max="<?php echo $remaining; ?>" min="1" placeholder="Paid Amount" autocomplete="off" />
        <?php // } else if ($starting >= date('Y-m-d')) { ?>
        <input type="number" class="span12" name="amount" required="required" max="<?php echo $detls->emp_monthly_salary; ?>" min="1" placeholder="Paid Amount" autocomplete="off" />
        <?php // } ?>
    </div>
</div>-->