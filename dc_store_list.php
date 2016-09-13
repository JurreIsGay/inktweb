<?php
session_start();

require_once __DIR__ . '/../php/dc_session.php';

require_once __DIR__ . '/../../../includes/php/dc_connect.php';
require_once __DIR__ . '/../../../_classes/class.database.php';
$objDB = new DB();
require_once __DIR__ . '/../../includes/php/dc_config.php';
require_once __DIR__ . '/../../includes/php/dc_functions.php';

$_GET = sanitize($_GET);

$strShow = (isset($_GET['show'])) ? strtolower($_GET['show']) : null;
$strWhere = null;
$strSortColumn = (isset($_GET['sort_column'])) ? $_GET["sort_column"] : null;
$strSortOrder = (isset($_GET['sort_order'])) ? strtoupper($_GET["sort_order"]) : null;
$strQuery = (isset($_GET['query'])) ? $_GET["query"] : null;
$intOffset = (isset($_GET['offset'])) ? (int) $_GET["offset"] : 0;
$intLimit = (isset($_GET['limit'])) ? (int) $_GET["limit"] : 15;

$strSort = ($strSortColumn != '') ? " ORDER BY `" . $strSortColumn . "` " . $strSortOrder : '';
$strWhere .= ($strQuery != '') ? " AND (supplier_id LIKE '%" . $strQuery . "%' )" : '';
$strLimit = " LIMIT " . $intOffset . "," . $intLimit;

$supplierId = $_SESSION['sessionSupplerId'];

$strSQL = "SELECT * FROM `supplier` WHERE supplier_id = '" . $supplierId . "'"
?>