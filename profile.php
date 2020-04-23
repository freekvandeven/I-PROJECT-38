<?php
session_start();
require_once('includes/functions.php');
checkLogin();

if(!empty($_POST)){
    echo "someone sent a post";
}

$title = "profile page";
require_once('includes/header.php');
if(isset($_GET['action']) && $_GET['action'] == 'update'){
    require_once('classes/views/profile/updateView.php');
} else if(isset($_GET['action']) && $_GET['action'] == 'upgrade'){
    require_once('classes/views/profile/upgradeView.php');
} else {
    require_once('classes/views/profile/profileView.php');
}
require_once('includes/footer.php');