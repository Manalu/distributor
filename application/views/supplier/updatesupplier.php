 




<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Update Supplier - <?php echo $company->c_name;?>
                </div>
            </div>
            <div class="widget-body">
                <?php agedata(); ?>
                <form class="form-horizontal no-margin" action="<?php echo site_url('supplier/updatesupplier');?>" method="post">
                    <div class="control-group">
                        <label class="control-label"> Name</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="c_name" value="<?php echo $company->c_name;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Contact Person</label>
                        <div class="controls controls-row">
                            <input class="input-block-level" type="text" name="c_contact" value="<?php echo $company->c_contact;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Phone </label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="c_phone" value="<?php echo $company->c_phone;?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Mobile</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="c_mobile" value="<?php echo $company->c_mobile;?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Address</label>
                        <div class="controls controls-row">
                            <textarea name="c_address" class="input-block-level no-margin" style="height: 75px;"><?php echo $company->c_address;?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="c_email" value="<?php echo $company->c_email;?>">
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="c_id" value="<?php echo $company->c_id;?>">
                        <button type="submit" class="btn btn-info"> Update Information</button>
                        <a href="<?php echo site_url('supplier/supplierlist'); ?>" class="btn btn-default">Back to List</a>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>