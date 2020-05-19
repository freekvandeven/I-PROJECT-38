<?php
session_start();
require_once('includes/functions.php');
registerRequest();

$title = "Privacy Policy";

require_once('includes/header.php');

require_once ('classes/views/AVG.php');
require_once('includes/footer.php');