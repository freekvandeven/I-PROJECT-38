<?php
session_start();

//Bepaalt de vraag van de user:
/*$profile_data = User::getUser($_SESSION['name']);
foreach(User::getQuestion() as $question) {
    if($question['Vraagnummer'] == $profile_data['Vraag']) {
        $secretQuestion = $question['TekstVraag'];
    }
}*/


$title = "Forgot password";
require_once('includes/functions.php');
if(isset($_POST['email'])){
        if(User::validateEmail($_POST['email'])>0){
        $user = User::getUserWithEmail($_POST['email']);
        $vars['email'] = $_POST['email'];
        $vars['hash'] = hash("md5",$user['Wachtwoord']);
        sendFormattedMail($_POST['email'],"Password Reset","forgotPassword.html", $vars);
    }
}
if(isset($_GET['email'])&&isset($_GET['hash'])){
    $user = User::getUserWithEmail($_GET['email']);
    if($_GET['hash']==hash("md5",$user['Wachtwoord'])){
        createSession($user);
        header("Location: profile.php?action=update");
    }
}
require_once('includes/header.php');

require_once('classes/views/forgotPasswordView.php');

require_once('includes/footer.php');