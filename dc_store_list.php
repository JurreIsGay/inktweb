<?php
require_once __DIR__ . '/../php/dc_session.php';

// Required includes
require_once __DIR__ . '/../../../includes/php/config.php';
require_once __DIR__ . '/../../../_classes/class.database.php';
$objDB = new DB();

// Page specific includes
require_once __DIR__ . '/../php/dc_functions.php';

$_GET = sanitize($_GET);

$strShow = (isset($_GET['show'])) ? strtolower($_GET['show']) : null;
$strWhere = null;
$strSortColumn = (isset($_GET['sort_column'])) ? $_GET["sort_column"] : null;
$strSortOrder = (isset($_GET['sort_order'])) ? strtoupper($_GET["sort_order"]) : null;
$strQuery = (isset($_GET['query'])) ? $_GET["query"] : null;
$intOffset = (isset($_GET['offset'])) ? (int) $_GET["offset"] : 0;
$intLimit = (isset($_GET['limit'])) ? (int) $_GET["limit"] : 15;

$strSort = ($strSortColumn != '') ? " ORDER BY `" . $strSortColumn . "` " . $strSortOrder : '';
$strWhere .= ($strQuery != '') ? " AND (store_id LIKE '%" . $strQuery . "%' OR name LIKE '%" . $strQuery . "%' OR url LIKE '%" . $strQuery . "%')" : '';
$strLimit = " LIMIT " . $intOffset . "," . $intLimit;

$supplierId = $_SESSION['sessionSupplierId'];

$strSQL = 
"SELECT s.store_id, s.name, s.url 
FROM store s 
INNER JOIN supplier_to_store ON (supplier_id = store_id)
WHERE supplier_id = '" . $supplierId . "' " . $strWhere . "
GROUP BY store_id DESC" .
$strSort;
$resultCount = $objDB->sqlExecute($strSQL);
$count = $objDB->getNumRows($resultCount);

$strSQL = $strSQL . $strLimit;
$result = $objDB->sqlExecute($strSQL);

/*
$arrJson['totalRows'] = $count;
$i = 0;

while ($objOrder = $objDB->getObject($result)) {


    $arrJson['details'][$i][] = $objOrder->store_id;
    $arrJson['details'][$i][] = $objOrder->name;
    $arrJson['details'][$i][] = $objOrder->url;

    $i++;
}
*/
header('Content-type: application/json');
echo json_encode($arrJson);

$objDB->closeDB();
?>