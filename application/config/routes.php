<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['setting']                           = 'setting/shopinfo';
$route['compexe']                           = 'compexe/agentlist';
$route['group']                             = 'group/grouplist';
$route['medicine']                          = 'medicine/medicinelist';
$route['invoice']                           = 'sales';
$route['store']                             = 'store/add';
$route['sales/itemwisefilter']              = 'sales/item_wise_list_filter';
$route['sales/today']                       = 'sales/daytoday';
$route['default_controller']                = 'login';
$route['404_override']                      = 'fourzerofour';
$route['order/purchase']                    = 'order/purchase';


//Supplier Controller
$route['supplier/incentivepolicy']          = 'supplier/incentive_policy';
$route['supplier/incentivecalculate']       = 'supplier/incentive_calculation';
$route['supplier/creditpost']               = 'supplier/creditpost_incentive_adjust';

//DSR Controller
$route['dsr/list']                          = 'dsr/lstclnt';
$route['dsr/new']                           = 'dsr/newclnt';
$route['dsr/update']                        = 'dsr/editclnt';
$route['dsr/details']                       = 'dsr/viewclnt';
$route['dsr/ledger']                        = 'dsr/dsr_ledger';
$route['dsr/adjust']                        = 'dsr/opening_balance_adjust';

//Clients Controller
$route['clients/list']                      = 'clients/lstclnt';
$route['clients/new']                       = 'clients/newclnt';
$route['clients/update']                    = 'clients/editclnt';
$route['clients/details']                   = 'clients/viewclnt';
$route['clients/ledger']                    = 'clients/client_ledger';
$route['clients/adjust']                    = 'clients/opening_balance_adjust';

//Routing with the product controller
$route['products/list']                     = 'products/productlist';
$route['products/new']                      = 'products/newproduct';
$route['products/groups']                   = 'products/grouplist';
$route['products/newgrp']                   = 'products/grouplist';
$route['products/vhcllst']                  = 'products/vehicle_list';
$route['products/newvhcl']                  = 'products/new_vehicle';
$route['products/edtvhcl']                  = 'products/edit_vehicle';
$route['products/update']                   = 'products/update_product';
$route['products/delete']                   = 'products/delete_product';

//Routing with Order Controller
$route['order/purchase']                    = 'order/purchase';
$route['order']                             = 'order/order_list';
$route['order/orderlist']                   = 'order/order_list';
$route['order/position']                    = 'order/stock_position';
$route['order/report']                      = 'order/stock_transaction';
$route['order/itemtrans']                   = 'order/item_transaction';
$route['order/stock']                       = 'order/branchwise_stock';
$route['order/transfer']                    = 'order/stock_transfer';
$route['order/batchlist']                   = 'order/return_batch_list';
$route['order/batchstatus']                 = 'order/batch_status_update';
$route['order/newbatch']                    = 'order/new_return_batch';
$route['order/returnit/(:any)']             = 'order/add_return_item/$1';
$route['order/dltrtnbtch']                  = 'order/delete_return_batch';
$route['order/transferreport']              = 'order/stock_transfer_report';
$route['order/emergency']                   = 'order/emergency_stock_entry';
$route['order/stockclose']                  = 'order/daily_stock_closing';
$route['order/pending']                     = 'order/mark_as_pending_and_complete';

//Routing with Sales Controller
$route['sales/list']                        = 'sales/invoice_list';
$route['sales/details']                     = 'sales/invoice_details';
$route['sales/update']                      = 'sales/invoice_update';
$route['sales/cancel']                      = 'sales/cancel_sales';
$route['sales/invtrans']                    = 'sales/invoice_transfer';
$route['sales/transdet']                    = 'sales/invoice_transfer_details';


//Routing with Accounts Controller
$route['accounts/transfer']                 = 'accounts/balance_transfer';
$route['accounts/suppliercredit']           = 'accounts/supplier_credit';
$route['accounts/cashinhand']               = 'accounts/cash_in_hand';
$route['accounts/edvchr']                   = 'accounts/voucher_update';


$route['accounts/loanopening']              = 'accounts/loan_opening';
$route['accounts/loanvoucher']              = 'accounts/loan_voucher';
$route['accounts/loanstatement']            = 'accounts/loan_statement';
$route['accounts/loanrefund']               = 'accounts/loan_refund';
$route['accounts/loanledger']               = 'accounts/loan_ledger';
$route['accounts/loanrefund']               = 'accounts/loan_refund';

$route['accounts/cashbookopening']          = 'accounts/cash_book_opening';
$route['accounts/cashbookvoucher']          = 'accounts/cash_book_voucher';
$route['accounts/cashbookstatement']        = 'accounts/cash_book_statement';
$route['accounts/cashbookledger']           = 'accounts/cash_book_ledger';

$route['accounts/investmentopening']        = 'accounts/investment_opening';
$route['accounts/investmentvoucher']        = 'accounts/investment_voucher';
$route['accounts/investmentstatement']      = 'accounts/investment_statement';
$route['accounts/investmentledger']         = 'accounts/investment_ledger';

$route['accounts/investdeposit']            = 'accounts/invest_deposit';
$route['accounts/investbalance']            = 'accounts/invest_balance';
$route['accounts/investrefund']             = 'accounts/invest_refund';
$route['accounts/investstatement']          = 'accounts/invest_statement';

$route['accounts/dailyclosing']             = 'accounts/daily_closing';
$route['accounts/search_closing']           = 'accounts/get_closing_record';

//Routing with Employee Controller
$route['employee/list']                     = 'employee/emp_list';
$route['employee/new']                      = 'employee/new_employee';
$route['employee/update']                   = 'employee/edit_emp';
$route['employee/details']                  = 'employee/viewclnt';
$route['employee/attendance']               = 'employee/attendance';
$route['employee/salaryposting']            = 'employee/salary_posting';
$route['employee/adjust']                   = 'employee/balance_adjust';
$route['employee/dltatn']                   = 'employee/delete_attendance';
$route['employee/salaryclosing']            = 'employee/salary_closing';


//Routing with Settings Controller
$route['settings/usrlst']                   = 'settings/software_user';
$route['settings/newsoftusr']               = 'settings/new_software_user';
$route['settings/payment']                  = 'settings/broker_payment';
$route['settings/edtusr']                   = 'settings/update_soft_user';


/* End of file routes.php */
/* Location: ./application/config/routes.php */