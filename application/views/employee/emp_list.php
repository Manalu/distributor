


<div class="row-fluid">
    <div class="span12">
        <div class="widget no-margin">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Search Employee List
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
                    <button type="button" class="btn btn-primary" id="customer_list_search_button">Search Employee Details</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <div class="widget-body">
                    <table class="table table-condensed table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;">SL</th>
                                <th style="width: 15%;">Name</th>
                                <th style="width: 11%;">Father</th>
                                <th style="width: 11%;">Address</th>
                                <th style="width: 12%;">Contact</th>
                                <th style="width: 11%; text-align: right;">Balance</th>
                                <th style="width: 10%; text-align: right;">Daily</th>
                                <th style="width: 5%; text-align: center;">Attend</th>
                                <th style="width: 5%; text-align: center;" class="noprint">Salary</th>
                                <th style="width: 5%; text-align: center;" class="noprint">Edit</th>
                                <!--<th style="width: 5%; text-align: center;" class="noprint">Adjust</th>-->
                                <th style="width: 5%; text-align: center;" class="noprint">Ledger</th>
                            </tr>
                        </thead>
                        <tbody id="customer_list_body">
                            <?php if($clnts != FALSE) { $sl = 1; foreach ($clnts->result() as $clnts) {?>
                            <tr>
                                <td class="center-align-text vertical-align-mid">
                                    <?php echo $sl; ?>
                                </td>
                                <td class="vertical-align-mid">
                                    <?php
                                    if($clnts->emp_status == 1) { ?>
                                        <b style="color: green;">
                                            <?php echo $clnts->emp_name; ?>
                                        </b>
                                    <?php } else if($clnts->emp_status == 2) { ?>
                                        <b style="color: red;">
                                            <?php echo $clnts->emp_name; ?>
                                        </b>
                                    <?php } ?>
                                </td>
                                <td class="vertical-align-mid">
                                    <?php echo $clnts->emp_father; ?>
                                </td>
                                <td class="vertical-align-mid">
                                    <?php echo $clnts->emp_address; ?>
                                </td>
                                <td class="vertical-align-mid">
                                    <?php echo $clnts->emp_phone_no . '<br />' . $clnts->emp_mobile_no; ?>
                                </td>
                                <td style="text-align: right;" class="vertical-align-mid">
                                    <?php echo bdt() . number_format($clnts->emp_opening_balance, 2, ".", ","); ?>
                                </td>
                                <td style="text-align: right;" class="vertical-align-mid">
                                    <?php echo bdt() . number_format($clnts->emp_daily_salary, 2, ".", ","); ?>
                                </td>
                                <td class="vertical-align-mid noprint center-align-text">
                                    <a href="<?php echo site_url("employee/attendance_sheet?func=attendance_sheet&cat=employee&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->tble_id);?>">
                                        <?php echo calculate_employee_attendance($clnts->tble_id, date('Y-m-01'), date('Y-m-t')); ?>
                                    </a>
                                </td>
                                <td class="vertical-align-mid noprint center-align-text">
                                    <a href="<?php echo site_url("employee/salaryposting?func=salary&cat=employee&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->tble_id);?>">
                                        <i class="icon-user"></i>
                                    </a>
                                </td>
                                <td class="vertical-align-mid noprint center-align-text">
                                    <a href="<?php echo site_url("employee/update?func=update&cat=employee&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->tble_id);?>">
                                        <i class="icon-edit"></i>
                                    </a>
                                </td>
<!--                                <td class="vertical-align-mid noprint center-align-text">
                                    <?php //if($b_id == 1) { ?>
                                    <a href="<?php //echo site_url("employee/adjust?func=adjust&cat=employee&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->tble_id . '&type=' . $clnts->emp_balance_type);?>">
                                    <?php //} else { ?>
                                    <a>
                                    <?php //} ?>
                                        <i class="icon-adjust"></i>
                                    </a>
                                </td>-->
                                <td class="vertical-align-mid noprint center-align-text">
                                    <a href="<?php echo site_url("employee/ledger?func=ledger&cat=employee&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&cl_id=" . $clnts->tble_id);?>">
                                        <i class="icon-profile"></i>
                                    </a>
                                </td>
                            </tr>
                          <?php $sl++; } } ?>
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
            url: "<?php echo site_url('employee/search_employee_list'); ?>",
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