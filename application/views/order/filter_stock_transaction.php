<?php

/**
 * Description of filter_stock_transaction
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<!--<h4><?// echo $dateline;?></h4>-->
<!--<h5><?//echo $records;?></h5>-->
<?php   if($stock != FALSE) { $sl = 1; foreach($stock->result() as $stock) { 
        $stockin = get_product_stockin($start, $finish, $stock->Product, $branch);
        $soldout = get_product_soldout($start, $finish, $stock->Product, $branch);
        $trnsout = get_product_trnsout($start, $finish, $stock->Product, $branch);
        $stokout = $soldout + $trnsout;
?>
<tr>
    <td style="text-align: center;"><?php echo $sl; ?></td>
    <td>
        <?php echo $stock->Name; ?>
    </td>
    <td>
        <?php echo $stock->Supplier; ?>
    </td>
    <td style="text-align: center;"><?php echo $stock->Quantity; ?></td>
    <td style="text-align: center;">
        <?php echo floor($stock->OpeningStock / $stock->OpeningBox) . '/' . ($stock->OpeningStock % $stock->OpeningBox); ?>
    </td>
    <td style="text-align: center;">
        <?php echo floor($stockin/ $stock->Quantity) . '/' . ($stockin % $stock->Quantity); ?>
    </td>
    <td style="text-align: center;">
        <?php echo floor($stokout / $stock->Quantity) . '/' . ($stokout % $stock->Quantity); ?>
    </td>
    <td style="text-align: center;">
        <?php
            echo floor((int)$stock->Balance / $stock->Quantity) . '/' . ((int)$stock->Balance % $stock->Quantity);
        ?>
    </td>
</tr>
<?php $sl++; } } else { ?>
<tr>
    <td colspan="8" class="center-align-text">
        <?php echo errormessage('No Closing found before the starting date mentioned.'); ?>
    </td>
</tr>
<?php } ?>
