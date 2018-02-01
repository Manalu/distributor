<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <?php widgetHeader(); ?> Expense List of latest transactions
                </div>
            </div>
            <div class="widget-body">
                <?php notification(); ?>
            </div>
            <div class="widget-body">
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label" for="from">From</label>
                        <div class="controls controls-row">
                            <input type="text" name="starting" id="starting" class="span12" readonly="readonly" value="<?php echo date('Y-m-01'); ?>" />
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label" for="from">From</label>
                        <div class="controls controls-row">
                            <input type="text" name="endingday" id="endingday" class="span12" readonly="readonly" value="<?php echo date('Y-m-t'); ?>" />
                        </div>
                    </div>
                </div>
                
                <script>
                    $(function() {
                        $("#starting").datepicker({ format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: "<?php echo date("Y-m-d"); ?>"});
                        $("#endingday").datepicker({ format: "yyyy-mm-dd", autoclose: true, todayHighlight: true, endDate: "<?php echo date("Y-m-d"); ?>"});
                    });
                </script>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label" for="group">Head </label>
                        <div class="controls controls-row">
                            <select id="status" class="span12" name="status">
                                <option value="">Ledger Head...</option>
                                <?php foreach($purpoz->result() as $purpoz) { ?>
                                <option value="<?php echo $purpoz->id; ?>"><?php echo $purpoz->ledger; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span3 form-inline">
                    <div class="control-group">
                        <label class="control-label">Branch</label>
                        <div class="controls controls-row">
                            <select class="span12" name="source" id="source" required="required">
                                <option value="">Branch</option>
                                <?php if($source != FALSE) { foreach ($source->result() as $source) {   ?>
                                <option value="<?php echo $source->tble_id; ?>"><?php echo $source->b_name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="span12 center-align-text">
                    <button class="btn btn-info" id="filter_button"> Search Ledger List</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div id="printable">
                <?php include 'application/views/common/banner.php'; ?>
                <div class="widget-body">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">SL.</th>
                                <th style="width: 10%;">Date</th>
                                <th style="width: 12%;">Branch</th>
                                <th style="width: 12%;">Method</th>
                                <th style="width: 13%;">Head</th>
                                <th style="width: 25%;">Notes</th>
                                <th style="text-align: right; width: 18%;">Amount</th>
                                <?php if($role == 3) { ?>
                                <th style="text-align: center; width: 5%;" class="noprint">Edit</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="invtable">
                            <?php if($orderz != NULL) { $sl = 1; $total = 0; foreach($orderz->result() as $orderz) {?>
                            <tr>
                                <td style="text-align: center;"><?=$sl;?></td>
                                <td>
                                    <?php echo date_format(date_create($orderz->v_date), "d-M-Y"); ?>
                                </td>
                                <td>
                                    <?php echo $orderz->Branch; ?>
                                </td>
                                <td>
                                    <?php echo $orderz->Through; ?>
                                </td>
                                <td>
                                    <?php echo $orderz->ledger; ?>
                                </td>
                                <td>
                                    <?php echo $orderz->v_note; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php $total = $total + $orderz->v_amount; ?>
                                    <?php echo bdt() . number_format(abs($orderz->v_amount), 2, ".", ","); ?>
                                </td>
                                <?php if($role == 3) { ?>
                                <td style="text-align: center;" class="noprint">
                                    <?php if($orderz->edit == 1) { ?>
                                    <a href="<?php echo site_url('accounts/edvchr?func=update&cat=accounts&mod=admin&sess_auth=' . md5(date('Ymdhis')) . '&remote=' . md5($title) . '&v_id=' . $orderz->tble_id . '&type=' . $orderz->v_type); ?>">
                                        <i class="icon-edit"></i>
                                    </a>
                                    <?php } ?>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php $sl++; } ?>
                            <tr>
                                <th style="text-align: right;" colspan="6">
                                    Total
                                </th>
                                <th style="text-align: right;">
                                    <?php echo bdt() . number_format($total, 2, ".", ","); ?>
                                </th>
                                <?php if($role == 3) { ?>
                                <th class="noprint"></th>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                </div>
                <?php include 'application/views/common/marketing.php'; ?>
            </div>
            <?php include 'application/views/common/printer.php'; ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#filter_button").click(function(){
        var starting    = $("#starting").val();
        var endingday   = $("#endingday").val();
        var status      = $("#status").val();
        var source      = $("#source").val();
        var v_type      = 2;
        $.ajax({
            type: "POST",
            url: "<?php  echo site_url('accounts/search');?>",
            data: {starting:starting, endingday: endingday, status: status, v_type: v_type, source: source},
            cache: false,
            beforeSend: function(){
               $('#invtable').html(
                   '<tr><td colspan="6" style="text-align: center;"><img src="<?php echo base_url() , 'img/ajaxloader.gif'; ?>" /></td></tr>'
               );
            },
            success: function(html){
               $("#invtable").html(html);
            }
       });
    });
</script>
