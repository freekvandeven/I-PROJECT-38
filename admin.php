<?php
session_start();
require_once('includes/functions.php');
registerRequest();
checkAdminLogin();
$possible_categories = array("auction", "user", "seller", "statistics", "reset", "fill", "query","addRubriek"); # all possible actions

# handle the login post request
if(checkPost()) { # this login handling needs to be in some seperate file combined with the login.php

        # divide the post between different controllers
    if (isset($_POST['category']) && in_array($_POST['category'], $possible_categories)) {
        require_once('classes/controllers/admin/' . $_POST['category'] . 'Controller.php');
    }
}

$title = "Admin page";
require_once('includes/header.php');

# get the corresponding view for the Action the admin wants to do
if (isset($_GET['category']) && in_array($_GET['category'], $possible_categories)) {
    require_once('classes/views/admin/' . $_GET['category'] . 'View.php');
} else { # if no action is selected, give the default view
    require_once('classes/views/adminView.php');
}

require_once('includes/footer.php');

