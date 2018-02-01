<?php

/**
 * Description of get_stock_transfer_report
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php if($transfer_report != FALSE) { $sl = 1; foreach($transfer_report->result() as $report) {
$transferred = get_transfer_quantity($report->Product, $filter_data['from'], $filter_data['to'], $filter_data['source'], $filter_data['destination']); //if($report->Amount != NULL) {  
if($transferred > 0) {
?>
<tr>
    <td style="text-align: center;"><?php echo $sl; ?></td>
    <td><?php echo $report->Name; ?></td>
    <td>
        <?php echo $report->Supplier; ?>
    </td>
    <td style="text-align: center;"><?php echo get_number_of_boxes($transferred, $report->Cartoon); ?></td>
    <td style="text-align: center;"><?php echo get_number_of_remainder($transferred, $report->Cartoon); ?></td>
</tr>
<?php $sl++; } } } ?>
