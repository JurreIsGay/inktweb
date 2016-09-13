<?php

require_once __DIR__ . '/../../../beheer/includes/php/dc_functions.php';
require_once __DIR__ . '/../../../beheer/includes/php/dc_session.php';

// Ensure user is logged in
if (!isset($_SESSION['sessionUserId'])) {
	header("Location: /beheer/dc_logout.php");
	exit();
}
// Ensure user has associated context
if (!isset($skipContextCheck)) {
	if (isset($_SESSION['sessionStoreId']) && isset($_SESSION['sessionSupplierId'])) {
		header("Location: /beheer/dc_select_context.php");
		exit();
	}
	if (!isset($_SESSION['sessionStoreId']) && !isset($_SESSION['sessionSupplierId'])) {
		header("Location: /beheer/dc_select_context.php");
		exit();
	}
}

// get num of open orders
$result_numOrders = $objDB->sqlExecute("SELECT COUNT(order_id) FROM `order` WHERE order_status_id = 0");
list($numOrders) = $objDB->getRow($result_numOrders);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<link href="/beheer/includes/style/jquery.pagedown-bootstrap.css" rel="stylesheet">
<link href="/beheer/includes/style/custom.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="//code.highcharts.com/highcharts.js"></script>
</head>
<body>

<div class="container-fluid">
<div class="row" id="top-bar">
<div class="col-xs-12 hidden-md hidden-lg" >



        <a href="#" data-toggle="offcanvas" class="block-trigger">
            <i class="fa fa-bars"></i> Swipe of klik hier om het menu te open
        </a>

    <!-- /col -->
</div><!-- /col -->
</div>

<div class="row offcanvas offcanvas-left">
    <div class="col-xs-6 col-sm-6 col-md-2 main-sidebar">
        <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="static text-center faded">
                <p>
                    Dropcart
                </p>
            </li>
            <li class="static title">Context</li>
            <li class="static">
                <p>Welkom <strong><?php echo (isset($_SESSION['sessionUsername'])) ? $_SESSION['sessionUsername'] : '[ Gebruikersnaam niet gevonden ]'?></strong></p>
            </li>
<!-- Dit stukje hieronder is van ons-->
<?php
			$userId = $_SESSION['sessionUserId'];
			$selectedStoreId = $_SESSION['sessionStoreId'];
			$selectedSupplierId = $_SESSION['sessionSupplierId'];
			
			$strSQL = "SELECT store_id, name FROM store WHERE user_id = " . $userId;
            $result = $objDB->sqlExecute($strSQL);
            $numRows = $objDB->getNumRows($result);

       		for ($i = 0; $i < $numRows; $i++) {
      				list($storeId, $storeName) = $objDB->getRow($result);
?>
<li<?php if ($storeId == $selectedStoreId) { ?> class="active"<?php } ?>><a href="/beheer/dc_select_context.php?storeId=<?php echo $storeId; ?>"> <span class="glyphicon glyphicon-user"></span> <?php echo $storeName; ?></a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
<?php
       		}
            
            $strSQL = "SELECT supplier_id, name FROM supplier WHERE user_id = " . $userId;
            $result = $objDB->sqlExecute($strSQL);
            $numRows = $objDB->getNumRows($result);

            for ($i = 0; $i < $numRows; $i++) {
            		list($supplierId, $supplierName) = $objDB->getRow($result);
?>
<li<?php if ($supplierId == $selectedSupplierId) { ?> style="background-color: pink"<?php } ?>><a href="/beheer/dc_select_context.php?supplierId=<?php echo $supplierId; ?>"> <span class="glyphicon glyphicon-barcode"></span>  <?php echo $supplierName; ?> </a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
<?php
			}
?>
			<li class="static title">Menu</li>
<!-- Tot en met hier -->
            <li <?php if (curPage() == "dc_index.php") { echo 'class="active" ';}?>><a href="/beheer/dc_index.php"> <span class="glyphicon glyphicon-home"></span> Home</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
<?php
if ($selectedStoreId > 0) {
?>
            <li <?php if (curPage() == "dc_order_admin.php" OR curPage() == "dc_order_manage.php" OR curPage() == "dc_order_supplier_admin.php" ) {echo 'class="active" ';}?>><a href="/beheer/dc_order_admin.php"> <span class="glyphicon glyphicon-euro"></span> Bestellingen <?php if ($numOrders > 0) { echo '<span class="label label-success">' . $numOrders . '</span>';} ?></a><div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
            <li <?php if (curPage() == "dc_customer_admin.php" OR curPage() == "dc_customer_manage.php") {echo 'class="active" ';}?>><a href="/beheer/dc_customer_admin.php"> <span class="glyphicon glyphicon-user"></span> Klanten</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
            <li <?php if (curPage() == "dc_supplier_admin.php" OR curPage() == "dc_supplier_manage.php") {echo 'class="active" ';}?>><a href="/beheer/dc_supplier_admin.php"> <span class="glyphicon glyphicon-barcode"></span> Leveranciers</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
            <li <?php if (curPage() == "dc_product_admin.php" OR curPage() == "dc_product_manage.php") {echo 'class="active" ';}?>><a href="/beheer/dc_product_admin.php"> <span class="glyphicon glyphicon-barcode"></span> Producten</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
            <li <?php if (curPage() == "dc_codes_admin.php" OR curPage() == "dc_codes_list.php" OR curPage() == "dc_codes_manage.php") {echo 'class="active" ';}?>><a href="/beheer/dc_codes_admin.php"> <span class="glyphicon glyphicon-credit-card"></span> Vouchercodes</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
            <li <?php if (curPage() == "dc_email_admin.php" OR curPage() == "dc_email_manage.php") {echo 'class="active" ';}?>><a href="/beheer/dc_email_admin.php"> <span class="glyphicon glyphicon-envelope"></span> Emails</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
            <li <?php if (curPage() == "dc_user_admin.php" OR curPage() == "dc_user_manage.php") {echo 'class="active" ';}?>><a href="/beheer/dc_user_admin.php"> <span class="glyphicon glyphicon-user"></span> Gebruikers</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
            <li <?php if (curPage() == "dc_paymethod_admin.php" OR curPage() == "dc_paymethod_manage.php") {echo 'class="active" ';}?>><a href="/beheer/dc_paymethod_admin.php"> <span class="glyphicon glyphicon-credit-card"></span> Betaalmethoden</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
            <li <?php if (curPage() == "dc_setting_admin.php") {echo 'class="active" ';}?>><a href="/beheer/dc_setting_admin.php"> <span class="glyphicon glyphicon-wrench"></span> Instellingen</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
<?php
}
?>

<?php
if ($selectedSupplierId > 0) {
?>
            <li <?php if (curPage() == "dc_order_supplier_admin.php" ) {echo 'class="active" ';}?>><a href="/beheer/dc_order_supplier_admin.php"> <span class="glyphicon glyphicon-euro"></span> Bestellingen <?php if ($numOrders > 0) { echo '<span class="label label-success">' . $numOrders . '</span>';} ?></a><div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
			<li <?php if (curPage() == "dc_stores_supplier_admin.php") {echo 'class="active" ';}?>><a href="/beheer/dc_stores_supplier_admin_2.php"> <span class="glyphicon glyphicon-user"></span> Stores</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
			<li <?php if (curPage() == "dc_product_admin.php" OR curPage() == "dc_product_manage.php") {echo 'class="active" ';}?>><a href="/beheer/dc_product_admin.php"> <span class="glyphicon glyphicon-barcode"></span> Producten</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
			<li <?php if (curPage() == "dc_setting_supplier_admin.php") {echo 'class="active" ';}?>><a href="/beheer/dc_setting_supplier_admin.php"> <span class="glyphicon glyphicon-wrench"></span> Instellingen</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
			<li <?php if (curPage() == "dc_paymethod_admin.php" /*OR curPage() == "dc_paymethod_manage.php"*/) {echo 'class="active" ';}?>><a href="/beheer/dc_paymethod_admin.php"> <span class="glyphicon glyphicon-credit-card"></span> Betaalmethoden</a> <div class="arrow"><div class="bubble-arrow-border"></div><div class="bubble-arrow"></div></div></li>
<?php
}
?>

            <li><a href="/beheer/dc_logout.php"><i class="fa fa-sign-out"></i> Uitloggen</a></a> </li>
        </ul>

        <ul class="nav dropcart">
            <li class="static title">Dropcart</li>
            <li><a href="/beheer/dc_faq.php">
                    <i class="fa fa-question"></i> Veelgestelde vragen
                </a></li>
            <li><a href="/beheer/dc_contact.php">
                    <i class="fa fa-envelope"></i> Contact</a>
            </li>
        </ul>
        </div>
    </div>

<div class="col-xs-12 col-sm-12 col-md-10 main-content">
    <!-- Used with side nav to dark the main content -->
    <div class="dark-overlay hidden"></div>