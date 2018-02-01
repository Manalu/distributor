



<div class="row-fluid">
    <div class="span8">
        <div class="widget">
            <div class="widget-header">
                <div class="title">
                    <span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>Create Ledger Head
                </div>
            </div>
            <div class="widget-body">
                <?php  echo $this->session->flashdata('agedata'); ?> 
                 <form class="form-horizontal no-margin" action="<?php echo site_url('accounts/createledger');?>" method="post">
                     <div class="control-group">
                         <label class="control-label">Ledger Name</label>
                         <div class="controls controls-row">
                             <input class="span12" type="text" title="Maximum 255 Characters" name="ledgername" value="<?php echo $ledger->ledger; ?>" />
                             <input type="hidden" name="trigger" value="editledger" />
                             <input type="hidden" name="ledgerid" value="<?php echo $ledger->id; ?>" />
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label">Head Type</label>
                         <div class="controls controls-row">
                             <select class="span12" name="type" id="type" required="required">
                                 <option value="">Select</option>
                                 <option value="1" <?php if($ledger->type == 1) { echo 'selected'; } ?>>Income</option>
                                 <option value="2" <?php if($ledger->type == 2) { echo 'selected'; } ?>>Expense</option>
                             </select>
                         </div>
                     </div>
                     <div class="control-group">
                         <label class="control-label">Ledger Status</label>
                         <div class="controls controls-row">
                             <select name="ledgerstat" class="span12" id="ledgerstat">
                                 <option value="">Select..</option>
                                 <option value="1" <?php if($ledger->status == 1) { echo 'selected'; } ?>>Active</option>
                                 <option value="2" <?php if($ledger->status == 2) { echo 'selected'; } ?>>Inactive</option>
                             </select>
                         </div>
                     </div>
                     <div class="form-actions no-margin">
                         <button type="submit" class="btn btn-info pull-right"><i class="icon-edit"></i> Update</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
</div>