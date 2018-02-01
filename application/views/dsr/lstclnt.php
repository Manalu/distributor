


<div class="row-fluid">
    <div class="span12">
        <div class="widget no-margin">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Search DSR List
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="clearfix"></div>
            <div class="widget-body">
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label"> Name</label>
                        <div class="controls controls-row">
                            <input name="cl_name" id="cl_name" class="span12" placeholder="Name" type="text" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label"> Phone</label>
                        <div class="controls controls-row">
                            <input name="cl_present_a" id="cl_present_a" class="span12" placeholder="Phone" type="text" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label"> Mobile</label>
                        <div class="controls controls-row">
                            <input name="cl_mobile_no" id="cl_mobile_no" class="span12" placeholder="Mobile" type="text" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">National ID</label>
                        <div class="controls controls-row">
                            <input name="cl_national_id" id="cl_national_id" class="span12" placeholder="National ID" type="text" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="span12 center-align-text">
                    <button type="button" class="btn btn-primary" id="customer_list_search_button">Search DSR Details</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <div class="widget-body">
                    <table class="table table-condensed table-striped table-hover table-bordered pull-left">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;">SL</th>
                                <th style="width: 20%;">Name</th>
                                <th style="width: 15%;">Phone</th>
                                <th style="width: 10%;">Mobile</th>
                                <th style="width: 15%;">National ID</th>
                                <th style="width: 19%; text-align: right;">Receivable</th>
                                <th style="width: 5%; text-align: center;" class="noprint">Ledger</th>
                                <?php if($role == 3) { ?>
                                <th style="width: 5%; text-align: center;" class="noprint">Edit</th>
                                <th style="width: 6%; text-align: center;" class="noprint">Adjust</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="customer_list_body">
                            <?php if($clnts != FALSE) { $total = 0; $sl = 1; foreach ($clnts->result() as $clnts) {?>
                            <tr>
                                <td class="center-align-text">
                                    <?php echo $sl; ?>
                                </td>
                                <td>
                                    <?php echo $clnts->cl_name; ?>
                                </td>
                                <td>
                                    <?php echo $clnts->cl_phone_no; ?>
                                </td>
                                <td>
                                    <?php echo $clnts->cl_mobile_no; ?>
                                </td>
                                <td>
                                    <?php echo $clnts->cl_national_id; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php $total = $total + $clnts->cl_balance; ?>
                                    <?php echo bdt() . number_format($clnts->cl_balance, 2, ".", ","); ?>
                                </td>
                                <td class="center-align-text noprint">
                                    <a href="<?php echo site_url("dsr/ledger?func=details&cat=clients&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->cl_id);?>">
                                        <i class="icon-profile"></i>
                                    </a>
                                </td>
                                <?php if($role == 3) { ?>
                                <td class="center-align-text noprint">
                                    <a href="<?php echo site_url("dsr/update?func=update&cat=clients&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->cl_id);?>">
                                        <i class="icon-edit"></i>
                                    </a>
                                </td>
                                <td class="center-align-text noprint">
                                    <a href="<?php echo site_url("dsr/adjust?func=adjust&cat=clients&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->cl_id);?>">
                                        <i class="icon-adjust"></i>
                                    </a>
                                </td>
                                <?php } ?>
                            </tr>
                          <?php $sl++; } ?> 
                            <tr>
                                <td colspan="5" style="text-align: right;">Total</td>
                                <td style="text-align: right;"><?php echo bdt() . number_format($total, 2, ".", ","); ?></td>
                                <td colspan="3"></td>
                            </tr>
                          <?php   } ?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                </div>
                <?php include 'application/views/common/marketing.php'; ?>
            </div>
            <?php include 'application/views/common/printer.php'; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#customer_list_search_button").click(function(){
        var clname      = $("#cl_name").val();
        var phone       = $("#cl_present_a").val();
        var mobile      = $("#cl_mobile_no").val();
        var natid       = $("#cl_national_id").val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('dsr/search_customer_list'); ?>",
            data: {clname: clname, clphone: phone, clmobile: mobile, natid: natid},
            cache: false,
            beforeSend: function(){
              $('#customer_list_body').html(
                  '<tr><td colspan="9" style="text-align: center;"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" /></td></tr>'
              );
            },
            success: function(html){
                $("#customer_list_body").html(html);
            },
            error:function(html){
                $("#customer_list_body").html(html.responseText);
            }
        });
    });
</script>