<?php
session_start();

$title = "Homepage";
require_once('includes/database.php');
require_once('includes/functions.php');

require_once('includes/header.php');

require_once('classes/views/homeView.php');

require_once('includes/footer.php');