



<div class="row-fluid">
    <div class="span8">
        <div class="widget no-margin">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span> Ledger Head
                </div>
            </div>
            <div class="widget-body">
                <?php echo $this->session->flashdata('agedata'); ?> 
                <div id="dt_example" class="example_alt_pagination">
                    <table class="table table-condensed table-striped table-hover table-bordered pull-left" id="data-table">
                        <thead>
                            <tr>
                                <th style="width:70%;">Name</th>
                                <th class="center-align-text" style="width:10%;">Type</th>
                                <th class="center-align-text" style="width:10%;">Status</th>
                                <th class="center-align-text" style="width:10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="medtable">
                            <?php if($ledger!=FALSE){foreach ($ledger->result() as $ledger) {?>
                            <tr>
                                <td><?php echo $ledger->ledger; ?></td>
                                <td class="center-align-text"><?php if($ledger->type == 1){ echo 'Income'; } elseif($ledger->type == 2){ echo 'Expense'; } ?></td>
                                <td class="center-align-text"><?php if($ledger->status == 1) {echo 'Active'; }  elseif($ledger->status == 2) { echo 'Inactive';} ?></td>
                                <td class="hidden-phone center-align-text">
                                    <?php if($ledger->edit == 1) { ?>
                                    <a  data-original-title="Edit" href="<?php echo site_url("accounts/createledger/" . $ledger->id . '&name=' . md5($ledger->ledger) . '~~'); ?>"><i class="icon-edit"></i></a>
                                    <?php } ?>
                                </td>                       
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
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Create Ledger Head
                </div>
            </div>
            <div class="widget-body">
                 <form class="form-horizontal no-margin" action="<?php echo site_url('accounts/createledger');?>" method="post">
                     <div class="control-group">
                         <label class="control-label">Ledger Name</label>
                         <div class="controls controls-row">
                             <input class="span12" type="text" placeholder="Maximum 255 Characters" name="ledgername" required="required" />
                             <input type="hidden" name="trigger" value="createledger" />
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label">Head Type</label>
                         <div class="controls controls-row">
                             <select class="span12" name="type" required="required">
                                 <option value="">Select</option>
                                 <option value="1">Income</option>
                                 <option value="2">Expense</option>
                             </select>
                         </div>
                     </div>
                     <div class="form-actions no-margin">
                         <button type="submit" class="btn btn-info pull-right"><i class="icon-ok"></i> Create</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
</div>
<script type="text/javascript">  $(document).ready(function () { $('#data-table').dataTable({ "sPaginationType": "full_numbers" }); });</script>