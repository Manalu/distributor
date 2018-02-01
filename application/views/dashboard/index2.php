



<?php if($this->session->flashdata('agedata')) { ?>
<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-body">
                <p><?php echo $this->session->flashdata('agedata'); ?></p>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="row-fluid">
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <img src="<?php echo $img; ?>refresh.png" class="pointer" title="Click to Refresh The Widget" alt="Refresh Widget" onclick="getRefreshTodaysSalesInformationWidget('<?php echo base_url() . 'dashboard/saleswidget';?>','<?php echo base_url() . 'img/ajaxloader.gif'; ?>')" /> Today's Sales Information
                </div>
            </div>
            <div class="widget-body" id="todaysalesresult">
                <table class="table table-condensed table-bordered no-margin">
                    <thead>
                        <tr>
                            <th>Information</th>
                            <th style="text-align: right;">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="success">
                            <td><b>Total Sales</b></td>
                            <td style="text-align: right;">
                                <?php 
                                if($paidsales != NULL) {
                                    echo bdt() . number_format($paidsales, 2);
                                } else { 
                                    echo bdt() . '0.00';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="info">
                            <td><b>Due Sales</b></td>
                            <td style="text-align: right;">
                                <?php
                                if($dueinvcs != FALSE) { 
                                    echo bdt() . number_format($dueinvcs, 2);
                                } else { 
                                    echo bdt() . '0.00';
                                } 
                                ?>
                            </td>
                        </tr>
                        <tr class="success">
                            <td><b>Card Sales</b></td>
                            <td style="text-align: right;">
                                <?php
                                if($cardsales != NULL) {
                                    echo bdt() . number_format($cardsales, 2);
                                } else { 
                                    echo bdt() . '0.00';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="success">
                            <td><b>Free of Cost</b></td>
                            <td style="text-align: right;">
                                <?php
                                if($zerosales != NULL) {
                                    echo bdt() . number_format($zerosales, 2);
                                } else { 
                                    echo bdt() . '0.00';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="error" colspan="2" style="height: 17px;"></td>
                        </tr>
                        <tr class="warning">
                            <td><b>Cash Collection</b></td>
                            <td style="text-align: right;">
                                <?php
                                if($cashin != NULL ) { 
                                    echo bdt() . number_format($cashin, 2);
                                } else { 
                                    echo bdt() . '0.00';
                                } 
                                ?>
                            </td>
                        </tr>
                        <tr class="error">
                            <td><b>Cash Out</b></td>
                            <td style="text-align: right;">
                                <?php
                                if($cashout != NULL ) { 
                                    echo bdt() . number_format(abs($cashout), 2);
                                } else { 
                                    echo bdt() . '0.00';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr class="error">
                            <td><b>Cash In-Hand</b></td>
                            <td style="text-align: right;">
                                <?php
                                if($cashbalance != NULL ) { 
                                    echo bdt() . number_format(abs($cashbalance), 2);
                                } else { 
                                    echo bdt() . '0.00';
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe0b5;"></span> Medicine Stock
                </div>
            </div>
            <div class="widget-body">
                <table class="table table-condensed table-bordered no-margin">
                    <tbody>
                        <tr class="success">
                            <th>
                                Cumulative Stock for sales value
                            </th>
                            <th style="text-align: right;" colspan="2">
                            <?php
                            $FourtyPercent = (($cashvalue * 40) / 100);
                            echo number_format($cashvalue, 2, ".", ","); //echo number_format($FourtyPercent, 2, ".", ",");
                            ?>
                            </th>    
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe0b5;"></span> Due Collection
                </div>
                <a href="<?php echo site_url('sales/duesales'); ?>" data-original-title="" class="pull-right">View All</a>
            </div>
            <div class="widget-body">
                <table class="table table-condensed table-bordered no-margin">
                    <thead>
                        <tr>
                            <th class="center-align-text">Memo No.</th>
                            <th style="text-align: right;">Outstanding</th>
                            <th>Sale Date</th>
                            <th>Salesman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($duesaleslst != FALSE) { foreach ($duesaleslst->result() as $duesaleslst) { ?>
                        <tr>
                            <td class="center-align-text"> <a href="<?php echo site_url('sales/details/' . $duesaleslst->InvoiceID); ?>"><?php echo $duesaleslst->InvoiceID; ?></a></td>
                            <td style="text-align: right;"> <?php echo bdt(). number_format(($duesaleslst->Billed - getPaidAmountForEachInvoiceByInvoiceId($duesaleslst->InvoiceID)), 2); ?></td>
                            <td class="" title="<?php echo $duesaleslst->InvocieDate; ?>"><?php echo date_format(date_create($duesaleslst->InvocieDate), "d-M-Y"); //calculateHowLongAgo(); ?></td>
                            <td><?php echo $duesaleslst->User; ?></td>
                        </tr>
                        <?php } } else { ?>
                        <tr>
                            <td class="warning center-align-text" colspan="5"><?php //echo $duesaleslst->num_rows(); ?>  No Due Sales!!</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="clearfix">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe0b5;"></span> Last 10 Login
                </div>
            </div>
            <div class="widget-body">
                <table class="table table-condensed table-bordered no-margin">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Login</th>
                            <th>Logout Time</th>
                            <th style="text-align: right;">Today's Sale</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($logdata != FALSE) { foreach ($logdata->result() as $logdata) { ?>
                        <tr>
                            <td><?php echo getUserName($logdata->u_id); ?></td>
                            <td><?php echo getLastLoginTimeByUserId($logdata->u_id); ?></td>
                            <td><?php echo getLastLogoutTimeByUserId($logdata->u_id); ?></td>
                            <td style="text-align: right;"><?php echo bdt() . number_format(getTodaysSaleForEachUserByUserId($logdata->u_id), 2, ".", ","); ?></td>
                        </tr>    
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe0b5;"></span> Orders to be received
                </div>
                <a href="<?php echo site_url('order/orderlist'); ?>" data-original-title="" class="pull-right">View All</a>
            </div>
            <div class="widget-body">
                <table class="table table-bordered table-condensed table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="text-align: center;"> SL. </th>
                            <th> Company </th>
                            <th style="text-align: center;"> Placed </th>
                            <th style="text-align: center;"> Details </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($orders != FALSE){ $sl = 1; foreach ($orders->result() as $orders) {  ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $sl; ?></td>
                            <td><?php echo $orders->company; ?></td>
                            <td style="text-align: center;">
                                <?php $d8Obj = new DateTime($orders->date); echo $d8Obj->format("d M - Y"); ?>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?php echo site_url("order/details/" . $orders->id);?>" target="_blank">
                                    <i class="icon-profile"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $sl++; } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>