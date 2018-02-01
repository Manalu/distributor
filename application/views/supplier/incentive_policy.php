<?php

/**
 * Description of incentive_policy
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
?>
<div class="row-fluid">
    <div class="span8">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Incentive Policy List
                </div>
            </div>
            <div class="widget-body">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 5%;">
                                SL.
                            </th>
                            <th style="width: 20%;">
                                Company
                            </th>
                            <th style="width: 5%; text-align: center;">
                                Month
                            </th>
                            <th style="width: 5%; text-align: center;">
                                Year
                            </th>
                            <th style="width: 15%;">
                                Policy
                            </th>
                            <th style="text-align: right; width: 15%;">
                                Target
                            </th>
                            <th style="text-align: right; width: 20%;">
                                Incentive
                            </th>
                            <th style="width: 15%;">
                                Type
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($incentive != FALSE) { $sl = 1; foreach($incentive->result() as $incentive) { ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php echo $sl; ?>
                            </td>
                            <td>
                                <?php echo $incentive->Company; ?>
                            </td>
                            <td class="center-align-text">
                                <?php echo $incentive->Month; ?>
                            </td>
                            <td class="center-align-text">
                                <?php echo $incentive->Year; ?>
                            </td>
                            <td>
                                <?php echo $incentive->Policy; ?>
                            </td>
                            <td style="text-align: right;">
                                <?php echo bdt() . number_format($incentive->Target, 2, ".", ","); ?>
                            </td>
                            <td style="text-align: right;">
                                <?php if($incentive->Type === "Percentage") {
                                    echo number_format($incentive->Incentive, 2, ".", ",") . "%";
                                } else if($incentive->Type === "Fixed") {
                                    echo bdt() . number_format($incentive->Incentive, 2, ".", ",");
                                } ?>
                            </td>
                            <td>
                                <?php echo $incentive->Type; ?>
                            </td>
                        </tr>
                        <?php $sl++; } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Setup New Incentive Policy
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <form action="<?php echo site_url('supplier/incentivepolicy'); ?>" class="form-horizontal" method="POST">
                    <div class="control-group">
                        <label class="control-label">Supplier</label>
                        <div class="controls controls-row">
                            <select class="span12" id="company_id" name="company_id" required="required">
                                <option value="">Select a Supplier</option>
                                <?php if($sups != FALSE) { foreach ($sups->result() as $sups) { ?>
                                <option value="<?php echo $sups->c_id; ?>"><?php echo $sups->c_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Month</label>
                        <div class="controls controls-row">
                            <select class="span12" id="month" name="month" required="required">
                                <option value="">Select </option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Year</label>
                        <div class="controls controls-row">
                            <select class="span12" id="year" name="year" required="required">
                                <option value="">Select </option>
                                <?php for($i = date('Y'); $i <= 2025; $i++) { ?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Policy</label>
                        <div class="controls controls-row">
                            <select class="span12" id="policy" name="policy" required="required">
                                <option value="">Select </option>
                                <option value="Sales">Sales</option>
                                <option value="Payment">Payment</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Target</label>
                        <div class="controls controls-row">
                            <input type="number" id="target" name="target" placeholder="Incentive On Amount" class="span12" required="required" step="any" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Incentive</label>
                        <div class="controls controls-row">
                            <input type="number" id="incentive" name="incentive" placeholder="Incentive Value" class="span12" required="required" step="any" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Type</label>
                        <div class="controls controls-row">
                            <select class="span12" id="type" name="type" required="required">
                                <option value="">Select </option>
                                <option value="Percentage">Percentage</option>
                                <option value="Fixed">Fixed</option>
                            </select>
                        </div>
                    </div>
                    <hr />
                    <div class="form-actions">
                        <input type="hidden" name="trigger" value="incentive_policy" />
                        <button type="submit" class="btn btn-primary">Save </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>