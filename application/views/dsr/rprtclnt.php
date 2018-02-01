


<div class="row-fluid">
    <div class="span8">
        <div class="widget no-margin">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Top Clients
                </div>
            </div>
            <div class="widget-body">
                <?php echo $this->session->flashdata('agedata'); ?>
                <div id="dt_example" class="example_alt_pagination">
                    <table class="table table-condensed table-striped table-hover table-bordered pull-left" id="data-table">
                        <thead>
                            <tr>
                                <th style="width:10%" class="hidden-phone center-align-text">SL</th>
                                <th style="width:80%" class="hidden-phone">Number</th>
                                <th style="width:10%" class="hidden-phone center-align-text">Sales</th>
                            </tr>
                        </thead>
                        <tbody id ="medtable">
                            <?if($rprtclnt != FALSE){foreach ($rprtclnt->result() as $rprtclnt) {?>
                            <tr>
                                <td class="hidden-phone center-align-text"><?php echo $rprtclnt->cl_id; ?></td>
                                <td class="hidden-phone"><?php echo $rprtclnt->cl_phone_no; ?></td>
                                <td class="hidden-phone center-align-text"><?php echo getNumberOfSalesForEachClient($rprtclnt->cl_id); ?>-Sales</td>
                            </tr>
                          <?php }}?>
                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>View Client Information
                </div>
            </div>
            <div class="widget-body">
                <p>Clients are peoples to whom you are selling medicines, Client records are kept in order to see your top clients, in case if you want to put extra discount to your clients.</p>
                <hr />
                <p><b>The </b> <b style="color: red;">Sales</b> <b>column represents the number sales made to each client. This list is sorted according to a highest to lowest order.</b></p>
                <hr />
                <p>Filter through the search box to find specific client and their buying information.</p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">  $(document).ready(function () { $('#data-table').dataTable({ "sPaginationType": "full_numbers","aaSorting": [[ 2, "desc" ]] }); });</script>
<script> $("#search").keyup(function(){ jQuery .ajax({ type: "POST", url: "<?php  echo base_url();?>supplier/search", data: {str :$(this).val()}, cache: false, success: function(html){ $("#medtable").html(html); } }); });</script>        