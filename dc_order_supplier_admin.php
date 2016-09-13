<?php
// Required includes
require_once __DIR__ . '/../includes/php/config.php';
require_once __DIR__ . '/../_classes/class.database.php';
$objDB = new DB();

// Page specific includes
require_once __DIR__ . '/../beheer/includes/php/dc_functions.php';

$_POST = sanitize($_POST);
$_GET = sanitize($_GET);

$strShow = strtolower($_GET['show']);
$sqlWhere = null;

require 'includes/php/dc_header.php';

?>

<h1>Ontvangen Bestellingen</h1>

<hr />

<ul class="nav nav-tabs" data-json-table="#table" data-json-key="show">
    <li class="disabled"><a >Bestellingen</a></li>
    <li data-json-value="new" class="active"><a>Nieuw</a></li>
    <li data-json-value="done"><a>Verwerkt</a></li>
    <li data-json-value="all"><a>Alles</a></li>
</ul>

<table class="table table-striped table-json" id="table" data-json-file="dc_order_list.json">
    <thead>
    <tr>
        <th width="10%" data-json-column="order_id" data-json-sort="desc">Winkel</th>
        <th width="10%" data-json-column=>Productnaam</th>
        <th>Hoeveelheid verkochte artikelen</th>
        <th width="5%">Details</th>
    </tr>
	</thead>
	<tbody></tbody>
</table>
<ul class="pagination pagination-json" data-json-table="#table" data-json-items="25"></ul>
<script src="/beheer/includes/script/jquery.dynamic-table.js"></script>

<?php require 'includes/php/dc_footer.php';?>