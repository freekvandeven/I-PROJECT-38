<?php
session_start();
require_once('includes/functions.php');
$logged = (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) ? true : false; # check if you are logged in
$possible_categories = array("auction", "user", "seller", "statistics", "reset", "fill"); # all possible actions

# handle the login post request
if(!empty($_POST)) { # this login handling needs to be in some seperate file combined with the login.php
    if (isset($_POST["submit"]) && isset($_POST["username"]) && isset($_POST["password"])) {
        $user = getUser($_POST["username"]);
        if (password_verify($_POST["password"], $user['Wachtwoord']) && $user['Action'] == 1) {
            # log the user in as Admin
            createSession($user);
            $logged = true;
        } else {
            echo "unsuccessful login";
        }
    } else {
        # divide the post between different controllers
        if ($logged && isset($_POST['category']) && in_array($_POST['category'], $possible_categories)) {
            require_once('classes/controllers/admin/' . $_POST['category'] . 'Controller.php');
        }
    }
}

$title = "Admin page";
require_once('includes/header.php');

if($logged) {
    # get the corresponding view for the Action the admin wants to do
    if (isset($_GET['category']) && in_array($_GET['category'], $possible_categories)) {
        require_once('classes/views/admin/' . $_GET['category'] . 'View.php');
    } else { # if no action is selected, give the default view
        require_once('classes/views/adminView.php');
    }

} else {
    # if the admin isn't logged in, it needs to see the Admin login page
    require_once('classes/views/adminLoginView.php');
}

require_once('includes/footer.php');

