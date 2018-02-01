 



<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Register new Customer
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
                <form class="form-horizontal no-margin" action="<?php echo site_url('clients/new')?>" method="post">
                    <div class="control-group">
                        <label class="control-label"> Name</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="cl_name" placeholder=" Name" required="required" autofocus="on" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Phone Number</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="cl_phone_no" placeholder=" Phone Number" required="required" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Mobile Number</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="cl_mobile_no" placeholder=" Mobile Number" required="required" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> National ID</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="cl_national_id" placeholder=" National ID" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Address</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="cl_email" placeholder=" Address" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Opening Balance</label>
                        <div class="controls controls-row">
                            <input class="span12" type="number" name="cl_balance" placeholder="Customer Opening Balance" />
                        </div>
                    </div>
                    <hr />
                    <div class="form-actions no-margin">
                        <input type="hidden" name="trigger" value="createclient" />
                        <input type="hidden" name="cl_type" value="1" />
                        <button type="submit" class="btn btn-info">Register Customer</button>
                        <a href="<?php echo site_url('clients/list'); ?>" class="btn btn-default">Back to List</a>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
 </div>