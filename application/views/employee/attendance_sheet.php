<?php

/**
 * Description of attendance_sheet
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Employee Attendance Sheet
                </div>
            </div>
            <div class="widget-body">
                <div class="span6 form-horizontal">
                    <div class="control-group no-margin">
                        <label class="control-label"></label>
                        <div class="controls controls-row">
                            <h4><?php echo $detls->emp_name; ?></h4>
                        </div>
                    </div>
                    <div class="control-group no-margin">
                        <label class="control-label"></label>
                        <div class="controls controls-row">
                            <p><?php echo $detls->emp_father; ?> </p>
                        </div>
                    </div>
                    <div class="control-group no-margin">
                        <label class="control-label"></label>
                        <div class="controls controls-row">
                            <p><?php echo $detls->emp_mobile_no . '<br />' . $detls->emp_phone_no; ?> </p>
                        </div>
                    </div>
                    <div class="control-group no-margin">
                        <label class="control-label"></label>
                        <div class="controls controls-row">
                            <p><?php echo $detls->emp_address; ?> </p>
                        </div>
                    </div>
                </div>
                <div class="span6 form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Month</label>
                        <div class="controls controls-row">
                            <select class="span12" id="month" name="month">
                                <option value="">Select a Month</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Year</label>
                        <div class="controls controls-row">
                            <input type="number" name="year" id="year" value="<?php echo date('Y'); ?>" placeholder="Year" class="span12" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="button" class="btn btn-primary btn-info" value="View Attendance Sheet" id="attendance_sheet_button" />
                        <a href="<?php echo site_url('employee/list'); ?>" class="btn btn-default">Back to List</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center;">
                                SL.
                            </th>
                            <th>
                                Date
                            </th>
                            <th class="center-align-text">
                                Delete
                            </th>
                        </tr>
                    </thead>
                    <tbody id="attendance_sheet">
                        <?php if($attendance != FALSE) { $sl = 1; foreach($attendance->result() as $attendance) { ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php echo $sl; ?>
                            </td>
                            <td>
                                <?php echo date_format(date_create($attendance->attendance), 'd-M-Y') ?>
                            </td>
                            <td class="center-align-text">
                                <a href="<?php echo site_url("employee/dltatn?func=remove_attendance&cat=employee&mod=admin&sess_auth=" . md5(date("Ymdhis")) . "&remote=" . md5("autosol") . "&emp_id=" . $attendance->emp_id . "&remove=" . $attendance->attendance); ?>">
                                    <i class="icon-remove"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $sl++; } } else { ?>
                        <tr>
                            <td colspan="3" class="center-align-text">
                            <?php echo errormessage('No records found!!'); ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#attendance_sheet_button").click(function(){
        var month = $("#month").val();
        var year  = $("#year").val();
        
        if(month === "" || year === ""){
            alert("Please select a month or a year");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('employee/get_attendance_sheet'); ?>",
                data: { month: month, year: year, cl_id: "<?php echo $detls->tble_id; ?>" },
                cache: false,
                beforeSend: function(){
                    $('#attendance_sheet').html(
                    '<tr><td colspan="2" class="center-align-text"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" style="" /></td></tr>'
                    );
                },
                success: function(html){
                    $("#attendance_sheet").html(html);
                } 
           });
        }
    });
</script>