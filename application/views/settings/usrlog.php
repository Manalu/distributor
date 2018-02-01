



<div class="row-fluid">
    <div class="span12">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span> User Login Log
                </div>
            </div>
            <div class="widget-body">
                <div id="dt_example" class="example_alt_pagination">
                    <table class="table table-condensed table-striped table-hover table-bordered pull-left" id="data-table">
                        <thead>
                            <tr>
                                <th style="width:20%">Date (Server Time)</th>
                                <th style="width:20%">Time (Local)</th>
                                <th style="width:20%">User</th>
                                <th style="width:20%" class="hidden-phone">Role</th>
                                <th style="width:20%">Login Ip</th>
                            </tr>
                        </thead>
                        <tbody id="logtable">
                            <?if($logs!=FALSE){foreach ($logs->result() as $log) {?>
                            <tr>
                                <td><?php echo $log->date; ?></td> 
                                <td><?php echo $log->time; ?></td>
                                <td class="hidden-phone"><?php echo $log->user; ?></td>
                                <td class="hidden-phone"><?php echo $log->dept; ?></td>
                                <td class="hidden-phone"><?php echo $log->ip; ?></td>
                            </tr>
                            <?php }}?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">  $(document).ready(function () { $('#data-table').dataTable({ "sPaginationType": "full_numbers", "aaSorting": [["0","desc"]] }); });</script>