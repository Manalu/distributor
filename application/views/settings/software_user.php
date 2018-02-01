



<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Software User List
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <table class="table table-condensed table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%;">
                                SL.
                            </th>
                            <th style="width: 14%;">
                                Name
                            </th>
                            <th style="width: 10%;">
                                Email
                            </th>
                            <th style="width: 17%;">
                                Address
                            </th>
                            <th style="width: 9%;">
                                Phone
                            </th>
                            <th style="width: 10%;">Role</th>
                            <th style="width: 9%;">
                                Branch
                            </th>
                            <th style="width: 5%; text-align: center;">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($usrlist != FALSE) { $sl = 1; foreach($usrlist->result() as $usrlist) { ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php echo $sl; ?>
                            </td>
                            <td>
                                <?php echo $usrlist->u_name; ?>
                            </td>
                            <td>
                                <?php echo $usrlist->u_email; ?>
                            </td>
                            <td>
                                <?php echo $usrlist->u_address; ?>
                            </td>
                            <td>
                                <?php echo $usrlist->u_phone . '<br />' . $usrlist->u_phone1; ?>
                            </td>
                            <td>
                                <?php if($usrlist->r_id == 1) { 
                                    echo 'Purchase Manager';
                                } elseif($usrlist->r_id == 2) { 
                                    echo 'Sales Manager';
                                } elseif($usrlist->r_id == 3) { 
                                    echo 'Administration';
                                }
                                ?>
                            </td>
                            <td>
                                <?php echo $usrlist->Branch; ?>
                            </td>
                            <td class="center-align-text hidden-phone">
                                <a href="<?php echo site_url('settings/edtusr?func=edit_user&cat=settings&sess_auth=' . md5('Ymshis')  . '&col=' . rand(1, 1500) . '&user=' . $usrlist->u_id); ?>"><i class="icon-edit"></i></a>
                            </td>
                        </tr>
                        <?php $sl++; } } ?>
                    </tbody>
                </table>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body center-align-text">
                <a href="<?php echo site_url('settings/newsoftusr'); ?>" class="btn btn-primary">Click Here for a New User</a>
            </div>
        </div>
    </div>
</div>