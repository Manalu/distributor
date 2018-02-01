<?php

/**
 * Description of new_software_user
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> New Software User
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body form-horizontal">
                <form action="" method="POST">
                    <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="u_name" id="u_name" required="required" placeholder="User Name" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email</label>
                        <div class="controls controls-row">
                            <input class="span12" type="email" name="u_email" id="u_email" placeholder="User Email" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Address</label>
                        <div class="controls controls-row">
                            <textarea class="span12" name="u_address" id="u_address" placeholder="User Address"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Phone</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="u_phone" id="u_phone" required="required" placeholder="Phone Number" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Mobile</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="u_phone1" id="u_phone1" placeholder="Mobile Number" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Role</label>
                        <div class="controls controls-row">
                            <select name="r_id" id="r_id" class="span12" required="required">
                                <option value="">Select Role</option>
                                <option value="1">Purchase Manager</option>
                                <option value="2">Sales Manager</option>
                                <option value="3">Administration</option>
                                <option value="4">Loan/Investment User</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Branch</label>
                        <div class="controls controls-row">
                            <select class="span12" name="b_id" id="b_id" required="required">
                                <option value="">Select Source Branch</option>
                                <?php if($source != FALSE) { foreach ($source->result() as $source) {   ?>
                                <option value="<?php echo $source->tble_id; ?>"><?php echo $source->b_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Password</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" placeholder="Minimum 6 character" name="u_pass" id="u_pass" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="trigger" value="new_software_user" />
                        <button type="submit" class="btn btn-info">Add User</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>