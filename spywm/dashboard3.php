<?php

//include 'header.php';
require_once("config.php");

if (!isLoggedIn()) {
    header("Location: /spywm/index.php");
}

echo '<a href="logout.php" > Logout </a>';
$customer_id = $_SESSION['customer_id'];
$sql = sprintf('select txndate, receiptdate, txntype, credit, account_id, prd_offering_name, customer_id from v_savings_stmt');
$dg = new C_DataGrid("$sql", "account_id", "v_savings_stmt");
$dg1 = new C_DataGrid("$sql", "account_id", "v_savings_stmt");
$dg->enable_export('PDF');

$dg->set_query_filter("customer_id = $customer_id and prd_offering_id=4");
$dg1->set_query_filter("customer_id = $customer_id and prd_offering_id=5");

$dg->set_col_hidden("account_id, customer_id");
$dg->enable_search(true);
$dg->enable_autowidth(true);
//$dg->set_theme('cobalt-flat');
$dg->set_grid_property(array('cmTemplate' => array('title' => false)));
$dg->set_dimension(100, 300);
//$dg->set_jq_gridName('');

//$dg->set_theme('cobalt_flat');
$dg->display();
//$grid = $dg->get_display(true);
//$dg1->display();


//$grid = $dg->get_display(FALSE);
//echo $grid;

/**

  'select *
  from
  ((select "A" as ordering, cast(date("2010-12-31") as char) as "Txn Date", "Opening Balance" as "Txn Type",
  "" as "Payment", "" as "Receipt No.", "" as "Receipt Date",
  "" as "Money Out", "" as "Money In",
  cast(ifnull(round(sum(stxn.deposit_amount + stxn.interest_amount - stxn.withdrawal_amount), 2),0.0) as char) as "Balance"
  from account_trxn atxn
  join savings_trxn_detail stxn on atxn.account_trxn_id = stxn.account_trxn_id
  where atxn.account_id = 153
  and atxn.action_date < "2010-12-31")

  union all

  (select "C" as ordering, cast(date("2010-12-31") as char) as "Txn Date", "Closing Balance" as "Txn Type",
  "" as "Payment", "" as "Receipt No.", "" as "Receipt Date",
  "" as "Money Out", "" as "Money In",
  cast(ifnull(round(sum(stxn.deposit_amount + stxn.interest_amount - stxn.withdrawal_amount), 2),0.0) as char) as "Balance"
  from account_trxn atxn
  join savings_trxn_detail stxn on atxn.account_trxn_id = stxn.account_trxn_id
  where atxn.account_id = 153
  and atxn.action_date <= "2010-12-31")
  ) fullunion
  order by 1, 2');

 * */
include 'footer.php';
