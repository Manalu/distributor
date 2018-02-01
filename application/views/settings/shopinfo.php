



<div class="row-fluid">
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe100;"></span> Store Closing
                </div>
            </div>
            <div class="widget-body">
                <div id="closinginfo">
                    <p>Formula for cash in hand</p>
                    <h4>(Total Cashin of the day + Previous Cash in hand) - Cash out of the day</h4>
                </div>
                <div class="center-align-text">
                    <input type="button" id="calculateClosingInfo" value="Close the day" class="btn btn-warning" />
                    <p><b style="color: #FF0000;">It's <?php echo date("l, jS F, Y"); ?></b></p>
                </div>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe100;"></span> Previous Closing
                </div>
            </div>
            <div class="widget-body">
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Balance</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($closing != FALSE) { foreach ($closing->result() as $closing) { ?>
                        <tr>
                            <td><?php echo $closing->cl_date; ?></td>
                            <td><?php echo '&#2547; ' . number_format($closing->cl_balance, 2, ".", ","); ?></td>
                            <td><?php echo getUserName($closing->cl_usr); ?></td>
                        </tr>
                        <?php } } else { ?>
                        <tr>
                            <td colspan="3" class="center-align-text">Nothing!!</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
<!--    <div class="span6" id="synchpanel">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe100;"></span> Backup & Synchronization
                </div>
            </div>
            <div class="widget-body" style="max-height: 170px;">
                <div class="full">
                    <div class="span6 center-align-text">
                        <img class="" src="<?php //echo $img; ?>database-parts.jpg" alt="Backup & Synchronization" title="Backup & Synchronization" width="150" height="150" />
                    </div>
                    <div class="span6 center-align-text vertical-align-mid">
                        <h3 id="synchpanelnotify">Last Synchronization: <?php //echo $info[0]->shp_backup; ?></h3>
                        <button class="btn span12 btn-success" id="backupbutton">Back Up</button>
                    </div>                    
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>-->
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe100;"></span> Store Information
                </div>
            </div>
            <div class="widget-body">
                <div class="stylish-lists">
                    <dl class="dl-horizontal no-margin">
                        <dt  class="text-info">Store Name</dt>
                        <dd><?php echo $info[1]->shp_name; ?></dd>
                        <dt class="text-info">Address</dt>
                        <dd><?php echo $info[1]->shp_adrs; ?></dd>
                        <dt class="text-info">Phone</dt>
                        <dd><?php echo $info[1]->shp_phn1; ?></dd>
                        <dt class="text-info">Mobile</dt>
                        <dd><?php echo $info[1]->shp_phn2; ?></dd>
                        <dt class="text-info">Operation</dt>
                        <dd><?php echo $info[1]->shp_hr; ?></dd>
                    </dl>
                    <hr />
                    <?php if($memb == 104) {
                        $TotalPrice = 0;
                        if($company != FALSE) {
                            foreach ($company->result() as $company) { 
                                $TotalPrice += getAllMedicineIdByCompany($company->c_id);
                            }
                        }
                    ?>
                    <dl class="dl-horizontal no-margin">
                        <dt  class="text-info">Medicine in Stock</dt>
                        <dd><?php echo number_format($TotalPrice, 2, ".", ","); ?></dd>
                    </dl>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#backupbuttonn").click(function(){
        $.ajax({
           type: "POST",
           url: "<?php  echo base_url() . 'settings/databackup'; ?>",
           data: {datentime: <?php echo date("Y-m-d"); ?>},
           cache: false,
           beforeSend: function(){
              $('#synchpanelnotify').html(
                  '<img src="<?php echo base_url(); ?>/img/ajaxloader.gif" />'
              );
           },
           success: function(html){
              window.location = "<?php echo base_url() . 'sql/'; ?>" + html + ".zip";
              $("#synchpanelnotify").html("Successfull!!");
           } 
        });
    });
    $("#calculateClosingInfo").click(function(){
        $.ajax({
            type: "POST",
            url: "<?php  echo base_url() . 'settings/dayclosing'; ?>",
            data: {datentime: <?php echo date("Y-m-d"); ?>},
            cache: false,
            beforeSend: function(){
                $('#closinginfo').html(
                    '<img src="<?php echo base_url(); ?>/img/ajaxloader.gif" />'
                );
            },
            success: function(html){
                $("#closinginfo").html(html);
            }
        });
    });
</script>