<?php
session_start();
require_once('includes/functions.php');
checkLogin();
$actions = array("update", "upgrade", "item", "favorite");
if(checkPost()){
    if (isset($_POST['action'])){
        if($_POST['action'] == 'update'){
            require_once('classes/controllers/profile/updateController.php');
        }
        if($_POST['action'] == 'upgrade'){
            require_once('classes/controllers/profile/upgradeController.php');
        }
        if($_POST['action'] == 'review'){
            require_once('classes/controllers/profile/reviewController.php');
        }
        if($_POST['action'] == 'delete'){
            require_once('classes/controllers/profile/deleteController.php');
        }
    }
}
$title = "profile page";
require_once('includes/header.php');

if(isset($_GET['action']) && in_array($_GET['action'], $actions)){
    require_once('classes/views/profile/'.$_GET['action'].'View.php');
} else if(isset($_GET['id'])) {
    require_once('classes/views/profile/inspectView.php');
} else {
    require_once('classes/views/profile/profileView.php');
}

if(!empty($_SESSION)&&$_SESSION['admin']=true && !empty($_POST['deleteUser'])){
    User::nukeUser($_GET['id']);
}


require_once('includes/footer.php');