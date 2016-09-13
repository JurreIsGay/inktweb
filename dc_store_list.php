<?php
require_once __DIR__ . '/../php/dc_session.php';

// Required includes
require_once __DIR__ . '/../../../includes/php/config.php';
require_once __DIR__ . '/../../../_classes/class.database.php';
$objDB = new DB();

// Page specific includes
require_once __DIR__ . '/../php/dc_functions.php';

$_GET = sanitize($_GET);

$strShow = strtolower($_GET['show']);
$strWhere = NULL;

$strSortColumn = (isset($_GET["sort_column"])) ? $_GET["sort_column"] : null;
$strSortOrder = (isset($_GET["sort_order"])) ? strtoupper($_GET["sort_order"]) : null;
$strQuery = (isset($_GET["query"])) ? $_GET["query"] : null;
$strShow = (isset($_GET["show"])) ? $_GET["show"] : null;
$intOffset = (isset($_GET["offset"])) ? (int) $_GET["offset"] : 0;
$intLimit = (isset($_GET["limit"])) ? (int) $_GET["limit"] : 15;

$strSort = ($strSortColumn != '') ? " ORDER BY `" . $strSortColumn . "` " . $strSortOrder : '';
$strLimit = " LIMIT " . $intOffset . "," . $intLimit;
// new
if (empty($strShow) OR $strShow == "new") {
    $strWhere .= " AND (o.order_status_id = 0 OR o.order_status_id = 1)";
} elseif ($strShow == "done") {
    $strWhere .= " AND o.order_status_id = 4";
}
// tot hier
$supplierId = $_SESSION['sessionSupplierId'];

$strSQL = 
"SELECT s.store_id,
		s.name,
		s.url
		FROM store s
		LEFT JOIN `supplier_to_store` sts ON sts.store_id = s.store_id AND sts.supplier_id = " . $_SESSION['sessionStoreId'] . "
		
		GROUP BY s.store_id DESC" .
		$StrSort;
$resultCount = $objDB->sqlExecute($strSQL);
$count = $objDB->getNumRows($resultCount);

$strSQL = $strSQL . $strLimit;
$result = $objDB->sqlExecute($strSQL);
// WHERE s.store_id = '" . $storeID . "'
//close db
$objDB->closeDB();
?>