<?php

/**
 * Description of grouplist
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
                    <?php widgetHeader(); ?> Group List
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 10%;">SL.</th>
                            <th style="width: 75%;">Name</th>
                            <th style="width: 15%; text-align: center;">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($groups != FALSE) { $sl = 1; foreach($groups->result() as $groups) {    ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $sl; ?></td>
                            <td><?php echo $groups->mg_name; ?></td>
                            <td style="text-align: center;">
                                <!--href="<?php //echo site_url('products/grpedit?g_id=' . $groups->mg_id); ?>"-->
                                <a onclick="update_event('<?php echo $groups->mg_id; ?>', '<?php echo $groups->mg_name; ?>')" style="cursor: pointer;">
                                    <i class="icon-edit"></i>
                                </a>
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
                    <?php widgetHeader(); ?> New Product Group
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
                <form action="<?php echo site_url('products/newgrp'); ?>" class="form-horizontal" method="POST">
                    <div class="control-group">
                        <label class="control-label">Group Name</label>
                        <div class="controls controls-row">
                            <input type="text" name="mg_name" placeholder="Product Group Name" autocomplete="off" autofocus="on" class="span12" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="trigger" value="add_new_group" />
                        <input type="submit" class="btn btn-info" value="Create Group" />
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <hr />
            <div class="widget-body" id="edit_group">
                <form action="<?php echo site_url('products/newgrp'); ?>" class="form-horizontal" method="POST">
                    <div class="control-group">
                        <label class="control-label">Group Name</label>
                        <div class="controls controls-row">
                            <input type="text" name="mg_name" id="mg_name" autocomplete="off" autofocus="on" class="span12" title="Update Product Group Name" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="hidden" name="trigger" value="update_group" />
                        <input type="hidden" name="mg_id" id="mg_id" />
                        <input type="submit" class="btn btn-warning2" value="Update Group" />
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
            <style type="text/css">
                #edit_group{display: none; }
            </style>
        </div>
    </div>
</div>
<script type="text/javascript">
    function update_event(id, name){
        $("#mg_name").val(name);
        $("#mg_id").val(id);
        $("#edit_group").css("display", "block");
        $("#mg_name").focus();
//        $("#edit_group").css("background-color", "#F0C330");
        $('html,body').animate({
        scrollTop: $("#edit_group").offset().top},
        'slow');
    }
</script>