        

            
<div class="row-fluid">
    <!-- Update profile basic information of a profile. -->
    <div class="span7">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Update Profile - <?php echo $usrinfo->name;?>
                </div>
            </div>
            <div class="widget-body form-horizontal">
                <form action="<?php echo site_url('settings/edtusr');?>" method="post">
                    <?php  echo $this->session->flashdata('agedata'); ?>
                    <div class="control-group">
                        <label class="control-label" for="u_name">Name</label>
                        <div class="controls controls-row">
                            <input class="span12" type="text" name="u_name" value="<?php echo $usrinfo->name;?>" required="required" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="u_email">Email</label>
                        <div class="controls controls-row">
                            <input class="span12" type="email" name="u_email" value="<?php echo $usrinfo->email;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="u_phone">Phone</label>
                        <div class="controls">
                            <input type="text" name="u_phone" id="u_phone" class="span12" value="<?php echo $usrinfo->fone;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="u_phone1">Mobile</label>
                        <div class="controls">
                            <input type="text" name="u_phone1" id="u_phone1" class="span12" value="<?php echo $usrinfo->fone1;?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="u_role">Role</label>
                        <div class="controls">
                            <select class="span12" name="u_role" id="u_role" required="required">
                                <option value=""> Select Role</option>
                                <option value="1" <?php if($usrinfo->role == 1) { echo 'selected'; } ?>> Purchase Manager</option>
                                <option value="2" <?php if($usrinfo->role == 2) { echo 'selected'; } ?>> Sales Manager</option>
                                <option value="3" <?php if($usrinfo->role == 3) { echo 'selected'; } ?>> Administration</option>
                                <option value="4" <?php if($usrinfo->role == 4) { echo 'selected'; } ?>> Loan/Investment User</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Branch</label>
                        <div class="controls controls-row">
                            <select name="b_id" id="b_id" required="required" class="span12">
                                <option value="">Select a Branch</option>
                                <?php if($branch != FALSE) { foreach($branch->result() as $branch) {    ?>
                                <option value="<?php echo $branch->tble_id; ?>" <?php if($usrinfo->b_id == $branch->tble_id) { echo 'selected'; } ?>>
                                    <?php echo $branch->b_name; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="u_status">Status</label>
                        <div class="controls">
                            <select class="span12" name="u_status" id="u_status" required="required">
                                <option value=""> Status</option>
                                <option value="1" <?php if($usrinfo->u_status == 1) { echo 'selected'; } ?>> Active</option>
                                <option value="2" <?php if($usrinfo->u_status == 2) { echo 'selected'; } ?>> De-active</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="u_address">Address</label>
                        <div class="controls">
                            <input type="text" name="u_address" id="u_address" class="span12" value="<?php echo $usrinfo->address;?>" />
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="usrid" value="<?php echo $usrid; ?>" />
                        <input type="hidden" name="trigger" value="updateinfo" />
                        <button type="submit" class="btn btn-info" id="updateinfooo"> Update Information</button>
                        <a href="<?php echo site_url('settings/usrlst'); ?>" class="btn btn-default">Back To List</a>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!--
    Change Password for a profile object.
    -->
    <div class="span5">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Change Password
                </div>
            </div>
            <div class="widget-body form-horizontal">
                <?php echo $this->session->flashdata('agedata'); ?>
                <form action="<?php echo site_url('settings/edtusr');?>" method="post">
                    <div class="control-group">
                        <label class="control-label" for="password5">New Password</label>
                        <div class="controls">
                            <input type="password" name="password" id="password5" class="span12" placeholder="6 or more characters"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="repPassword">Repeat Password</label>
                        <div class="controls">
                            <input type="password" name="repPassword" id="repPassword" class="span12" placeholder="Retype Password"  />
                        </div>
                    </div>
                    <div class="form-actions no-margin">
                        <input type="hidden" name="usrid" value="<?php echo $usrid; ?>" />
                        <input type="hidden" name="trigger" value="updatepass" />
                        <button type="submit" class="btn btn-info">Update Password </button>
                        <a href="<?php echo site_url('settings/usrlst'); ?>" class="btn btn-default">Back To List</a>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>