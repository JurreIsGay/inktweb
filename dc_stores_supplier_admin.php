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

<h1>Winkels in database</h1>

<hr />

<input type="search" id="search" value="" class="form-control search-json" placeholder="Zoeken" style="margin-bottom:20px" data-json-table="#table">

<?php

if (!empty($_GET['succes'])) {
    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Gelukt!</strong> ' . $_GET['succes'] . '</div>';
}

?>

<table class="table table-striped table-json" id="table" data-json-file="dc_store_list.json">
    <thead>
    <tr>
		<th width="10%" data-json-column="store_id" data-json-sort="desc">Winkelnummer</th>
        <th data-json-column="name">Naam</th>
        <th data-json-column="url">Link</th>
		<th width="5%">#</th>
        <th width="5%">Details</th>  
    </tr>
    </thead>
    <tbody></tbody>
</table>

<ul class="pagination pagination-json" data-json-table="#table" data-json-items="25"></ul>

<script src="/beheer/includes/script/jquery.dynamic-table.js"></script>

<?php require 'includes/php/dc_footer.php';?>