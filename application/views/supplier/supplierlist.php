


<div class="row-fluid">
    <div class="span12">
        <div class="widget no-margin">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Supplier or Company List
                </div>
            </div>
            <div id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <div class="widget-body">
                    <table class="table table-condensed table-striped table-hover table-bordered pull-left">
                        <thead>
                            <tr>
                                <th style="width: 5%;" class="center-align-text">SL.</th>
                                <th style="width: 17%;">Name</th>
                                <th style="width: 10%;">Contact</th>
                                <th style="width: 10%;">Phone</th>
                                <th style="width: 10%;">Mobile</th>
                                <th style="width: 15%;">Address</th>
                                <th style="width: 17%; text-align: right;">Balance</th>
                                <th style="width: 5%;" class="center-align-text noprint">Ledger</th>
                                <?php if($role == 3) { ?>
                                <th style="width: 5%;" class="center noprint">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id ="medtable">
                            <?php if($company != FALSE){$total = 0; $sl = 1; foreach ($company->result() as $comp) {?>
                            <tr>
                                <td class="center-align-text"><?php echo $sl; ?></td>
                                <td><?php echo $comp->c_name; ?></td>
                                <td><?php echo $comp->c_contact; ?></td>
                                <td><?php echo $comp->c_phone; ?></td>
                                <td><?php echo $comp->c_mobile; ?></td>
                                <td><?php echo $comp->c_address; ?></td>
                                <td style="text-align: right;">
                                    <?php $total = $total + $comp->Balance; ?>
                                    <?php echo bdt() . number_format($comp->Balance, 2, ".", ","); ?>
                                </td>
                                <td class="hidden-phone center-align-text noprint">
                                    <a href="<?php echo site_url("supplier/ledger?sess_auth=" . md5(date("Ymdhis")) . "&func=ledger&route=supplier&c_id=" . $comp->c_id . "&prekkha=" . url_title($comp->c_name, "-", TRUE) . "&supplier=" . md5($comp->c_id));?>">
                                        <i class="icon-profile"></i>
                                    </a>
                                </td>
                                <?php if($role == 3) { ?>
                                <td class="hidden-phone center-align-text noprint">
                                    <a href="<?php echo site_url("supplier/updatesupplier?sess_auth=" . md5(date("Ymdhis")) . "&func=outstanding&cat=supplier&c_id=" . $comp->c_id . "&prekkha=" . url_title($comp->c_name, "-", TRUE) . "&supplier=" . md5($comp->c_id));?>">
                                        <i class="icon-edit"></i>
                                    </a>
                                </td>
                                <?php } ?>
                            </tr>
                          <?php $sl++; } ?>
                            <tr>
                                <th style="text-align: right;" colspan="6">Total</th>
                                <th style="text-align: right;"><?php echo bdt() . number_format($total, 2, ".", ","); ?></th>
                                <th colspan="2"></th>
                            </tr>
                          <?php } ?>
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