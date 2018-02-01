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
                    <?php widgetHeader(); ?> Employee Salary Posting
                </div>
            </div>
            <div class="widget-body"><?php notification(); ?></div>
            <div class="widget-body form-horizontal">
                <div class="span6">
                    <table class="table table-bordered table-condensed">
                        <tbody>
                            <tr>
                                <td style="width: 35%;">Name</td>
                                <td style="width: 65%;">
                                    <h4><?php echo $detls->emp_name; ?></h4>
                                </td>
                            </tr>
                            <tr>
                                <td>Father</td>
                                <td>
                                    <?php echo $detls->emp_father; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Contact</td>
                                <td>
                                    <p><?php echo $detls->emp_mobile_no . '<br />' . $detls->emp_phone_no; ?> </p>
                                </td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>
                                    <?php echo $detls->emp_address; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Monthly Salary
                                </td>
                                <td>
                                    <?php echo bdt() . number_format($detls->emp_monthly_salary, 2, ".", ","); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Daily Salary
                                </td>
                                <td>
                                    <?php echo bdt() . number_format($detls->emp_daily_salary, 2, ".", ","); ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Work Day
                                </td>
                                <td>
                                    <?php echo $detls->emp_monthly_working; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="span6 form-horizontal">
                    <form action="<?php echo site_url('employee/salaryposting'); ?>" method="POST">
                    <div class="control-group">
                        <label class="control-label">Month</label>
                        <div class="controls controls-row">
                            <select class="span12" id="month" name="month" required="required">
                                <option value="">Select a Month</option>
                                <option value="01" <?php if(date('m') == '01') { echo 'selected'; } ?>>January</option>
                                <option value="02" <?php if(date('m') == '02') { echo 'selected'; } ?>>February</option>
                                <option value="03" <?php if(date('m') == '03') { echo 'selected'; } ?>>March</option>
                                <option value="04" <?php if(date('m') == '04') { echo 'selected'; } ?>>April</option>
                                <option value="05" <?php if(date('m') == '05') { echo 'selected'; } ?>>May</option>
                                <option value="06" <?php if(date('m') == '06') { echo 'selected'; } ?>>June</option>
                                <option value="07" <?php if(date('m') == '07') { echo 'selected'; } ?>>July</option>
                                <option value="08" <?php if(date('m') == '08') { echo 'selected'; } ?>>August</option>
                                <option value="09" <?php if(date('m') == '09') { echo 'selected'; } ?>>September</option>
                                <option value="10" <?php if(date('m') == '10') { echo 'selected'; } ?>>October</option>
                                <option value="11" <?php if(date('m') == '11') { echo 'selected'; } ?>>November</option>
                                <option value="12" <?php if(date('m') == '12') { echo 'selected'; } ?>>December</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Year</label>
                        <div class="controls controls-row">
                            <input type="number" name="year" id="year" value="<?php echo date('Y'); ?>" placeholder="Year" class="span12" required="required" />
                        </div>
                    </div>
                    <div id="salary_info" class="control-group">
                        <div class="controls controls-row">
                            <p><?php echo $salary_info; ?></p>
                            <?php
                            if($attendance != FALSE) { $hajira = $attendance->num_rows(); } else { $hajira = 0; }
                            $salary = round($detls->emp_daily_salary * $hajira);
                            ?>
                            <h5>Attendance: <?=$hajira?> Days</h5>
                            <h4>Salary: <?php echo bdt() . number_format($salary, 2, ".", ","); ?></h4>
                            <h6>Paid Amount: <?php echo bdt() . number_format($paid_salary, 2, ".", ","); ?></h6>
                            <?php $remaining = $salary - $paid_salary; ?>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Paid Amount</label>
                            <div class="controls controls-row">
                                <?php if($starting <= date('Y-m-d')) { ?>
                                <input type="number" class="span12" name="amount" required="required" max="<?php echo $remaining; ?>" min="1" placeholder="Paid Amount" autocomplete="off" />
                                <?php } else if ($starting >= date('Y-m-d')) { ?>
                                <input type="number" class="span12" name="amount" required="required" max="<?php echo $detls->emp_monthly_salary; ?>" min="1" placeholder="Paid Amount" autocomplete="off" />
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Method</label>
                        <div class="controls controls-row">
                            <select name="method" id="method" required="required" class="span12">
                                <option value="">Select Payment Method</option>
                                <?php if($method != FALSE) { foreach($method->result() as $method) {    ?>
                                <option value="<?php echo $method->tble_id; ?>">
                                    <?php echo $method->method; ?>
                                </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Remarks</label>
                        <div class="controls controls-row">
                            <input type="text" class="span12" name="remarks" placeholder="Salary Remarks/Notes" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <h4>Cash will be minus from Central Depot</h4>
                        <input type="button" class="btn btn-primary btn-warning" value="Calculate Salary" id="calculate_salary" />
                        <input type="submit" class="btn btn-primary btn-info" value="Post Salary" id="post_salary" />
                        <input type="hidden" name="emp_id" value="<?php echo $detls->tble_id; ?>" />
                        <input type="hidden" name="trigger" value="employee/salaryposting" />
                        <a href="<?php echo site_url('employee/list'); ?>" class="btn btn-default">Back to List</a>
                    </div>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#calculate_salary").click(function(){
        var month = $("#month").val();
        var year  = $("#year").val();
        
        if(month === "" || year === ""){
            alert("Please select a month or a year");
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('employee/get_employee_salary'); ?>",
                data: { month: month, year: year, cl_id: "<?php echo $detls->tble_id; ?>" },
                cache: false,
                beforeSend: function(){
                    $('#salary_info').html(
                    '<tr><td colspan="2" class="center-align-text"><img src="<?php echo $img . 'ajaxloader.gif'; ?>" style="" /></td></tr>'
                    );
                },
                success: function(html){
                    $("#salary_info").html(html);
                } 
           });
        }
    });
</script>