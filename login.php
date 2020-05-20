<?php
session_start();
require_once('includes/functions.php');
registerRequest();

if($_SESSION['loggedin']) header('Location: profile.php');
if (!empty($_GET) && isset($_GET['name']) && isset($_GET['hash'])) {
    $user = User::getUser($_GET['name']);
    if (!empty($user)) {
        if (hash("md5", $user['Wachtwoord']) == $_GET['hash']) {
            User::makeUser($_GET['name']);
            createSession(User::getUser($_GET['name']));
            header('Location: profile.php');
        }
    }
}

# handle the login post request
if (checkPost()) {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $user = User::getUser($_POST["username"]);
        if (password_verify($_POST["password"], $user['Wachtwoord'])) {
            if ($user['Bevestiging']) {
                createSession($user);
                header("Location: profile.php");
            } else $err = "please confirm your email";
        } else $err = "Incorrect password";
    } else $err = "please fill in all the data!";
}

$title = "Login pagina";
require_once('includes/header.php');

require_once('classes/views/loginView.php');

require_once('includes/footer.php');
