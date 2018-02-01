<?php

/**
 * Description of search_customer_list
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php if($clnts != FALSE){ $total = 0; $sl = 1; foreach ($clnts->result() as $clnts) {?>
<tr>
    <td class="center-align-text">
        <?php echo $sl; ?>
    </td>
    <td>
        <?php echo $clnts->cl_name; ?>
    </td>
    <td>
        <?php echo $clnts->cl_phone_no; ?>
    </td>
    <td>
        <?php echo $clnts->cl_mobile_no; ?>
    </td>
    <td>
        <?php echo $clnts->cl_national_id; ?>
    </td>
    <td style="text-align: right;">
        <?php $total = $total + $clnts->cl_balance; ?>
        <?php echo bdt() . number_format($clnts->cl_balance, 2, ".", ","); ?>
    </td>
    <td class="center-align-text noprint">
        <a href="<?php echo site_url("dsr/ledger?func=details&cat=clients&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->cl_id);?>">
            <i class="icon-profile"></i>
        </a>
    </td>
    <?php if($role == 3) { ?>
        <td class="center-align-text noprint">
            <a href="<?php echo site_url("dsr/update?func=update&cat=clients&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->cl_id);?>">
                <i class="icon-edit"></i>
            </a>
        </td>
        <td class="center-align-text noprint">
            <a href="<?php echo site_url("dsr/adjust?func=adjust&cat=clients&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->cl_id);?>">
                <i class="icon-adjust"></i>
            </a>
        </td>
    <?php } ?>
</tr>
<?php $sl++; } ?> 
<tr>
    <td colspan="5" style="text-align: right;">Total</td>
    <td style="text-align: right;"><?php echo bdt() . number_format($total, 2, ".", ","); ?></td>
    <td colspan="3"></td>
</tr>
<?php   } ?>