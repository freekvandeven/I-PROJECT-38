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

require_once('includes/header.php');

require_once('classes/views/forgotPasswordView.php');

require_once('includes/footer.php');