<?php

/**
 * Description of add_to_cart
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="cart_alert alert-block alert-success fade in">
    <button data-dismiss="alert" style="margin-bottom: 0px;" class="close" type="button" 
            onclick="remove_cart_item('<?=$cart_id?>',
                                    '<?php echo $branch_id; ?>',
                                    '<?php echo date('Y-m-d'); ?>',
                                    '<?php echo $company_id; ?>',
                                    '<?php echo $product_id; ?>',
                                    '<?php echo $group_id; ?>',
                                    '',
                                    '<?php echo $u_rate; ?>',
                                    '<?php echo $box; ?>',
                                    '<?php echo ($perbox - 1); ?>')"> × 
    </button>
    <p><?=$sms?></p>
</div>
