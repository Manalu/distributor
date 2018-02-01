<?php

/**
 * Description of attendance
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Submit Employee Attendance
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <h4>Attendance For: </h4> <?php echo date('d-M-Y'); ?>
                <br />Total Employee: <?php echo $total; ?>
                <br />Uncheck the box of the employee who is not present
            </div>
            <form action="<?php echo site_url('employee/attendance'); ?>" method="POST">
                <div class="widget-body">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="text-align: center;">SL. </th>
                                <th>Name</th>
                                <th>Father</th>
                                <th>Address</th>
                                <th style="text-align: right;">Balance</th>
                                <th style="text-align: right;">Daily</th>
                                <!--<th style="text-align: right;">Final</th>-->
                                <th style="text-align: center;">Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($empls != FALSE) { $sl = 1; foreach ($empls->result() as $empls) { ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $sl; ?></td>
                                <td><?php echo $empls->emp_name; ?></td>
                                <td><?php echo $empls->emp_father; ?></td>
                                <td><?php echo $empls->emp_address; ?></td>
                                <td style="text-align: right;" class="vertical-align-mid">
                                    <?php echo bdt() . number_format($empls->emp_opening_balance, 2, ".", ","); ?>
                                </td>
                                <td style="text-align: right;" class="vertical-align-mid">
                                    <?php echo bdt() . number_format($empls->emp_daily_salary, 2, ".", ","); ?>
                                </td>
<!--                                <td style="text-align: right;" class="vertical-align-mid">
                                    <?php // $final = $empls->emp_opening_balance + $empls->emp_daily_salary; ?>
                                    <?php // echo bdt() . number_format($final, 2, ".", ","); ?>
                                </td>-->
                                <td style="text-align: center;">
                                    <input type="checkbox" name="tble_id[]" value="<?php echo $empls->tble_id; ?>" checked="checked" />
                                    <input type="hidden" name="working[]" value="<?php echo $empls->emp_monthly_working; ?>" />
                                    <input type="hidden" name="amount[]" value="<?php echo $empls->emp_daily_salary; ?>" />
                                    <!--<input type="hidden" name="balance[]" value="<?php //echo $final; ?>" />-->
                                </td>
                            </tr>
                            <?php $sl++; } } ?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                </div>
                <div class="widget-body form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="emp_joining_date"></label>
                        <div class="controls">
                            <input name="attendance_date" id="attendance_date" class="span12" readonly="readonly" value="<?php echo date('Y-m-d'); ?>" type="text" required="required">
                        </div>
                    </div>
                    <script>
                        $(function() {
                            $("#attendance_date").datepicker({format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: "<?php echo date('Y-m-d') ?>"});
                        });
                    </script>
                    <div class="form-actions">
                        <h4>This closing can not be re-done, So please re-check before you submit.</h4>
                        <input type="hidden" name="trigger" value="employeeattendance">
                        <button type="submit" class="btn btn-info" onclick="return checking()">Submit Attendance</button>
                        <a href="<?php echo site_url('employee/list'); ?>" class="btn btn-default" data-original-title="">Back to List</a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function checking(){
        var r = confirm("Are you sure you want to submit? This can not be un-done");
        if(r){
            return true;
        } else {
            return false;
        }
    }
</script>