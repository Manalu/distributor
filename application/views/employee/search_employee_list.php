<?php

/**
 * Description of search_employee_list
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php if($clnts != FALSE) { $sl = 1; foreach ($clnts->result() as $clnts) {?>
<tr>
    <td class="center-align-text vertical-align-mid">
        <?php echo $sl; ?>
    </td>
    <td class="vertical-align-mid">
        <?php
        if($clnts->emp_status == 1) { ?>
            <b style="color: green;">
                <?php echo $clnts->emp_name; ?>
            </b>
        <?php } else if($clnts->emp_status == 2) { ?>
            <b style="color: red;">
                <?php echo $clnts->emp_name; ?>
            </b>
        <?php } ?>
    </td>
    <td class="vertical-align-mid">
        <?php echo $clnts->emp_father; ?>
    </td>
    <td class="vertical-align-mid">
        <?php echo $clnts->emp_address; ?>
    </td>
    <td class="vertical-align-mid">
        <?php echo $clnts->emp_phone_no . '<br />' . $clnts->emp_mobile_no; ?>
    </td>
    <td style="text-align: right;" class="vertical-align-mid">
        <?php echo bdt() . number_format($clnts->emp_opening_balance, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;" class="vertical-align-mid">
        <?php echo bdt() . number_format($clnts->emp_daily_salary, 2, ".", ","); ?>
    </td>
    <td class="vertical-align-mid noprint center-align-text">
        <a href="<?php echo site_url("employee/attendance_sheet?func=attendance_sheet&cat=employee&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->tble_id);?>">
            <?php echo calculate_employee_attendance($clnts->tble_id, date('Y-m-01'), date('Y-m-t')); ?>
        </a>
    </td>
    <td class="vertical-align-mid noprint center-align-text">
        <a href="<?php echo site_url("employee/salaryposting?func=details&cat=clients&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->tble_id);?>">
            <i class="icon-user"></i>
        </a>
    </td>
    <td class="vertical-align-mid noprint center-align-text">
        <a href="<?php echo site_url("employee/update?func=update&cat=clients&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->tble_id);?>">
            <i class="icon-edit"></i>
        </a>
    </td>
<!--    <td class="vertical-align-mid noprint center-align-text">
        <a href="<?php // echo site_url("employee/adjust?func=adjust&cat=employee&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->tble_id . '&type=' . $clnts->emp_balance_type);?>">
            <i class="icon-adjust"></i>
        </a>
    </td>-->
    <td class="vertical-align-mid noprint center-align-text">
        <a href="<?php echo site_url("employee/ledger?func=ledger&cat=employee&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->tble_id);?>">
            <i class="icon-profile"></i>
        </a>
    </td>
</tr>
<?php $sl++; } } else { ?>
<tr>
    <td colspan="10" class="center-align-text">
        <?php echo errormessage('No records found!!'); ?>
    </td>
</tr>
<?php } ?>