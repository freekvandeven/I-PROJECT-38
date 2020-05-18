<?php
session_start();
require_once('includes/functions.php');
registerRequest();

$title = "Catalogus Page";

require_once('includes/header.php');

#ophalen van producten:
$producten = Items::getItems();
require_once ('classes/views/catalogusView.php');
require_once('includes/footer.php');

