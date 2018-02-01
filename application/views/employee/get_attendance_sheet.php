<?php

/**
 * Description of get_attendance_sheet
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php if($attendance != FALSE) { $sl = 1; foreach($attendance->result() as $attendance) { ?>
<tr>
    <td style="text-align: center;">
        <?php echo $sl; ?>
    </td>
    <td>
        <?php echo date_format(date_create($attendance->attendance), 'd-M-Y') ?>
    </td>
    <td class="center-align-text">
        <a href="<?php echo site_url("employee/dltatn?func=remove_attendance&cat=employee&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&emp_id=" . $attendance->tble_id . "&remove=" . $attendance->attendance); ?>">
            <i class="icon-remove"></i>
        </a>
    </td>
</tr>
<?php $sl++; } } else { ?>
<tr>
    <td colspan="2" class="center-align-text">
    <?php echo errormessage('No records found!!'); ?>
    </td>
</tr>
<?php } ?>