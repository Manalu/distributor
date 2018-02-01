

<h4><?php echo $sale_type; ?></h4>
<p>Monthly Installment: <?php echo bdt() . number_format(100, 2, ".", ","); ?></p>
<p>No. of Installment: <?php echo 10; ?></p>
<p>Installment Date: 10<sup>th</sup> of Every Month</p>
<p>Down Payment: <?php echo bdt() . number_format(50, 2, ".", ","); ?></p>
<table class="table table-condensed">
    <thead>
        <tr>
            <th>Name</th>
            <th class="center-align-text">Quantity</th>
            <th style="text-align: right;">Price</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Item 1</td>
            <td class="center-align-text">2</td>
            <td style="text-align: right;">
                <?php echo bdt() . number_format(1450154, 2, ".", ","); ?>
            </td>
        </tr>
        <tr>
            <td>Item 2</td>
            <td class="center-align-text">2</td>
            <td style="text-align: right;">
                <?php echo bdt() . number_format(1450154, 2, ".", ","); ?>
            </td>
        </tr>
        <tr>
            <td>Item 3</td>
            <td class="center-align-text">2</td>
            <td style="text-align: right;">
                <?php echo bdt() . number_format(1450154, 2, ".", ","); ?>
            </td>
        </tr>
        <tr>
            <td>Item 4</td>
            <td class="center-align-text">2</td>
            <td style="text-align: right;">
                <?php echo bdt() . number_format(1450154, 2, ".", ","); ?>
            </td>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Sub-Total</th>
            <th style="text-align: right;"><?php echo bdt() . number_format(100, 2, ".", ","); ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Discount</th>
            <th style="text-align: right;"><?php echo bdt() . number_format(10, 2, ".", ","); ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Total</th>
            <th style="text-align: right;"><?php echo bdt() . number_format(90, 2, ".", ","); ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Paid</th>
            <th style="text-align: right;"><?php echo bdt() . number_format(65, 2, ".", ","); ?></th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: right;">Outstanding</th>
            <th style="text-align: right;"><?php echo bdt() . number_format(35, 2, ".", ","); ?></th>
        </tr>
    </tbody>
    <thead>
        <tr>
            <th>Installments</th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th style="text-align: center;">Date</th> 
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center;">24-DEC-2017</td>
            <td><?php echo bdt() . number_format(20, 2, ".", ","); ?></td>
        </tr>
        <tr>
            <td style="text-align: center;">24-DEC-2017</td>
            <td><?php echo bdt() . number_format(20, 2, ".", ","); ?></td>
        </tr>
        <tr>
            <td style="text-align: center;">24-DEC-2017</td>
            <td><?php echo bdt() . number_format(20, 2, ".", ","); ?></td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
    function get_payment_form(invid, due, client){
        $("#inv_id").val(invid);
        $("#cl_id").val(client);
        $("#paid_amount").attr("max", due);
    }
</script>