<?php

/**
 * Description of get_ledger_head
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="control-group">
    <label class="control-label" style="color: red;"><?php echo ($v_type == 1) ? 'Income' : 'Expense'; ?> Head</label>
    <div class="controls controls-row">
        <select class="span12" name="v_head" id="v_head" required="required">
            <option value="">Select</option>
            <?php foreach($purpoz->result() as $purpoz) { ?>
            <option value="<?php echo $purpoz->id; ?>">
                <?php 
                echo $purpoz->ledger;
                if($purpoz->type == 1) { echo ' (Income)'; }
                elseif($purpoz->type == 2) { echo ' (Expense)'; }
                ?>
            </option>
            <?php } ?>
        </select>
    </div>
</div>