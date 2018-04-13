<?php
require_once 'config.php';
if (!isLoggedIn()) {
    header("Location: /spywm/index.php");
}


include 'header_dash.php';
//echo isLoggedIn();

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

$dg->set_theme('cobalt_flat');
$dg->display(false);
$grid = $dg->get_display(true);
//$dg1->display();
//$grid = $dg->get_display(FALSE);
?>
<body>
    <?php echo $grid; ?>

    
    