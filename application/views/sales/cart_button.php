<?php

/**
 * Description of cart_button
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php
if($stok == NULL){
    echo $box = 0;
} else {
    $box = get_number_of_boxes($stok, $perbox);
} ?>
<label class="btn btn-mini btn-warning" onclick="add_to_cart('<?php echo $branch_id; ?>',
                                            '<?php echo date('Y-m-d'); ?>',
                                            '<?php echo $company_id; ?>',
                                            '<?php echo $product_id; ?>',
                                            '<?php echo $group_id; ?>',
                                            '',
                                            '<?php echo $u_rate; ?>',
                                            '<?php echo $box; ?>',
                                            '<?php echo ($perbox - 1); ?>')">
<i class="icon-cart"></i> Add
</label>