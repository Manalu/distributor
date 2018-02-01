        

            
            <div class="row-fluid">
                <div class="span12">
                    <p class="text-error center-align-text">You will be logged out upon profile information update or password change.</p>
                </div>
            </div>
            <div class="row-fluid">
                <!--
                View Profile information.
                -->
                <div class="span4">
                    <div class="widget">
                        <div class="widget-header">
                            <div class="title">
                                <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Profile - <?php echo $name;?>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="control-group">
                                <label class="control-label">Name</label>
                                <div class="controls controls-row">
                                    <input class="span12" type="text" name="fname" value="<?php echo $name;?>" disabled="disabled" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Email</label>
                                <div class="controls controls-row">
                                    <input class="span12" type="text" name="fname" value="<?php echo $email;?>" disabled="disabled" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="email1">Phone</label>
                                <div class="controls">
                                    <input type="text" name="phone" id="email1" class="span12" value="<?php echo $fone;?>" disabled="disabled" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="email1">Mobile</label>
                                <div class="controls">
                                    <input type="text" name="phone" id="email1" class="span12" value="<?php echo $fone1;?>" disabled="disabled" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="r_id">Designation</label>
                                <div class="controls">
                                    <input type="text" name="r_id" id="r_id" class="span12" value="<?php if($role == 3) { echo 'Inventory Manager'; } elseif($role == 2) { echo 'Sales Officer'; } elseif($role == 1) { echo 'Administrator'; } ?>" disabled="disabled" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="country">Address</label>
                                <div class="controls">
                                    <input type="text" name="phone" id="email1" class="span12" value="<?php echo $address;?>" disabled="disabled" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <!--
                Update profile basic information of a profile.
                -->
                <div class="span4">
                    <div class="widget">
                        <div class="widget-header">
                            <div class="title">
                                <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Update Profile - <?php echo $name;?>
                            </div>
                        </div>
                        <div class="widget-body">
                            <form action="<?php echo site_url('profile');?>" method="post">
                                <?php  if($this->session->flashdata('agedata')) {  echo $this->session->flashdata('agedata'); } ?>
                                <div class="control-group">
                                    <label class="control-label" for="u_name">Name</label>
                                    <div class="controls controls-row">
                                        <input class="span12" type="text" name="u_name" value="<?php echo $name;?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="u_email">Email</label>
                                    <div class="controls controls-row">
                                        <input class="span12" type="email" name="u_email" value="<?php echo $email;?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="u_phone">Phone</label>
                                    <div class="controls">
                                        <input type="text" name="u_phone" id="email1" class="span12" value="<?php echo $fone;?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="u_phone1">Mobile</label>
                                    <div class="controls">
                                        <input type="text" name="u_phone1" id="email1" class="span12" value="<?php echo $fone1;?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="u_address">Address</label>
                                    <div class="controls">
                                        <input type="text" name="u_address" id="email1" class="span12" value="<?php echo $address;?>" />
                                    </div>
                                </div>
                                <div class="form-actions no-margin">
                                    <input type="hidden" name="trigger" value="updateinfo" />
                                    <button type="submit" class="btn btn-info pull-right" id="updateinfooo">Update Information </button>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                
                
                <!--
                Change Password for a profile object.
                -->
                <div class="span4">
                    <div class="widget">
                        <div class="widget-header">
                            <div class="title">
                                <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Change Password
                            </div>
                        </div>
                        <div class="widget-body">
                            <form action="<?php echo site_url('profile');?>" method="post">
                                <div class="control-group">
                                    <label class="control-label" for="password5">Password</label>
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
                                    <input type="hidden" name="trigger" value="updatepass" />
                                    <button type="submit" class="btn btn-info pull-right">Update Password </button>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>