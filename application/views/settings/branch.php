<?php

/**
 * Description of branch
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Branch List
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%;">SL.</th>
                            <th style="width: 30%;">Name</th>
                            <th style="width: 40%;">Manager</th>
                            <th style="width: 15%;">Phone</th>
                            <th style="text-align: center; width: 10%;">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($branch != FALSE) { $sl = 1; foreach($branch->result() as $branch) {    ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $sl; ?></td>
                            <td><?php echo $branch->b_name; ?></td>
                            <td><?php echo $branch->b_manager; ?></td>
                            <td><?php echo $branch->b_phone; ?></td>
                            <td style="text-align: center;">
                                <?php if($branch->tble_id != 1) { ?>
                                <a href="#brokerModal" role="button" data-toggle="modal"
                                   onclick="set_modal_value('<?php echo $branch->b_name; ?>',
                                                            '<?php echo $branch->b_manager; ?>',
                                                            '<?php echo $branch->b_address; ?>',
                                                            '<?php echo $branch->b_phone; ?>',
                                                            '<?php echo $branch->tble_id; ?>')">
                                    <i class="icon-edit"></i>
                                </a>
                                <?php } ?>
                            </td>
                        </tr>    
                        <?php $sl++; } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Add New Branch
                </div>
            </div>
            <div class="widget-body">
                <form class="form-horizontal" action="<?php echo site_url('settings/branch'); ?>" method="POST">
                    <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls controls-row">
                            <input type="text" name="b_name" id="b_name" class="span12" placeholder="Branch Name" autocomplete="off" autofocus="on" required="required" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Address</label>
                        <div class="controls controls-row">
                            <input type="text" name="b_address" id="b_address" class="span12" placeholder="Branch Address" autocomplete="on" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Manager</label>
                        <div class="controls controls-row">
                            <input type="text" name="b_manager" id="b_manager" class="span12" placeholder="Branch Manager" autocomplete="on" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Phone</label>
                        <div class="controls controls-row">
                            <input type="text" name="b_phone" id="b_phone" class="span12" placeholder="Branch Phone" autocomplete="on" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Opening Balance</label>
                        <div class="controls controls-row">
                            <input type="number" name="balance" id="balance" class="span12" placeholder="Branch Opening Balance" required="required" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="trigger" value="add_branch" />
                        <input type="submit" value="Add New Branch" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div id="brokerModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="myModalLabel">
                    Branch Information Update
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<?php echo site_url('settings/branch'); ?>" method="POST">
                    <div class="control-group">
                        <label class="control-label">Name</label>
                        <div class="controls controls-row">
                            <input type="text" name="b_name_edit" id="b_name_edit" class="span12" autocomplete="off" autofocus="on" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Address</label>
                        <div class="controls controls-row">
                            <input type="text" name="b_address_edit" id="b_address_edit" class="span12" placeholder="Branch Address" autocomplete="on" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Manager</label>
                        <div class="controls controls-row">
                            <input type="text" name="b_manager_edit" id="b_manager_edit" class="span12" placeholder="Branch Manager" autocomplete="on" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Phone</label>
                        <div class="controls controls-row">
                            <input type="text" name="b_phone_edit" id="b_phone_edit" class="span12" autocomplete="off" />
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="b_status">
                                Check the box if you want to delete this branch
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="tble_id" id="tble_id" /> 
                        <input type="hidden" name="trigger" value="update_branch" />
                        <input type="submit" value="Update Branch Information" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function set_modal_value(name, manager, address, phone, tble){
        $("#b_name_edit").val(name);
        $("#b_manager_edit").val(manager);
        $("#b_address_edit").val(address);
        $("#b_phone_edit").val(phone);
        $("#tble_id").val(tble);
    }
</script>