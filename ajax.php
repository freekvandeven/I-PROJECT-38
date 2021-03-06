<?php
session_start();
require_once('includes/functions.php');

$possible_requests = array('getCatalogus', 'getCategory', 'fillCatalogus', 'indexCatalogus', 'getNotifications', 'getMessages', 'sendMessages', 'switchDarkmode');
// this page handles all ajax requests
if (isset($_POST['request']) && in_array($_POST['request'], $possible_requests)) {
    require_once('classes/controllers/ajax/' . $_POST['request'] . '.php');
}