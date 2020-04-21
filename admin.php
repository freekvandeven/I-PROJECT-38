<?php
session_start();
require_once('includes/functions.php');
if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
    $logged = true;
} else {
    $logged = false;
}
# handle the login post request
if(!empty($_POST)) {
    if (isset($_POST["submit"]) && isset($_POST["username"]) && isset($_POST["password"])) {
        $user = getUser($_POST["username"]);
        if (password_verify($_POST["password"], $user['Wachtwoord']) && $user['Action'] == 1) {
            createSession($user);
            $logged = true;
        } else {
            echo "unsuccessful login";
        }
    } else {
        echo "please fill in all the data!";
    }
}
$title = "Admin pagina";
require_once('includes/header.php');

if($logged) {
    require_once('classes/views/adminView.php');
} else {
    require_once('classes/views/adminLoginView.php');
}

require_once('includes/footer.php');

