<div class="container-fluid">
    <div class="dashboard-wrapper">
        <div id="main-nav" class="hidden-phone hidden-tablet">
            <!--Inventory Menu -->
            <ul>
                <!--Inventory Module Dashboard Menu-->
                <li><a href="<?php echo site_url('dashboard')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Dashboard</a></li>
                <?php if($role == 3) { ?>
                <!--Inventory Module Supplier Menu-->
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span>Supplier</a>
                    <ul>
                        <li><a href="<?php echo site_url('supplier/supplierlist')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Supplier List</a></li>
                        <li><a href="<?php echo site_url('supplier/newsupplier')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> New Supplier</a></li>
                        <li><a href="<?php echo site_url('supplier/incentivepolicy')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Incentive Policy Setup</a></li>
                        <li><a href="<?php echo site_url('supplier/incentivecalculate')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Incentive Policy Calculation</a></li>
                        <li><a href="<?php echo site_url('')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Durgom Vata Setup</a></li>
                        <li><a href="<?php echo site_url('')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Durgom Vata Calculation</a></li>
                    </ul>
                </li>
                
                <!--Client Module Order Menu-->
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span>DSR</a>
                    <ul>
                        <li><a href="<?php echo site_url('dsr/list')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> DSR List</a></li>
                        <li><a href="<?php echo site_url('dsr/new')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> New DSR</a></li>
                    </ul>
                </li>
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span>Customers</a>
                    <ul>
                        <li><a href="<?php echo site_url('clients/list')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Customers List</a></li>
                        <li><a href="<?php echo site_url('clients/new')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> New Customer</a></li>
                    </ul>
                </li>
                
                <!--Inventory Module Medicine Menu-->
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span> Products</a>
                    <ul>
                        <li><a href="<?php echo site_url('products/new')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> New Product</a></li>
                        <li><a href="<?php echo site_url('products/list')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Products List</a></li>
                        <li><a href="<?php echo site_url('products/groups')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Product Group</a></li>
                    </ul>
                </li>
        
            
                <!--Inventory Module Order Menu-->
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span> Stock</a>
                    <ul>
                        <li><a href="<?php echo site_url('order/purchase')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Purchase Order</a></li>
                        <li><a href="<?php echo site_url('order/orderlist')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Purchase Order List</a></li>
                        <li><a href="<?php echo site_url('order/position')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Stock Position & Closing</a></li>
                        <li><a href="<?php echo site_url('order/report')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Stock Transaction Report</a></li>
                        <li><a href="<?php echo site_url('order/transfer')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Stock Transfer</a></li>
                        <li><a href="<?php echo site_url('order/transferreport')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Stock Transfer Report</a></li>
                        <li><a href="<?php echo site_url('order/batchlist')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Return Batch List</a></li>
                        <li><a href="<?php echo site_url('order/newbatch')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> New Return Batch</a></li>
                        <li><a href="<?php echo site_url('order/emergency')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Emergency Stock</a></li>
                    </ul>
                </li>
                
                <!--Inventory Module Sales Menu-->
                <li><a class="fs1"><span aria-hidden="true" data-icon="&#xe0b8;"></span>Sales</a>
                    <ul>
                        <li><a href="<?php echo site_url('sales/invoice'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Create Invoice</a></li>
                        <li><a href="<?php echo site_url('sales/list'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Invoice List</a></li>
                        <!--<li><a href="<?php echo site_url('sales/invtrans'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Invoice Transfer</a></li>-->
                    </ul>
                </li>
                
                <!--Inventory Module Accounts Menu-->
                <li><a class="fs1"><span aria-hidden="true" data-icon="&#xe0b8;"></span>Accounts</a>
                    <ul>
                        <li><a href="<?php echo site_url('accounts/voucher'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Voucher Posting</a></li>
                        <li><a href="<?php echo site_url('accounts/inlist'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Income Statement</a></li>
                        <li><a href="<?php echo site_url('accounts/acclist'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Expense Statement</a></li>
                        <li><a href="<?php echo site_url('accounts/ledgerhead'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Ledger Head</a></li>
                        <li><a href="<?php echo site_url('accounts/transfer'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Balance Transfer</a></li>
                        <li><a href="<?php echo site_url('accounts/suppliercredit'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Supplier Credit Posting</a></li>
                        <li><a href="<?php echo site_url('accounts/loanopening'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Loan Opening Balance</a></li>
                        <li><a href="<?php echo site_url('accounts/loanvoucher'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Loan Voucher</a></li>
                        <li><a href="<?php echo site_url('accounts/loanstatement'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Loan Statement</a></li>
                        
                        <li><a href="<?php echo site_url('accounts/cashbookopening'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Cash Book Opening Balance</a></li>
                        <li><a href="<?php echo site_url('accounts/cashbookvoucher'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Cash Book Voucher</a></li>
                        <li><a href="<?php echo site_url('accounts/cashbookstatement'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Cash Book Statement</a></li>
                        
                        <li><a href="<?php echo site_url('accounts/investmentopening'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Investment Opening Balance</a></li>
                        <li><a href="<?php echo site_url('accounts/investmentvoucher'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Investment Voucher</a></li>
                        <li><a href="<?php echo site_url('accounts/investmentstatement'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Investment Statement</a></li>
                        <li><a href="<?php echo site_url('accounts/dailyclosing'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Daily Closing</a></li>
                        <li><a href="<?php echo site_url('accounts/cashinhand'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Cash In Hand</a></li>
                    </ul> 
                </li>
                
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span>Employee</a>
                    <ul>
                        <li><a href="<?php echo site_url('employee/list')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Employee List</a></li>
                        <li><a href="<?php echo site_url('employee/new')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> New Employee</a></li>
                        <li><a href="<?php echo site_url('employee/attendance')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Attendance</a></li>
                    </ul>
                </li>
                
                <!--Inventory Module Settings Menu-->
                <li><a href="<?php echo site_url('settings'); ?>" class="fs1"><span aria-hidden="true" data-icon="&#xe0b8;"></span>Settings</a>
                    <ul>
                        <li><a href="<?php echo site_url('settings/branch'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Branch Setup</a></li>
                        <li><a href="<?php echo site_url('settings/usrlst'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Software User</a></li>
<!--                        <li><a href="<?php // echo site_url('settings/shopinfo'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span>Store Settings</a></li>-->
                    </ul>
                </li>
                <?php } ?>
                <?php if($role == 2) { ?>
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span>Supplier</a>
                    <ul>
                        <li><a href="<?php echo site_url('supplier/supplierlist')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Supplier List</a></li>
                    </ul>
                </li>
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span>DSR</a>
                    <ul>
                        <li><a href="<?php echo site_url('dsr/list')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> DSR List</a></li>
                    </ul>
                </li>
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span>Customers</a>
                    <ul>
                        <li><a href="<?php echo site_url('clients/list')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Customers List</a></li>
                    </ul>
                </li>
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span> Products</a>
                    <ul>
                        <li><a href="<?php echo site_url('products/list')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Products List</a></li>
                    </ul>
                </li>
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span> Stock</a>
                    <ul>
                        <li><a href="<?php echo site_url('order/position')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Stock Position</a></li>
                    </ul>
                </li>
                <li><a class="fs1"><span aria-hidden="true" data-icon="&#xe0b8;"></span>Sales</a>
                    <ul>
                        <li><a href="<?php echo site_url('sales/invoice'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Create Invoice</a></li>
                        <li><a href="<?php echo site_url('sales/list'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Invoice List</a></li>
                    </ul>
                </li>
                <li><a class="fs1"><span aria-hidden="true" data-icon="&#xe0b8;"></span>Accounts</a>
                    <ul>
                        <li><a href="<?php echo site_url('accounts/voucher'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Voucher Posting</a></li>
                        <li><a href="<?php echo site_url('accounts/inlist'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Income Statement</a></li>
                        <li><a href="<?php echo site_url('accounts/acclist'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Expense Statement</a></li>
                        <li><a href="<?php echo site_url('accounts/transfer'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Balance Transfer</a></li>
                        <li><a href="<?php echo site_url('accounts/cashinhand'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Cash In Hand</a></li>
                    </ul> 
                </li>
                <?php } ?>
                <?php if($role == 1) { ?>
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span>Supplier</a>
                    <ul>
                        <li><a href="<?php echo site_url('supplier/supplierlist')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Supplier List</a></li>
                    </ul>
                </li>
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span> Products</a>
                    <ul>
                        <li><a href="<?php echo site_url('products/list')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Products List</a></li>
                    </ul>
                </li>
                <li>
                    <a><span aria-hidden="true" data-icon="&#xe0b8;"></span> Stock</a>
                    <ul>
                        <li><a href="<?php echo site_url('order/purchase')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Purchase Order</a></li>
                        <li><a href="<?php echo site_url('order/orderlist')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Purchase Order List</a></li>
                        <li><a href="<?php echo site_url('order/position')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Stock Position</a></li>
                        <li><a href="<?php echo site_url('order/report')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Stock Transaction</a></li>
                        <li><a href="<?php echo site_url('order/transfer')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Stock Transfer</a></li>
                        <li><a href="<?php echo site_url('order/transferreport')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Stock Transfer Report</a></li>
                        <li><a href="<?php echo site_url('order/batchlist')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Return Batch List</a></li>
                        <li><a href="<?php echo site_url('order/newbatch')?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> New Return Batch</a></li>
                    </ul>
                </li>
                <li><a class="fs1"><span aria-hidden="true" data-icon="&#xe0b8;"></span>Accounts</a>
                    <ul>
                        <li><a href="<?php echo site_url('accounts/suppliercredit'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Supplier Credit Posting</a></li>
                        <li><a href="<?php echo site_url('accounts/cashinhand'); ?>"><span class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></span> Cash In Hand</a></li>
                    </ul> 
                </li>
                <?php } ?>
            </ul>
            <div class="details" id="date-time"></div>
            <div class="clearfix"></div>
        </div>
        <div class="main-container">
            <div class="navbar hidden-desktop">
                <div class="navbar-inner">
                    <div class="container">
                        <a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        <div class="nav-collapse collapse navbar-responsive-collapse">
                            <ul class="nav">
                                <li><a href="<?php echo site_url('admin'); ?>">Dashboard</a></li>
                                <li><a href="<?php echo site_url('group'); ?>">Groups</a></li>
                                <li><a href="<?php echo site_url('type'); ?>">Types</a></li>
                                <li><a href="#">Extended Forms</a></li>
                                <li><a href="#">Form Wizard</a></li>
                                <li><a href="#">Flot Charts</a></li>
                                <li><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>