 


<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Update Customer
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
                <form class="form-horizontal no-margin" action="<?php echo site_url('clients/update');?>" method="post">
                    <div class="control-group">
                        <label class="control-label"> Name</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="cl_name" value="<?php echo $detls->cl_name;?>" placeholder="Client Name" required="required" autofocus="on" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Phone Number</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" value="<?php echo $detls->cl_phone_no;?>" name="cl_phone_no" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Mobile Number</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="cl_mobile_no" value="<?php echo $detls->cl_mobile_no;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> National ID</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="cl_national_id" value="<?php echo $detls->cl_national_id;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Address</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="cl_email" value="<?php echo $detls->cl_email;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Type</label>
                        <div class="controls controls-row">
                            <select name="cl_type" required="required" id="cl_type" class="span12">
                                <option value="">Select Type</option>
                                <option value="1" <?php if($detls->cl_type == 1) { echo 'selected'; } ?>>Customer</option>
                                <option value="2" <?php if($detls->cl_type == 2) { echo 'selected'; } ?>>DSR</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="trigger" value="updateclient">
                        <input type="hidden" name="clid" value="<?php echo $detls->cl_id;?>">
                        <button type="submit" class="btn btn-info">Update Customer Info</button>
                        <a href="<?php echo site_url('clients/list'); ?>" class="btn btn-default">Back to List</a>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>