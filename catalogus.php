<?php
session_start();
require_once('includes/functions.php');

$title = "catalogusproducten";

require_once('includes/header.php');

#ophalen van producten:
$producten = getItems();
require_once ('classes/views/catalogusView.php');
require_once('includes/footer.php');?>

