<input type="hidden" name="supplier" value="<?php echo $supplier; ?>" />
<input type="hidden" name="start" value="<?php echo $start; ?>" />
<input type="hidden" name="finish" value="<?php echo $finish; ?>" />
<input type="hidden" name="status" value="<?php echo $status; ?>" />
<?php if($order_list != FALSE) { $sl = 1; $billed = 0; $paid = 0; $due = 0; foreach($order_list->result() as $orders) {   ?>
<tr>
    <td style="text-align: center;"><?php echo $sl; ?></td>
    <td><?php echo $orders->Supplier; ?></td>
    <td style="text-align: center;"><?php echo date_format(date_create($orders->or_date), 'd-M-Y'); ?></td>
    <td style="text-align: center;"><?php echo $orders->Item; ?></td>
    <td style="text-align: right;">
        <?php $billed = $billed + $orders->Billed; ?>
        <?php echo bdt() . number_format($orders->Billed, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php $paid = $paid + $orders->Paid; ?>
        <?php echo bdt() . number_format($orders->Paid, 2, ".", ","); ?>
    </td>
    <td style="text-align: right;">
        <?php $current = $orders->Billed - $orders->Paid; ?>
        <?php $due = $due + $current; ?>
        <?php echo bdt() . number_format($current, 2, ".", ","); ?>
    </td>
    <td style="text-align: center;">
        <?php // if($orders->Paid < $orders->Billed) { ?>
        <!--<a href="<?php // echo site_url('order/payment/' . $orders->or_id); ?>" class="btn btn-mini btn-success btn-block">Pay</a>-->
        <?php // } else if($orders->Paid > $orders->Billed) { ?>
        <!--<a href="<?php // echo site_url('order/adjust/' . $orders->or_id . '/' . abs($current) . '/' . $orders->Company); ?>" class="btn btn-mini btn-warning btn-block">Adjust</a>-->
        <?php // } else { ?>
        <!--<a class="btn btn-mini btn-inverse btn-block">Pay</a>-->
        <?php // } ?>
        <?php if($orders->Status == 1) {    ?>
        <b style="color: blue;">Placed</b>
        <?php } else if($orders->Status == 2) { ?>
        <b style="color: green;">Received</b>
        <?php } else if($orders->Status == 3) { ?>
        <b style="color: red;">Canceled</b>
        <?php } ?>
    </td>
    <td style="text-align: center;">
        <a href="<?php echo site_url('order/details/' . $orders->or_id); ?>">
            <i class="icon-profile"></i>
        </a>
    </td>
    <td style="text-align: center;">
        <?php if($orders->Status == 1) { ?>
        <a href="<?php echo site_url('order/receive/' . $orders->or_id); ?>">
            <i class="icon-edit"></i>
        </a>
        <?php } else { ?>
        <i class="icon-edit"></i>
        <?php } ?>
    </td>
</tr>
<?php $sl++; } ?>
<tr>
    <th colspan="4" style="text-align: right;">Total</th>
    <th style="text-align: right;">
        <?php echo bdt() . number_format($billed, 2, ".", ","); ?>
    </th>
    <th style="text-align: right;">
        <?php echo bdt() . number_format($paid, 2, ".", ","); ?>
    </th>
    <th style="text-align: right;">
        <?php echo bdt() . number_format($due, 2, ".", ","); ?>
    </th>
    <th colspan="3"></th>
</tr>
<?php } else { ?>
<tr>
    <td style="text-align: center;" colspan="10">
        <?php echo errormessage('No orders found!!') ?>
    </td>
</tr>
<?php } ?>