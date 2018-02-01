 


<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Update Employee Information
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
                <form class="form-horizontal no-margin" action="<?php echo site_url('employee/update');?>" method="post">
                    <div class="control-group">
                        <label class="control-label"> Name</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="emp_name" value="<?php echo $detls->emp_name;?>" placeholder="Client Name" required="required" autofocus="on" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Father</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="emp_father" value="<?php echo $detls->emp_father;?>" placeholder="Father Name" required="required" autofocus="on" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Address</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="emp_address" value="<?php echo $detls->emp_address;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> National ID</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="emp_national_id" value="<?php echo $detls->emp_national_id;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Phone</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="emp_phone_no" value="<?php echo $detls->emp_phone_no;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Mobile</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="emp_mobile_no" value="<?php echo $detls->emp_mobile_no;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Salary</label>
                        <div class="controls controls-row">
                            <input class="span12" type="number" name="emp_monthly_salary" value="<?php echo $detls->emp_monthly_salary;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Work Day</label>
                        <div class="controls controls-row">
                            <input class="span12" type="number" name="emp_monthly_working" value="<?php echo $detls->emp_monthly_working; ?>" max="31" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="emp_status">
                            Status
                        </label>
                        <div class="controls controls-row">
                            <select id="emp_status" name="emp_status" class="span12">
                                <option value="">Status</option>
                                <option value="1" <?php if($detls->emp_status == 1) { echo 'selected'; } ?>>Active</option>
                                <option value="2" <?php if($detls->emp_status == 2) { echo 'selected'; } ?>>Deleted</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="trigger" value="updateemployee">
                        <input type="hidden" name="tble_id" value="<?php echo $detls->tble_id;?>">
                        <button type="submit" class="btn btn-info">Update Employee Info</button>
                        <a href="<?php echo site_url('employee/list'); ?>" class="btn btn-default">Back to List</a>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>