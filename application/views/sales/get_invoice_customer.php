<?php

/**
 * Description of get_invoice_customer
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="control-group">
    <label class="control-label">DSR/Customer</label>
    <div class="controls controls-row">
        <select class="span12" name="customer" id="customer" required="required">
            <option value="">DSR/Customer</option>
            <?php if($customer != FALSE) { foreach ($customer->result() as $customer) {   ?>
            <option value="<?php echo $customer->cl_id; ?>">
                <?php echo $customer->cl_name; ?>
            </option>
            <?php } } ?>
        </select>
    </div>
</div>