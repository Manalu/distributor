 



<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Register/Create Supplier
                </div>
            </div>
            <div class="widget-body">
                <?php agedata(); ?>
                <form class="form-horizontal no-margin" action="<?php echo site_url('supplier/newsupplier');?>" method="post">
                    <div class="control-group">
                        <label class="control-label"> Name</label>
                        <div class="controls controls-row">
                            <input class="input-block-level" type="text" name="c_name" placeholder="Supplier/Company Name. i.e. Kornaphuli Motors..." autocomplete="off" autofocus="on" required="required" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Contact Person</label>
                        <div class="controls controls-row">
                            <input class="input-block-level" type="text" name="c_contact" placeholder="Supplier Contact Person Name.. i.e. Atiqur Rahman" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Phone Number</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="c_phone" placeholder="Phone No. i.e. +88028554578" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Mobile Number</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="c_mobile"  placeholder="Mobile No. i.e. " />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Postal Address</label>
                        <div class="controls controls-row">
                            <textarea class="input-block-level no-margin" type="text" name="c_address" placeholder="Physical or postal address of the supplier/company" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email</label>
                        <div class="controls controls-row">
                            <input class="span12" type="email" name="c_email"  placeholder="email@companyname.com" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Opening Balance</label>
                        <div class="controls controls-row">
                            <input class="span12" type="number" name="c_credit" required="required"  placeholder="Current balance with supplier" />
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <button type="submit" class="btn btn-info pull-right">Register/Create Supplier </button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
 </div>