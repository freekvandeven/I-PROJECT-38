<?php
session_start();

$title = "Profile page";
require_once('includes/database.php');
require_once('includes/functions.php');

checkLogin();

require_once('includes/header.php');

echo "You are logged in";

require_once('includes/footer.php');